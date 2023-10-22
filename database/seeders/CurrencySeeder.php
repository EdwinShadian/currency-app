<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currenciesFile = file_get_contents(__DIR__.'/data/currencies.json');
        $currencies = json_decode($currenciesFile, true);

        $date = now()->toDate();

        foreach ($currencies as $shortName => $fullName) {
            Currency::create([
                'short_name' => $shortName,
                'full_name' => $fullName,
                'rate_to_usd' => '1',
                'updated_at_date'=> $date,
            ]);
        }
    }
}
