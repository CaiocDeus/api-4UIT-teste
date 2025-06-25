<?php

namespace Database\Seeders;

use App\Enums\TransactionTypes;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
        ]);

        User::factory()
            ->count(9)
            ->create()
            ->each(function ($user) {
                Transaction::factory()
                    ->count(10)
                    ->state(new Sequence(
                        ['type' => TransactionTypes::RECEITA],
                        ['type' => TransactionTypes::DESPESA]
                    ))
                    ->create([
                        'user_id' => $user->id,
                    ]);
            });
    }
}
