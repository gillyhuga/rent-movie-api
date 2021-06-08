<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'user'];
        foreach($roles as $role)
        {
            $user = User::create([
                'email' => $role.'@gmail.com',
                'password' => Hash::make('123123'),
                'role' => $role
            ]);

        }
    }
}
