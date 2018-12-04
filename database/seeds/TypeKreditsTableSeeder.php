<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TypeKreditsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_kredits')->insert([
            'uraian' => 'Pranata Komputer Terampil','created_by'=>1, 'updated_by'=>1, 
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('type_kredits')->insert([
            'uraian' => 'Pranata Komputer Ahli','created_by'=>1, 'updated_by'=>1, 
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('type_kredits')->insert([
            'uraian' => 'Statistisi Terampil','created_by'=>1, 'updated_by'=>1, 
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('type_kredits')->insert([
            'uraian' => 'Statistisi Ahli','created_by'=>1, 'updated_by'=>1, 
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
