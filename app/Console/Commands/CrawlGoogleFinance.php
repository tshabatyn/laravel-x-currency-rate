<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\CurrencyRate\CommonProcessor;
use App\CurrencyRate\CrawlerInterface;
use App\CurrencyRate\GoogleFinance\Crawler;
use App\CurrencyRate\GoogleFinance\Parser;
use App\CurrencyRate\ParserInterface;
use App\CurrencyRate\ProcessorInterface;
use Illuminate\Console\Command;

class CrawlGoogleFinance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl:google-finance {from-currency} {to-currency}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Currency Rate from Google Finance';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $fromCurrency = $this->argument('from-currency');
        $toCurrency = $this->argument('to-currency');

        $this->getProcessor()->process($fromCurrency, $toCurrency);
    }

    /**
     * @return ProcessorInterface
     */
    public function getProcessor(): CommonProcessor
    {
        return new CommonProcessor($this->getCrawler(), $this->getParser(),);
    }

    /**
     * @return CrawlerInterface
     */
    public function getCrawler(): Crawler
    {
        return new Crawler();
    }

    /**
     * @return ParserInterface
     */
    private function getParser(): Parser
    {
        return new Parser();
    }
}
