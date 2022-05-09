<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Juan Angela Alma',
            'email'     => 'juanangelaalma@gmail.com',
            'password'  => Hash::make('cpktnwt123'),
        ]);
    }

    public function generateToken()
    {
        $this->api_token = Str::random(60);

        return $this->api_token;
    }
}
