<?php
declare(strict_types=1);

namespace App\CurrencyRate;

use App\CurrencyRate\Exceptions\CrawlerException;

interface CrawlerInterface {

    /**
     * Return back crawled content page content.
     *
     * @param string $currencyFrom
     * @param string $currencyTo
     *
     * @return string
     * @throws CrawlerException
     */
    public function getContent(string $currencyFrom, string $currencyTo): string;
}
