<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('api_cates')->insert([
        //     'ac_name' => '베스트셀러'
        // ]);

        DB::table('api_cates')->insert([
            ['ac_name' => '신간 전체 리스트']
            ,['ac_name' => '베스트셀러']
        ]);
    }
}
