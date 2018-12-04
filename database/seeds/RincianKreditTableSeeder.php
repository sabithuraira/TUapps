<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RincianKreditTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1. prakom terampil, 2. prakom ahli 3. stat terampil 4. stat ahli

        //PRAKOM TERAMPIL
        $prakom_terampil = [
            ['jenis' => 1, 'kode' => 'I.', 'uraian' => 'PENDIDIKAN', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'I.A.', 'uraian' => 'Pendidikan Sekolah dan Memperoleh Ijazah/Gelar', 
                'induk'=>'I.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'I.B.', 'uraian' => 'Pendidikan dan Pelatihan Fungsional di Bidang Kepranataan Komputer dan Memperoleh Surat Tanda Tamat Pendidikan dan Pelatihan', 
                'induk'=>'I.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['jenis' => 1, 'kode' => 'II.', 'uraian' => 'OPERASI TEKNOLOGI INFORMASI ', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'II.A.', 'uraian' => 'Pengoperasian Komputer', 
                'induk'=>'II.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'II.B.', 'uraian' => 'Perekaman Data', 
                'induk'=>'II.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'II.C.', 'uraian' => ' Pemasangan dan Pemeliharaan Sistem Komputer dan Sistem Jaringan Komputer', 
                'induk'=>'II.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['jenis' => 1, 'kode' => 'III.', 'uraian' => ' IMPLEMENTASI TEKNOLOGI INFORMASI', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'III.A.', 'uraian' => 'Pemrograman Dasar', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'III.B.', 'uraian' => 'Pemrograman Menengah ', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'III.A.', 'uraian' => 'Pemrograman Lanjutan', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'III.A.', 'uraian' => 'Penerapan Sistem Operasi Komputer ', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['jenis' => 1, 'kode' => 'IV.', 'uraian' => 'PENGEMBANGAN PROFESI', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),], 
            ['jenis' => 1, 'kode' => 'IV.A.', 'uraian' => 'Pembuatan Karya Tulis/Karya Ilmiah di Bidang Teknologi Informasi', 
                'induk'=>'IV.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'IV.B.', 'uraian' => 'Penyusunan Petunjuk Teknis Pelaksanaan Pengelolaan Kegiatan Teknologi Informasi', 
                'induk'=>'IV.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'IV.C.', 'uraian' => 'Penerjemahan/Penyaduran Buku dan Bahan-Bahan Lain di Bidang Teknologi Informasi', 
                'induk'=>'IV.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['jenis' => 1, 'kode' => 'V.', 'uraian' => 'PENDUKUNG KEGIATAN PRANATA KOMPUTER', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),], 
            ['jenis' => 1, 'kode' => 'V.A.', 'uraian' => 'Pengajar/Pelatih di Bidang Teknologi Informasi', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'V.B.', 'uraian' => 'Peran Serta Dalam Seminar/Lokakarya/Konferensi', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'V.C.', 'uraian' => 'Keanggotaan dalam Tim Penilai Angka Kredit Jabatan Fungsional Pranata Komputer', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'V.D.', 'uraian' => 'Keanggotaan dalam Organisasi Profesi', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'V.E.', 'uraian' => ' Perolehan Piagam Kehormatan', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 1, 'kode' => 'V.F.', 'uraian' => 'Perolehan Gelar Kesarjanaan Lainnya', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
        ];

        $prakom_ahli = [
            ['jenis' => 2, 'kode' => 'I.', 'uraian' => 'PENDIDIKAN', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'I.A.', 'uraian' => 'Pendidikan Sekolah dan Memperoleh Ijazah/Gelar', 
                'induk'=>'I.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'I.B.', 'uraian' => ' Pendidikan dan Pelatihan Fungsional di Bidang Kepranataan Komputer dan Memperoleh Surat Tanda Tamat Pendidikan dan Pelatihan', 
                'induk'=>'I.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            
            ['jenis' => 2, 'kode' => 'II.', 'uraian' => 'IMPLEMENTASI SISTEM INFORMASI', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'II.A.', 'uraian' => 'Implementasi Sistem Komputer dan Program Paket', 
                'induk'=>'II.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'II.B.', 'uraian' => 'Implementasi Database', 
                'induk'=>'II.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'II.C.', 'uraian' => 'Implementasi Sistem Jaringan Komputer', 
                'induk'=>'II.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],


            ['jenis' => 2, 'kode' => 'III.', 'uraian' => 'ANALISIS DAN PERANCANGAN SISTEM INFORMASI', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'III.A.', 'uraian' => 'Analisis Sistem Informasi', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'III.B.', 'uraian' => 'Perancangan Sistem Informasi', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'III.C.', 'uraian' => 'Perancangan Sistem Komputer', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'III.D.', 'uraian' => 'Perancangan dan Pengembangan Database', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'III.E.', 'uraian' => 'Perancangan Sistem Jaringan Komputer', 
                'induk'=>'III.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],


            ['jenis' => 2, 'kode' => 'IV.', 'uraian' => 'PENYUSUNAN KEBIJAKAN SISTEM INFORMASI', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'IV.A.', 'uraian' => 'Perencanaan dan Pengembangan Sistem Informasi', 
                'induk'=>'IV.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'IV.B.', 'uraian' => 'Perumusan Visi, Misi, dan Strategi Informasi', 
                'induk'=>'IV.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],


            ['jenis' => 2, 'kode' => 'V.', 'uraian' => 'PENGEMBANGAN PROFESI', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'V.A.', 'uraian' => 'Pembuatan Karya Tulis/Karya Ilmiah di Bidang Teknologi Informasi', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'V.B.', 'uraian' => 'Penyusunan Petunjuk Teknis Pelaksanaan Pengelolaan Kegiatan Teknologi Informasi', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'V.C.', 'uraian' => 'Penerjemahan/Penyaduran Buku atau Karya Ilmiah di Bidang Teknologi Informasi', 
                'induk'=>'V.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],


            ['jenis' => 2, 'kode' => 'VI.', 'uraian' => 'PENDUKUNG KEGIATAN PRANATA KOMPUTER', 
                'created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'VI.A.', 'uraian' => 'Pengajar/Pelatih di Bidang Teknologi Informasi', 
                'induk'=>'VI.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'VI.B.', 'uraian' => 'Peran Serta Dalam Seminar/Lokakarya/Konferensi', 
                'induk'=>'VI.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'VI.C.', 'uraian' => 'Keanggotaan Dalam Tim Penilai Angka Kredit Jabatan Fungsional Pranata Komputer', 
                'induk'=>'VI.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'VI.D.', 'uraian' => 'Keanggotaan Dalam Organisasi Profesi', 
                'induk'=>'VI.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'VI.E.', 'uraian' => 'Perolehan Piagam Kehormatan', 
                'induk'=>'VI.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['jenis' => 2, 'kode' => 'VI.F.', 'uraian' => 'Perolehan Gelar Kesarjanaan Lainnya', 
                'induk'=>'VI.','created_by'=>1, 'updated_by'=>1,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
        ];

        foreach($prakom_terampil as $key=>$value){
            DB::table('rincian_kredits')->insert($value);
        }

        foreach($prakom_ahli as $key=>$value){
            DB::table('rincian_kredits')->insert($value);
        }


        // DB::table('rincian_kredits')->insert();

        //PRAKOM AHLI
        // DB::table('rincian_kredits')->insert();
    }
}
