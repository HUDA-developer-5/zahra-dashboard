<?php

namespace Database\Seeders;

use App\Enums\AdminRolesEnums;
use App\Enums\AdminStatusEnums;
use App\Enums\AdminTypesEnums;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddDefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            [
                'email' => "admin@zahra.com",
            ],
            [
                'name' => "Super Admin",
                'phone_number' => "0111112",
                'password' => bcrypt('P@ssword!123'),
                'status' => AdminStatusEnums::Active->value,
                'type' => AdminTypesEnums::Admin->value,
                'role' => AdminRolesEnums::Super_Admin->value
            ]
        );
    }
}
