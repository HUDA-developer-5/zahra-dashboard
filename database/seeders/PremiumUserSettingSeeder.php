<?php

namespace Database\Seeders;

use App\Models\PremiumUserSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PremiumUserSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PremiumUserSetting::truncate();
        PremiumUserSetting::create([
            'price' => 2000,
            'duration_in_months' => 12,
            'premium_ads_percentage' => 2,
            'premium_ads_count' => 5,
        ]);
    }
}
