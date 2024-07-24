<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CurrencyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // get currency from header or default to SAR
        $currency = request()->header('currency-of-country', 'SAR');

        // filter by currency
        $builder->where('currency', $currency);

    }
}
