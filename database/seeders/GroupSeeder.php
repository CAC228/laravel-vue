<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    public function run()
    {
        Group::create([
            'name' => 'admin',
            'description' => 'Администраторы',
        ]);

        Group::create([
            'name' => 'user',
            'description' => 'Пользователи',
        ]);
    }
}
