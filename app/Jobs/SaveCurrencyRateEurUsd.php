<?php

namespace App\Jobs;

use App\CurrencyRate\CommonProcessor;
use App\CurrencyRate\CrawlerInterface;
use App\CurrencyRate\GoogleFinance\Crawler;
use App\CurrencyRate\GoogleFinance\Parser;
use App\CurrencyRate\ParserInterface;
use App\CurrencyRate\ProcessorInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveCurrencyRateEurUsd implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $from = 'EUR';
        $to = 'USD';
        $currencyRateFactory =\App\Models\CurrencyRate::factory();
        $currencyRateFactory->create(
            [
                'from' => $from,
                'to' => $to,
                'rate' => $this->getProcessor()->getCurrencyRate($from, $to),
                'date' => \date('Y-m-d'),
            ]
        );
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
