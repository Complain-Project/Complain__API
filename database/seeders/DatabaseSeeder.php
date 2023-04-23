<?php

namespace Database\Seeders;

use Database\Seeders\Admins\DistrictTableSeeder;
use Database\Seeders\Admins\EmployeeTableSeeder;
use Database\Seeders\Admins\FakeSongsSeeder;
use Database\Seeders\Admins\PermissionGroupTableSeeder;
use Database\Seeders\Admins\PermissionTableSeeder;
use Database\Seeders\Admins\PermissionTypesTableSeeder;
use Database\Seeders\Admins\RoleTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            /* Admin::start */
            PermissionGroupTableSeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            EmployeeTableSeeder::class,
            PermissionTypesTableSeeder::class,
            DistrictTableSeeder::class
            /* Admin::end */
        ]);
    }
}
