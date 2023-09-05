<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Role();
        $data->id = 1;
        $data->name = 'Super Admin';
        $data->guard_name = 'web';
        $data->save();

        $client = new Role();
        $client->id = 2;
        $client->name = 'Client';
        $client->guard_name = 'web';
        $client->save();

        $staff = new Role();
        $staff->id = 3;
        $staff->name = 'Staff';
        $staff->guard_name = 'web';
        $staff->save();
    }
}
