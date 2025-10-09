<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'curp' => 'Admin',
                'password' => 'NxsWry2K',
            ],
            [
                'name' => 'SysOp',
                'curp' => 'SysOp',
                'password' => 'yysop',
            ],
            [
                'name' => 'Carlos Hidalgo',
                'curp' => 'HIRC711126HTCDZR01',
                'password' => 'HIRC711126HTCDZR01',
            ],
            [
                'name' => 'Ana Gómez',
                'curp' => 'GOMA900202MDFTRN08',
                'password' => 'secret456',
            ],
            [
                'name' => 'Luis Pérez',
                'curp' => 'PELJ850303HDFLRL07',
                'password' => 'admin789',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
