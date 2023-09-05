<?php

namespace Database\Seeders;

use App\Models\Admin\Complaint\Classification;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classification::create([
            'name' => 'General Problem',
            'status' => 1,
        ]);
    }
}
