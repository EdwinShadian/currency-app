<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Currency;
use Tests\TestCase;

class CurrencyControllerTest extends TestCase
{
    /**
     * Проверяем, что возвращается список валют
     */
    public function testIndex(): void
    {
        $currencies = Currency::factory()->count(3)->create();

        $response = $this->get(route('api.currency.index'));
        $response->assertOk();

        $data = $this->getJsonData($response);

        $this->assertJson(json_encode($currencies), $data);
    }

    /**
     * Проверяем, что правильно считается курс одной валюты относительно другой
     */
    public function testRate(): void
    {
        $currencies = Currency::factory()->count(2)->create();

        $response = $this->get(
            route('api.currency.rate')
            .'?from='.$currencies->get(0)->short_name
            .'&to='.$currencies->get(1)->short_name
        );

        $response->assertOk();

        $data = $this->getJsonData($response);

        $assertedValue = [
            'rate' => bcdiv(
                $currencies->get(1)->rate_to_usd,
                $currencies->get(0)->rate_to_usd,
                6,
            ),
        ];

        $this->assertJson(json_encode($assertedValue), $data);
    }

    /**
     * Проверяем работу конвертации валют
     */
    public function testConvert(): void
    {
        $currencies = Currency::factory()->count(2)->create();
        $response = $this->post(route('api.currency.convert'), [
            'from' => $currencies->get(0)->short_name,
            'to'=> $currencies->get(1)->short_name,
            'amount' => '1000',
        ]);

        $response->assertOk();

        $data = $this->getJsonData($response);

        $convertedValue = bcmul(
            bcdiv($currencies->get(1)->rate_to_usd, $currencies->get(0)->rate_to_usd, 6),
            '1000',
            2,
        );

        $assertedValue = [
            $currencies->get(0)->short_name => '1000',
            $currencies->get(1)->short_name => $convertedValue,
        ];

        $this->assertJson(json_encode($assertedValue), $data);
    }
}
