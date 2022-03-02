<?php

namespace App\Database\Seeds;

use App\Models\User;
use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $userObject = new User();

        $userObject->insertBatch([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone_no' => '0123456789',
                'role' => 'admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'phone_no' => '0123456789',
                'role' => 'user',
                'password' => password_hash('user', PASSWORD_DEFAULT),
            ]
        ]);
    }
}
