<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Ganteng',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin123'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
