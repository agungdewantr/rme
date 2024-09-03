<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Admin';
        $user->role_id = 1;
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt(123123123);
        $user->save();

        $user = new User();
        $user->name = 'Albert';
        $user->role_id = 3;
        $user->email = 'albert@email.com';
        $user->password = bcrypt(123123123);
        $user->save();
    }
}
