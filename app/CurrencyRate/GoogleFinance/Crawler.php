<?php
declare(strict_types=1);

namespace App\CurrencyRate\GoogleFinance;

use App\CurrencyRate\CrawlerInterface;
use App\CurrencyRate\Exceptions\CrawlerException;

use function strtoupper;

class Crawler implements CrawlerInterface
{
    const BASE_URL = 'https://www.google.com/finance/quote/';

    /**
     * {@inheritDoc}
     */
    public function getContent(string $currencyFrom, string $currencyTo): string
    {
        $currencies = $this->getCurrencyUrlPart($currencyFrom, $currencyTo);
        $urlToParse = $this->getUrl($currencies);

        try {
            $pageContent = file_get_contents($urlToParse);
        } catch (\Throwable $e) {
            throw new CrawlerException('Cannot get page content.');
        }

        return $pageContent;
    }

    private function getCurrencyUrlPart(string $currencyFrom, string $currencyTo): string
    {
        $currencyFrom = strtoupper($currencyFrom);
        $currencyTo = strtoupper($currencyTo);

        return $currencyFrom . '-' . $currencyTo;
    }

    private function getUrl($currencies, $preventCaching = true)
    {
        $urlToParse = self::BASE_URL;
        $urlToParse .= $currencies;

        if ($preventCaching) {
            $urlToParse .= '?' . \date('YmdHi');
        }

        return $urlToParse;
    }
}
