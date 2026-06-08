<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user with specified credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if admin already exists
        $existingAdmin = Admin::where('AdminEmail', 'moahmmed@gmail.com')
                             ->orWhere('AdminUserName', 'mohammed@admin')
                             ->first();

        if ($existingAdmin) {
            $this->error('Admin user already exists with this email or username!');
            return 1;
        }

        try {
            // Create the admin user
            $admin = Admin::create([
                'AdminName' => 'Mohammed Admin',
                'AdminEmail' => 'moahmmed@gmail.com',
                'AdminUserName' => 'mohammed@admin',
                'AdminPassword' => Hash::make('12345678'),
                'AdminRole' => 'Super Administrator',
                'AdminPhoneNum' => '1234567890',
                'AdminAddress' => 'Admin Address',
                'AdminProfilePicture' => null,
            ]);

            $this->info('Admin user created successfully!');
            $this->line('');
            $this->line('Admin Credentials:');
            $this->line('Email: moahmmed@gmail.com');
            $this->line('Username: mohammed@admin');
            $this->line('Password: 12345678');
            $this->line('');
            $this->info('You can now login to the admin panel with these credentials.');

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to create admin user: ' . $e->getMessage());
            return 1;
        }
    }
}
