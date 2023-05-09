<?php

declare(strict_types=1);

namespace App\CurrencyRate;

use App\CurrencyRate\Exceptions\CrawlerException;
use App\CurrencyRate\Exceptions\ParserException;
use Exception;
use Throwable;

class CommonProcessor implements ProcessorInterface
{
    /** @var int Max number of attempts to retrieve the currency rate */
    const MAX_ATTEMPTS = 5;

    /** @var int Delay in seconds, before the next attempt */
    const DELAY_BETWEEN_ATTEMPTS = 5;

    private CrawlerInterface $crawler;
    private ParserInterface $parser;

    public function __construct(
        CrawlerInterface $crawler,
        ParserInterface $parser
    ) {
        $this->crawler = $crawler;
        $this->parser = $parser;
    }

    /**
     * {@inheritDoc}
     */
    public function process(string $fromCurrency, string $toCurrency): string
    {
        try {
            $currencyRate = $this->getCurrencyRate($fromCurrency, $toCurrency);
        } catch (Throwable) {
            $currencyRate = '--.--';
        }
        return "Currency rate $fromCurrency - $toCurrency:\n\t$currencyRate\n";
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrencyRate(string $fromCurrency, string $toCurrency, int $attempt = 0): float
    {
        $rate = 1.0;
        $this->makeDelay($attempt);
        $this->ensureAttemptIsAllowed($attempt);

        if ($fromCurrency !== $toCurrency) {
            try {
                $content = $this->crawler->getContent($fromCurrency, $toCurrency);
                $rate = $this->parser->getCurrencyRate($content, $fromCurrency, $toCurrency);
            } catch (CrawlerException | ParserException) {
                $rate = $this->getCurrencyRate($fromCurrency, $toCurrency, $attempt + 1);
            }
        }

        return $rate;
    }

    /**
     * @param mixed $attempts
     *
     * @return void
     */
    private function makeDelay(mixed $attempts): void
    {
        if ($attempts && $attempts < self::MAX_ATTEMPTS) {
            \sleep(self::DELAY_BETWEEN_ATTEMPTS);
        }
    }

    /**
     * @param mixed $attempts
     *
     * @return void
     * @throws Exception
     */
    private function ensureAttemptIsAllowed(mixed $attempts): void
    {
        if ($attempts >= self::MAX_ATTEMPTS) {
            throw new Exception('Cannot obtain currency rate, after ' . $attempts . ' attempts.');
        }
    }
}
