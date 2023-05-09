# Well documented Makefiles
.DEFAULT_GOAL := help

help:
ifeq ($(shell ! test -f .env && echo -n yes),yes)
	make .env
endif
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z0-9_-]+:.*?##/ { printf "  \033[36m%-40s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

.PHONY := help setup install setup-init start migrate frontend frontend-watch stop destroy
SHELL = /bin/bash

## Get warden variables
ifeq ($(shell test -f .env && echo -n yes),yes)
include .env
export $(shell sed 's/=.*//' .env)
endif

PROJECT_NAME='Laravel currency exchange rate'

WARDEN_SHELL=warden env exec php-fpm
WEBUI_SHELL=warden env exec webui

################################################################################
# WebUI specific commands
################################################################################

frontend: ## Connect to webui container
	$(WEBUI_SHELL) bash

webui-rebuild: ## Rebuild webui container. Refresh WEBUI application.
	warden env kill webui && warden env start webui

webui-stop: ## Stop webui container. Stop WEBUI application.
	warden env stop webui

webui-start: ## Start webui container. Start WEBUI application.
	warden env start webui

webui-connect: frontend ## Connect to WEBUI container

webui/node_modules:
	$(WEBUI_SHELL) npm ci

################################################################################
# Pipeline/Deployment commands.
################################################################################

update-node-and-npm:
	npm cache clean -f
	npm install -g n npm
	n v18.15.0
	mv /usr/bin/node /usr/bin/node_old && cp -p /usr/local/bin/node /usr/bin/node

################################################################################
# Project installatoin commands
################################################################################

install: setup notify-success ## Install project and env to local machine

setup: setup-init start .env vendor

setup-init:
	warden svc up
	make sign-ssl

sign-ssl:
	warden sign-certificate ${TRAEFIK_SUBDOMAIN}.${TRAEFIK_DOMAIN}
	warden sign-certificate webui.${TRAEFIK_DOMAIN}
	warden sign-certificate *.${TRAEFIK_DOMAIN}

.env:
	@make generate-env

generate-env:
	@cp .warden/src/.env ./.env

vendor:
	make composer-i-dev

composer-i-dev:
	$(WARDEN_SHELL) bash -c "composer i --dev"

open-backend: ## Open frontend
	@open "${APP_URL}"

open-webui: ## Open WebUI
	@open "https://${VITE_WEBUI_DOMAIN}/"

notify-success: notify-success-by-voice-message

notify-success-by-voice-message:
	@$(shell echo "The ${PROJECT_NAME} setup has complete!" > /tmp/warden.msg)
	@make pronounce-message > /tmp/warden.log 2>&1

pronounce-message:
ifneq (, $(shell which say)) # Notification for Mac users
	say -v 'Samantha' < /tmp/warden.msg
endif
ifneq (, $(shell which spd-say)) # Notification for Ubuntu users
	spd-say < /tmp/warden.msg
endif

clean-all: cache-clear queue-flush route-clear flush-redis ## Clean all caches, queues, route-caches

cache-clear: ## Flush Laravel cache
	@$(WARDEN_SHELL) ./artisan cache:clear | echo "Info: ./artisan cache:clear"

queue-flush: ## Flush queue
	@$(WARDEN_SHELL) ./artisan queue:flush | echo "Info: ./artisan queue:flush"

route-clear: ## Flush route
	@$(WARDEN_SHELL) ./artisan route:clear | echo "Info: ./artisan route:clear"

flush-redis: ## Flush All Redis caches
	warden env exec -T redis redis-cli flushall

flush: flush-redis ## Hard-reset cache flush

purge: flush

################################################################################
# DB related commands
################################################################################

migrate: recreate-db ## Recreate all tables and records

refresh-db-data: recreate-db ## Recreate all tables and records

recreate-db: ## Recreate all tables and records
	@$(WARDEN_SHELL) sh -c "./artisan migrate:fresh && ./artisan db:seed"

################################################################################
# Containers managment commands
################################################################################

up: start ## Start local development environment

run: start ## Start local development environment

start: ## Start a configured development environment
	warden svc up
	ssh-add ~/.warden/tunnel/ssh_key | true # It will allow us to connect to the DB's containers provisioned by Warden. `ssh -p 2222 user@127.0.0.1`
	warden env up

stop: ## Stop the development environment
	warden env stop

down: ## Stop local development environment but leave DNSMASQ to work
	warden env down

down-all: ## Stop local development environment
	warden env down
	warden svc down

uninstall: destroy ## Uninstall project from the local machine

destroy: ## Completely destroy the development environment, removing the environment data
	warden env down --volumes --remove-orphans
	rm -rf ./node_modules .env ./vendor
	rm -rf ./webui/node_modules .env

wsphp: ## Open php container CLI (command line)
	warden shell

wsdb: ## Open db container CLI (command line)
	warden env exec db bash

wsredis: ## Open redis container CLI (command line)
	warden env exec redis sh

watchlog: ## Print out nginx and php-fpm logs
	warden env logs --tail 0 -f nginx php-fpm php-debug

################################################################################
# CRON commands
################################################################################

cron-enable: ## Enable cron processing
	@sed -i '' -e 's/.*artisan schedule:run.*/\* \* \* \* \* \/bin\/bash \-c \"cd \/var\/www\/html \&\& php artisan schedule:run 2\>\&1 \>\> \/var\/www\/html\/storage\/logs\/cron.log\"/' .warden/etc/crontab
	@warden env up -d --remove-orphans --force-recreate php-fpm
	@$(WARDEN_SHELL) bash -c 'sudo chown root. /var/spool/cron/crontabs/www-data ; sudo chmod 0600 /var/spool/cron/crontabs/www-data'
	@echo "Cron enabled"

cron-disable: ## Disable cron processing
	@sed -i '' -e 's/.*artisan schedule:run.*/#\* \* \* \* \* \/bin\/bash \-c \"cd \/var\/www\/html \&\& php artisan schedule:run 2\>\&1 \>\> \/var\/www\/html\/storage\/logs\/cron.log\"/' .warden/etc/crontab
	@warden env up -d --remove-orphans --force-recreate php-fpm
	@echo "Cron disabled"
