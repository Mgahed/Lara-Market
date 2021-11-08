<?php

namespace Database\Seeders;

use App\Models\Expense;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        Expense::create([
            'expense_details' => $faker->realText(),
            'cost' => $faker->randomFloat(),
            'user_id' => 1,
        ]);
    }
}
