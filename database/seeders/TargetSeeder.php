<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('targets')->insert([
            'target'=>"学部1年生",
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime(),
            'deleted_at'=>null,
        ]);
        DB::table('targets')->insert([
            'target'=>"学部2年生",
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime(),
            'deleted_at'=>null,
        ]);
        DB::table('targets')->insert([
            'target'=>"学部3年生",
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime(),
            'deleted_at'=>null,
        ]);
        DB::table('targets')->insert([
            'target'=>"学部4年生",
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime(),
            'deleted_at'=>null,
        ]);
        DB::table('targets')->insert([
            'target'=>"修士1年生",
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime(),
            'deleted_at'=>null,
        ]);
        DB::table('targets')->insert([
            'target'=>"修士2年生",
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime(),
            'deleted_at'=>null,
        ]);
    }
}
