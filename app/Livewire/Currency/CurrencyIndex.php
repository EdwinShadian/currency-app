<?php

declare(strict_types=1);

namespace App\Livewire\Currency;

use App\Models\Currency;
use Livewire\Component;

class CurrencyIndex extends Component
{
    public function render()
    {
        return view('livewire.currency.currency-index')
            ->with(['currencies' => Currency::paginate(20)]);
    }
}
