<?php

namespace Database\Seeders;

use FTP\Connection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Settings\Area;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            [
                'id' => 1,
                'name' => 'Dhaka',
                'code' => 'Dhaka-22',
                'status' => 1,
            ],
        ]);

        DB::table('connection_types')->insert([
            [
                'id' => 1,
                'name' => 'Optical Fiber',
                'code' => 'OP-22',
                'status' => 1,
            ],
        ]);

        DB::table('packages')->insert([
            [
                'id' => 1,
                'connection_type_id' => 1,
                'name' => 'Regular Package',
                'package_spreed' => '5 MB',
                'code' => 'RP-22',
                'amount' => 1000,
                'status' => 1,
            ],
        ]);

        DB::table('identities')->insert([
            [
                'id' => 1,
                'name' => 'NID',
                'status' => 1,
            ],
        ]);

        DB::table('devices')->insert([
            [
                'id' => 1,
                'name' => 'Onu',
                'status' => 1,
            ],
        ]);

        DB::table('banks')->insert([
            [
                'id' => 1,
                'name' => 'Bangladesh Bank',
                'status' => 1,
            ],
        ]);

        DB::table('account_types')->insert([
            [
                'id' => 1,
                'name' => 'Business Account',
                'status' => 1,
            ],
        ]);

        DB::table('accounts')->insert([
            [
                'id' => 1,
                'bank_id' => 1,
                'account_type_id' => 1,
                'name' => 'Wardan Tech Ltd',
                'account_no' => '123.123.123',
                'branch_name' => 'Bangladesh Branch',
                'branch_address' => 'Dhaka, Bangladesh',
                'initial_balance' => 00,
                'status' => 1,
            ],
        ]);

        DB::table('subscriber_categories')->insert([
            [
                'id' => 1,
                'name' => 'General',
                'status' => 1,
            ],
        ]);

        DB::table('banner_settings')->insert([
            [
                'id' => 1,
                'color' => '#37517e',
                'title_color' => '#37517e',
                'text_color' =>'#ffffff',
            ],
        ]);

    }
}
