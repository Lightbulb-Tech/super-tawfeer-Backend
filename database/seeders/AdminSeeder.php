<?php

namespace Database\Seeders;

use App\Enums\AdminTypeisEnum;
use App\Models\TamoTech\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '01204638849',
            'password' => Hash::make(123456),
            'admin_type' => AdminTypeisEnum::SuperAdmin->value,
            'image' => 'adminImages\userImage.png'
        ]);
        Admin::create([
            'name' => 'developer',
            'email' => 'dev@dev.com',
            'phone' => '01024030075',
            'password' => Hash::make(123456),
            'admin_type' => AdminTypeisEnum::Developer->value,
            'image' => 'adminImages\userImage.png'
        ]);
    }
}
