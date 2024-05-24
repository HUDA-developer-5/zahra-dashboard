<?php

namespace App\Services;

use App\Enums\CommonStatusEnums;
use App\Models\City;
use App\Models\Nationality;

class NationalityService
{
    public function listNationalities()
    {
        return Nationality::where('status', "=", CommonStatusEnums::Active->value)->orderBy('order')
            ->with(['states' => function ($query) {
                $query->where('status', '=', CommonStatusEnums::Active->value)
                    ->with(['cities' => function ($q) {
                        $q->where('status', '=', CommonStatusEnums::Active->value);
                    }]);
            }])
            ->get();
    }

    public function listToMenu()
    {
        return Nationality::where('status', "=", CommonStatusEnums::Active->value)->orderBy('order')->get();
    }

    public function listCitiesToFilter()
    {
        $countryId = session()->get('country_id');
        if (!$countryId && auth('users')->check()) {
            $countryId = auth('users')->user()->nationality_id;
        }

        return City::where('status', '=', CommonStatusEnums::Active->value)->where('nationality_id', '=', $countryId)->get();
    }
}