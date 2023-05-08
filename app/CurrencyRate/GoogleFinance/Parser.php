<?php
declare(strict_types=1);

namespace App\CurrencyRate\GoogleFinance;

use App\CurrencyRate\Exceptions\ParserException;
use App\CurrencyRate\ParserInterface;

class Parser implements ParserInterface
{
    const CURRENCY_RATE_VALUE_XPATH = '//body/c-wiz/div/div[4]/div/main/div[2]/div[1]/c-wiz/div/div[1]/div/div[1]/div/div[1]/div/span/div/div';

    /**
     * {@inheritDoc}
     *
     * @note $currencyFrom and $currencyTo - are omitted in this type of parser.
     *       You may configure Currencies in the \App\CurrencyRate\GoogleFinance\Crawler class.
     */
    public function getCurrencyRate(string $crawledContent, string $currencyFrom, string $currencyTo): float
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($crawledContent, LIBXML_NOERROR);

        $domParser = new \DOMXPath($dom);
        $value = $domParser->evaluate('string(' . self::CURRENCY_RATE_VALUE_XPATH . ')');

        if (!$value) {
            throw new ParserException('Cannot find currency rate.');
        }

        return (float)$value;
    }
}
