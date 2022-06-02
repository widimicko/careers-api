<?php

namespace Database\Seeders;

use App\Models\Recruitment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecruitmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Recruitment::factory(200)->create();
    }
}
