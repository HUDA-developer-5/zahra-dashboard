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
        $country_key = request()->header('country-key', 'SA');
        $currency = $country_key == 'SA' ? 'SAR' : ($country_key == 'EG' ? 'EGP' : 'AED');


        //Egypt == (country_id = 1) & KSA == (country_id = 2) & UAE == (country_id = 3)
        if (session()->has('country_id')) {
            $currency = session()->get('country_id') == '1' ? 'EGP' : (session()->get('country_id') == '2' ? 'SAR' : 'AED');
        }

        // filter by currency
        $builder->where('currency', $currency);

    }
}
