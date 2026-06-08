<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agencies')->truncate();
        DB::table('administrators')->truncate();
        DB::table('public_users')->truncate();

        DB::table('agencies')->insert([
            'AgencyID' => 1,
            'AgencyName' => 'Test Agency',
            'AgencyEmail' => 'agency@example.com',
            'AgencyPhoneNum' => '123456789',
            'AgencyType' => 'Type',
            'AgencyUserName' => 'username',
            'AgencyPassword' => 'password',
            'AgencyProfilePicture' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('administrators')->insert([
            'AdminID' => 1,
            'AdminName' => 'Test Admin',
            'AdminEmail' => 'admin@example.com',
            'AdminRole' => 'Role',
            'AdminPhoneNum' => '123456789',
            'AdminAddress' => 'Address',
            'AdminUserName' => 'adminuser',
            'AdminPassword' => bcrypt('password'),
            'AdminProfilePicture' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('public_users')->insert([
            'UserID' => 1,
            'UserName' => 'Test User',
            'UserEmail' => 'user@example.com',
            'UserPassword' => bcrypt('password'),
            'UserPhoneNum' => '123456789',
            'UserProfilePicture' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
