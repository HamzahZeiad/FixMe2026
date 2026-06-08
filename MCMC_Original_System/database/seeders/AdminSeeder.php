<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user with the specified credentials
        DB::table('administrators')->insert([
            'AdminName' => 'Mohammed Admin',
            'AdminEmail' => 'moahmmed@gmail.com',
            'AdminUserName' => 'mohammed@admin',
            'AdminPassword' => Hash::make('12345678'),
            'AdminRole' => 'Super Administrator',
            'AdminPhoneNum' => '',
            'AdminAddress' => '',
            'AdminProfilePicture' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "Admin user created successfully!\n";
        echo "Email: moahmmed@gmail.com\n";
        echo "Username: mohammed@admin\n";
        echo "Password: 12345678\n";
    }
}
