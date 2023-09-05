<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_has_permissions')->insert([
            [
                'permission_id' => 2,
                'role_id' => 1,
            ],
            [
                'permission_id' => 38,
                'role_id' => 2,
            ],
            [
                'permission_id' => 61,
                'role_id' => 2,
            ],
            [
                'permission_id' => 32,
                'role_id' => 3,
            ],
        ]);


        DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ],

        ]);
    }
}
