<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "DIA Amadou Daouda";
        $user->user_glpi_id = 15;
        $user->email = "amadou-daouda.dia@seter.sn";
        $user->password = Hash::make('DooDoug12345678');
        $user->type = "SUPER-ADMIN";
        $user->save();

    }
}
