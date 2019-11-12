<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Uk4TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['is_kabupaten' => 0, 'nama' => 'Kepala BPS Kabpaten/Kota', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 0, 'nama' => 'Subbagian Tata Usaha', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 0, 'nama' => 'Seksi Statistik Sosial', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 0, 'nama' => 'Seksi Statistik Produksi', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 0, 'nama' => 'Seksi Statistik Distribusi', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 0, 'nama' => 'Seksi Neraca Wilayah dan Analisis Statistik', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 0, 'nama' => 'Seksi Integrasi Pengolahan dan Diseminasi Statistik', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
        
            ['is_kabupaten' => 1, 'nama' => 'Kepala Provinsi', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            
            ['is_kabupaten' => 1, 'nama' => 'Kepala Bagian Tata Usaha', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Subbagian Bina Program', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Subbagian Kepegawaian & Hukum', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Subbagian Keuangan', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Subbagian Umum', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Subbagian Pengadaan Barang/Jasa', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            
            ['is_kabupaten' => 1, 'nama' => 'Kepala Bagian Statistik Sosial', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Statistik Kependudukan', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Ketahanan Sosial', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Kesejahteraan Rakyat', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            
            ['is_kabupaten' => 1, 'nama' => 'Kepala Bagian Statistik Produksi', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Statistik Pertanian', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Statistik Industri', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Statistik Pertambangan, Energi dan Konstruksi', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            
            ['is_kabupaten' => 1, 'nama' => 'Kepala Bagian Statistik Distribusi', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Statistik Harga Konsumen dan Harga Perdagangan Besar', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Statistik Keuangan dan Harga Produsen', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Statistik Niaga dan Jasa', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
           
            ['is_kabupaten' => 1, 'nama' => 'Kepala Bidang Neraca Wilayah dan Analisis Statistik', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),], 
            ['is_kabupaten' => 1, 'nama' => 'Seksi Neraca Produksi', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Neraca Konsumsi', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Analisis Statistik Lintas Sektor', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            
            ['is_kabupaten' => 1, 'nama' => 'Kepala Bidang Integrasi Pengolaahn dan Diseminasi Statistik', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Integrasi Pengolahan Data', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Jaringan dan Rujukan Statistik', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['is_kabupaten' => 1, 'nama' => 'Seksi Diseminasi dan Layanan Statistik', 'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
        ];

        foreach($datas as $key=>$value){
            DB::table('unit_kerja4')->insert($value);
        }
    }
}
