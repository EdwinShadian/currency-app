<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Currency;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CurrencyService
{
    public function getList(int $perPage, int $page): LengthAwarePaginator
    {
        return Currency::paginate($perPage, ['*'], 'page', $page);
    }

    public function getRate(string $from, string $to): string
    {
        $fromCurrency = Currency::where('short_name', $from)->first();
        $toCurrency = Currency::where('short_name', $to)->first();

        if (null === $fromCurrency || null === $toCurrency) {
            throw new NotFoundHttpException('Currency not found', null, 404);
        }

        return bcdiv($toCurrency->rate_to_usd, $fromCurrency->rate_to_usd, 6);
    }

    public function convert(string $from, string $to, string $amount): string
    {
        $exchangeRate = $this->getRate($from, $to);

        return bcmul($exchangeRate, $amount, 2);
    }

    public function updateRates(array $rates, string $date): void
    {
        $query = 'UPDATE currencies SET rate_to_usd = CASE ';

        foreach ($rates as $currencyCode => $rate) {
            $query .= "WHEN short_name = '$currencyCode' THEN $rate ";
        }

        $currenciesList = implode("','", array_keys($rates));

        $query .= "END, updated_at_date = '$date' WHERE short_name IN ('$currenciesList')";

        DB::update($query);
    }
}
