<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencyRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rates = [
            ["date" => "2023-04-05", "rate" => 1.09045],
            ["date" => "2023-04-06", "rate" => 1.091955],
            ["date" => "2023-04-07", "rate" => 1.09955],
            ["date" => "2023-04-08", "rate" => 1.09945],
            ["date" => "2023-04-09", "rate" => 1.09135],
            ["date" => "2023-04-10", "rate" => 1.086895],
            ["date" => "2023-04-11", "rate" => 1.0917],
            ["date" => "2023-04-12", "rate" => 1.099785],
            ["date" => "2023-04-13", "rate" => 1.105115],
            ["date" => "2023-04-14", "rate" => 1.11035],
            ["date" => "2023-04-15", "rate" => 1.11025],
            ["date" => "2023-04-16", "rate" => 1.09835],
            ["date" => "2023-04-17", "rate" => 1.0926],
            ["date" => "2023-04-18", "rate" => 1.097565],
            ["date" => "2023-04-19", "rate" => 1.09525],
            ["date" => "2023-04-20", "rate" => 1.096815],
            ["date" => "2023-04-21", "rate" => 1.10965],
            ["date" => "2023-04-22", "rate" => 1.10965],
            ["date" => "2023-04-23", "rate" => 1.09935],
            ["date" => "2023-04-24", "rate" => 1.10575],
            ["date" => "2023-04-25", "rate" => 1.097875],
            ["date" => "2023-04-26", "rate" => 1.10445],
            ["date" => "2023-04-27", "rate" => 1.103175],
            ["date" => "2023-04-28", "rate" => 1.11285],
            ["date" => "2023-04-29", "rate" => 1.11275],
            ["date" => "2023-04-30", "rate" => 1.101055],
            ["date" => "2023-05-01", "rate" => 1.09676],
            ["date" => "2023-05-02", "rate" => 1.101055],
            ["date" => "2023-05-03", "rate" => 1.106855],
            ["date" => "2023-05-04", "rate" => 1.10225],
            ["date" => "2023-05-05", "rate" => 1.12115],
            ["date" => "2023-05-06", "rate" => 1.121],
        ];

        $f = \App\Models\CurrencyRate::factory();
        foreach ($rates as $rate) {
            $f->create(
                [
                    'from' => 'EUR',
                    'to' => 'USD',
                    'rate' => $rate['rate'],
                    'date' => $rate['date'],
                ]
            );
        }
    }
}
