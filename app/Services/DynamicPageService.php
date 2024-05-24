<?php

namespace App\Services;

use App\Enums\CommonStatusEnums;
use App\Models\Advertisement;
use App\Models\DynamicPage;
use App\Models\Nationality;
use App\Models\PremiumUserSetting;
use App\Models\User;

class DynamicPageService
{
    public function getPage(string $slug)
    {
        return DynamicPage::where('slug', '=', $slug)->first();
    }

    public function getAboutStatistic()
    {
        return [
            'pageContent' => $this->getPage('about-us'),
            'products' => Advertisement::count(),
            'users' => User::count(),
            'countries' => Nationality::where('status', '=', CommonStatusEnums::Active->value)->count()
        ];
    }

    public function getPremiumSetting()
    {
        return PremiumUserSetting::first();
    }
}