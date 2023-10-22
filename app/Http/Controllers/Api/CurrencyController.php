<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyConvertRequest;
use App\Http\Requests\CurrencyIndexRequest;
use App\Http\Requests\CurrencyRateRequest;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    public function index(
        CurrencyIndexRequest $request,
        CurrencyService $currencyService,
    ) {
        return $currencyService->getList(
            $request->integer('perPage', 10),
            $request->integer('page', 1),
        );
    }

    public function rate(
        CurrencyRateRequest $request,
        CurrencyService $currencyService
    ) {
        $data = $request->validated();

        $rate = $currencyService->getRate($data['from'], $data['to']);

        return response()->api(['rate' => $rate]);
    }

    public function convert(
        CurrencyConvertRequest $request,
        CurrencyService $currencyService,
    ) {
        $data = $request->validated();

        $converted = $currencyService->convert(
            $data['from'],
            $data['to'],
            $data['amount'],
        );

        return response()->api([
            $data['from'] => $data['amount'],
            $data['to'] => $converted,
        ]);
    }
}
