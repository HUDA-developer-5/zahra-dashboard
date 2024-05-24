<?php

namespace Database\Seeders;

use App\Enums\Advertisement\PremiumCommissionTypeEnums;
use App\Models\FreeCommission;
use App\Models\PremiumCommission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PremiumCommission::truncate();
        FreeCommission::truncate();

        PremiumCommission::create([
            'days' => 1,
            'type' => PremiumCommissionTypeEnums::Fixed->value,
            'commission' => 1,
        ]);

        PremiumCommission::create([
            'days' => 7,
            'type' => PremiumCommissionTypeEnums::Percentage->value,
            'commission' => 2,
        ]);

        PremiumCommission::create([
            'days' => 30,
            'type' => PremiumCommissionTypeEnums::Percentage->value,
            'commission' => 5,
        ]);

        PremiumCommission::create([
            'days' => 31,
            'type' => PremiumCommissionTypeEnums::Percentage->value,
            'commission' => 10,
        ]);

        FreeCommission::create([
            'days' => 1,
            'limit' => 3,
            'commission_percentage' => 3
        ]);
    }
}
