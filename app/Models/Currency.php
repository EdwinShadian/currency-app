<?php

declare(strict_types=1);

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string $short_name
 * @property string $full_name
 * @property string $rate_to_usd
 * @property DateTime $updated_at_date
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereRateToUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAtDate($value)
 * @mixin \Eloquent
 */
class Currency extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'short_name',
        'full_name',
        'rate_to_usd',
        'updated_at_date',
    ];
}
