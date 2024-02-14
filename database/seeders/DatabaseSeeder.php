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

        $personalCode = [
            45608058780, 37101219442, 38711138814, 38803078791, 44212018920,
            61409119312, 49903098342, 38407089247, 52101158797, 50802178418
        ];

        foreach (range(0, count($personalCode) - 1) as $i) {

            DB::table('clients')->insert([
                'name' => $faker->firstName,
                'lastname' => $faker->lastName,
                'personalCodeNumber' => $personalCode[$i]
            ]);
        }
        $bankAccounts = [
            'LT11 1957 7683 6475 1728', 'LT11 9411 8330 3746 9683', 'LT66 7937 5027 6930 5121',
            'LT55 5613 7983 4624 0777', 'LT30 2439 0316 3115 7228', 'LT63 7120 4701 3020 4231',
            'LT76 5774 7743 1487 3025', 'LT12 0155 6148 6908 7937', 'LT10 8515 1663 6077 3051',
            'LT68 4702 0325 2983 8103', 'LT21 7631 8268 3488 4986', 'LT39 4187 7236 0028 1059',
            'LT43 0016 7057 4700 2718', 'LT95 4906 9102 0691 2698', 'LT89 7629 2228 3668 4072'
        ];

        foreach ($bankAccounts as $id => $i) {

            DB::table('accounts')->insert([
                'accountNumber' => $i,
                'balance' => rand(-300, 500),
                'client_id' => $faker->numberBetween(1, count($personalCode)),
            ]);
        }

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);
    }
}
