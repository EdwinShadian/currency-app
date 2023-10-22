<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\CurrencyService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Log;

class UpdateRates extends Command
{
    private const FIXER_URL = 'http://data.fixer.io/api';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates currencies rates from fixer.io';

    /**
     * Execute the console command.
     */
    public function handle(Client $client, CurrencyService $currencyService): void
    {
        $this->info('Updating rates...');

        $currenciesList = implode(',', Currency::select('short_name')->pluck('short_name')->toArray());
        $apiKey = env('FIXER_API_KEY');

        try {
            $response = $client->request(
                'GET',
                self::FIXER_URL."/latest?access_key=$apiKey&cbase=USD&symbols=$currenciesList"
            );

            $data = json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $e) {
            $msg = $e->getMessage();
            $this->error("Network error: $msg");
            Log::error("Rates updating failed: Network error: $msg");

            die();
        }

        $rates = $data['rates'] ?? null;
        $date = $data['date'] ?? null;

        if (null === $rates || null === $date) {
            $msg = $data['error']['type'];
            $this->error("Failed to get rates from fixer.io: $msg");
            Log::error("Rates updating failed: Failed to get rates from fixer.io: $msg");

            die();
        }

        $currencyService->updateRates($rates, $date);

        $this->info('Rates are updated!');
    }
}
