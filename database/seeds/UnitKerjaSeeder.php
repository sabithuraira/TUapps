<?php

use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder {
    public function run()
    {
        // DB::table('users')->delete();

        \App\UnitKerja::create(['kode' => '1601', 'nama'=>'Ogan Komering Ulu', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1602', 'nama'=>'Ogan Komering Ilir', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1603', 'nama'=>'Muara Enim', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1604', 'nama'=>'Lahat', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1605', 'nama'=>'Musi Rawas', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1606', 'nama'=>'Musi Banyuasin', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1607', 'nama'=>'Banyuasin', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1608', 'nama'=>'Ogan Komering Ulu Selatan', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1609', 'nama'=>'Ogan Komering Ulu Timur', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1610', 'nama'=>'Ogan Ilir', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1611', 'nama'=>'Empat Lawang', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1612', 'nama'=>'Penukal Lematang Abab Ilir', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1613', 'nama'=>'Musi Rawas Utara', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1671', 'nama'=>'Palembang', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1672', 'nama'=>'Prabumulih', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1673', 'nama'=>'Pagar Alam', 'created_by'=>1, 'updated_by'=>1]);
        \App\UnitKerja::create(['kode' => '1674', 'nama'=>'Lubuk Linggau', 'created_by'=>1, 'updated_by'=>1]);
    }
}