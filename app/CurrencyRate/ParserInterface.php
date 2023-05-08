<?php
declare(strict_types=1);

namespace App\CurrencyRate;

use App\CurrencyRate\Exceptions\ParserException;

interface ParserInterface {

    /**
     * Parse HTML Page content and return back Currency Rate.
     *
     * @param string $crawledContent
     * @param string $currencyFrom
     * @param string $currencyTo
     *
     * @return float
     * @throws ParserException
     */
    public function getCurrencyRate(string $crawledContent, string $currencyFrom, string $currencyTo): float;
}
