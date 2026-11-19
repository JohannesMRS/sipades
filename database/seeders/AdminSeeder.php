<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = config('app.admin_name');
        $email = config('app.admin_email');
        $password = config('app.admin_password');

        if (! is_string($name) || trim($name) === '' || ! is_string($email) || trim($email) === '' || ! is_string($password) || trim($password) === '') {
            throw new \RuntimeException('ADMIN_NAME, ADMIN_EMAIL, dan ADMIN_PASSWORD wajib diisi di .env.');
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt($password),
                'role' => 'admin',
                'is_active' => true,
            ],
        );
    }
}
