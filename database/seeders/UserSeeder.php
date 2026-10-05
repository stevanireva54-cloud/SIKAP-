<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | EDITOR 1
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'editor1@arj.local',
            ],
            [
                'name' => 'Editor 1',

                'password' => Hash::make(
                    'ARJeditor1!'
                ),

                'email_verified_at' => now(),

                'otp_code' => null,
                'otp_expires_at' => null,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | EDITOR 2
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'editor2@arj.local',
            ],
            [
                'name' => 'Editor 2',

                'password' => Hash::make(
                    'ARJeditor2!'
                ),

                'email_verified_at' => now(),

                'otp_code' => null,
                'otp_expires_at' => null,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | EDITOR 3
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'editor3@arj.local',
            ],
            [
                'name' => 'Editor 3',

                'password' => Hash::make(
                    'ARJeditor3!'
                ),

                'email_verified_at' => now(),

                'otp_code' => null,
                'otp_expires_at' => null,
            ]
        );
    }
}