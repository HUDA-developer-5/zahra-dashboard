<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AddDefaultAdminSeeder::class);
        $this->call(CommissionSeeder::class);
//        $this->call(UsersTableSeeder::class);
//        $this->call(AdvertisementsTableSeeder::class);
        $this->call(DynamicPageTableSeeder::class);
//        $this->call(NationalitiesSeeder::class);
        $this->call(PremiumUserSettingSeeder::class);
    }
}
