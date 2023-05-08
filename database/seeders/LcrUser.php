<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LcrUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $f = \App\Models\User::factory();
        $f->create(
            [
                'name' => 'LCR',
                'email' => 'lcr@lcr.test',
                'password' => bcrypt('Admin123!'),
                'email_verified_at' => \now(),
            ]
        );
    }
}
