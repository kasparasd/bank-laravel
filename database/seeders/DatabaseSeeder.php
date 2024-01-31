<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('lt_LT');
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $personalCode = [
            45608058780, 37101219442, 38711138814, 38803078791, 44212018920,
            61409119312, 49903098342, 38407089247, 52101158797, 50802178418
        ];

        foreach (range(0, count($personalCode)-1) as $i) {

            DB::table('clients')->insert([
                'name' => $faker->firstName,
                'lastname' => $faker->lastName,
                'personalCodeNumber' => $personalCode[$i]
            ]);
        }
    }
}
