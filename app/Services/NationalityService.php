<?php

namespace App\Services;

use App\Enums\CommonStatusEnums;
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
}