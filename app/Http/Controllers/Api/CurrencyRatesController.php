<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CurrencyRatesController extends Controller
{
    // expire key after 600 sec (10 min * 60 seconds)
    const CACHE_TTL_FOR_DAY = 600;
    // expire key after 43200 sec (12 hours * 60 min * 60 seconds)
    const CACHE_TTL_FOR_MONTH = 43200;

    /**
     * Reply with the today's currency rate.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function today(Request $request)
    {
        $currencies = $request->get('currencies');
        [$from, $to] = explode('-', $currencies);

        $key = $this->generateCacheKey('today', $from, $to);
        $todayRate = Cache::get($key);

        if ($todayRate) {
            $todayRate = \json_decode($todayRate, JSON_OBJECT_AS_ARRAY);
        } else {
            $todayRate = $this->loadFromDbTodayRates($from, $to, $currencies);
            Cache::add($key, \json_encode($todayRate), self::CACHE_TTL_FOR_DAY);
        }

        return response($todayRate, 200);
    }

    /**
     * Reply with the currency rates for past month.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function month(Request $request)
    {
        $currencies = $request->get('currencies');
        [$from, $to] = explode('-', $currencies);

        $key = $this->generateCacheKey('month', $from, $to);
        $numOfDaysInPastMonth = \cal_days_in_month(CAL_GREGORIAN, \date('n') - 1, \date('Y'));

        $monthRate = Cache::get($key);

        if ($monthRate) {
            $monthRate = \json_decode($monthRate, JSON_OBJECT_AS_ARRAY);
        } else {
            $monthRate = $this->loadFromDbPastMonthRates($from, $to, $numOfDaysInPastMonth);
            Cache::add($key, \json_encode($monthRate), self::CACHE_TTL_FOR_MONTH);
        }

        return response($monthRate, 200);
    }

    /**
     * @param string $method
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    private function generateCacheKey(string $method, string $from, string $to): string
    {
        $key = 'cr:' . $method . ':' . $from . '-' . $to . ':' . \date('Y-m-d');

        return $key;
    }

    /**
     * @param string $from
     * @param string $to
     * @param mixed $currencies
     *
     * @return array
     */
    private function loadFromDbTodayRates(string $from, string $to, mixed $currencies): array
    {
        $table = DB::table('currency_rates');
        $currencyRate = $table
            ->where(
                [
                    ['from', '=', $from],
                    ['to', '=', $to],
                ]
            )
            ->orderBy('date', 'desc')
            ->first()
        ;

        return ["currencies" => $currencies, "rate" => $currencyRate->rate];
    }

    /**
     * @param string $from
     * @param string $to
     * @param int $numOfDaysInPastMonth
     *
     * @return string[]
     */
    private function loadFromDbPastMonthRates(string $from, string $to, int $numOfDaysInPastMonth): array
    {
        $response = [
            "currencies" => "$from-$to",
        ];

        $table = DB::table('currency_rates');
        $currencyRates = $table
            ->where(
                [
                    ['from', '=', $from],
                    ['to', '=', $to],
                ]
            )
            ->orderBy('date', 'desc')
            ->offset(1)
            ->limit($numOfDaysInPastMonth + 1)
            ->get(['date', 'rate'])
        ;

        $response['rates'] = $currencyRates;

        return $response;
    }
}
