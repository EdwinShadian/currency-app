<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Currency;
use App\Services\CurrencyService;
use Tests\TestCase;

class CurrencyServiceTest extends TestCase
{
    /**
     * Проверяем, что возвращается пагинированный список
     */
    public function testGetList(): void
    {
        $currencies = Currency::factory()->count(2)->create();
        $service = new CurrencyService();

        $paginated = $service->getList(10, 1);
        $this->assertEquals(1, $paginated->currentPage());
        $this->assertEquals(10, $paginated->perPage());
        $this->assertEquals(2, count($paginated->items()));

        foreach ($paginated->items() as $key => $item) {
            $this->assertInstanceOf(Currency::class, $item);
            $this->assertEquals($currencies->get($key)->id, $item->id);
            $this->assertEquals($currencies->get($key)->short_name, $item->short_name);
            $this->assertEquals($currencies->get($key)->full_name, $item->full_name);
            $this->assertEquals($currencies->get($key)->rate_to_usd, $item->rate_to_usd);
        }
    }

    /**
     * Проверяем, что корректно считает курс
     */
    public function testGetRate(): void
    {
        $currencies = Currency::factory()->count(2)->create();
        $service = new CurrencyService();

        $rate = $service->getRate($currencies->get(0)->short_name, $currencies->get(1)->short_name);

        $this->assertEquals(
            bcdiv($currencies->get(1)->rate_to_usd, $currencies->get(0)->rate_to_usd, 6),
            $rate,
        );
    }

    /**
     * Проверяем, что конвертация работает корректно
     */
    public function testConvert(): void
    {
        $currencies = Currency::factory()->count(2)->create();
        $service = new CurrencyService();

        $converted = $service->convert(
            $currencies->get(0)->short_name,
            $currencies->get(1)->short_name,
            '1000'
        );

        $this->assertEquals(
            bcmul(
                bcdiv($currencies->get(1)->rate_to_usd, $currencies->get(0)->rate_to_usd, 6),
                '1000',
                2,
            ),
            $converted,
        );
    }

    /**
     * Проверяем обновление курсов валют
     */
    public function testUpdateRates(): void
    {
        $currencies = Currency::factory()->count(2)->create();
        $service = new CurrencyService();

        $updatedRates = [
            $currencies->get(0)->short_name => '0.1',
            $currencies->get(1)->short_name => '0.2',
        ];

        $date = now()->toDateString();

        $service->updateRates($updatedRates, $date);

        $updatedCurrencies = Currency::whereIn('short_name', array_keys($updatedRates))->get();

        $this->assertEquals('0.1', $updatedCurrencies->get(0)->rate_to_usd);
        $this->assertEquals('0.2', $updatedCurrencies->get(1)->rate_to_usd);
    }
}
