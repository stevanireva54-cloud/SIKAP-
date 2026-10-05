<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $editors = [
            [
                'name' => 'Zuliardi',
                'email' => 'editor1@arj.local',
                'password' => Hash::make('arjuna2026'),
            ],
            [
                'name' => 'Hendra PY',
                'email' => 'editor2@arj.local',
                'password' => Hash::make('arjuna2026'),
            ],
            [
                'name' => 'Ridho Fuadi',
                'email' => 'editor3@arj.local',
                'password' => Hash::make('arjuna2026'),
            ],
            [
                'name' => 'Satria Nugraha',
                'email' => 'editor4@arj.local',
                'password' => Hash::make('arjuna2026'),
            ],
        ];

        foreach ($editors as $editor) {
            User::updateOrCreate(
                [
                    'email' => $editor['email'],
                ],
                [
                    'name' => $editor['name'],
                    'password' => $editor['password'],
                ]
            );
        }
    }
}