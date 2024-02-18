<?php

namespace App\Services;

use App\Enums\CommonStatusEnums;
use App\Models\Country;

class CountryService
{
    public function listCountries()
    {
        return Country::where('status', "=", CommonStatusEnums::Active->value)->orderBy('order')->get();
    }
}