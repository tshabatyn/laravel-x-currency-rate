<?php
declare(strict_types=1);

namespace App\CurrencyRate;

interface ProcessorInterface
{
    /**
     * Get and persist Currency Rate
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     *
     * @return string
     */
    public function process(string $fromCurrency, string $toCurrency): string;

    /**
     * Retrieve current currency rate between given currencies.
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param int $attempts
     *
     * @return float
     * @throws \Exception
     */
    public function getCurrencyRate(string $fromCurrency, string $toCurrency, int $attempt = 0): float;
}
