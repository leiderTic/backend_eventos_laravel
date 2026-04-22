<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ["name" => "Rodney Miranda", "password" => "RM2026!"],
            ["name" => "Patricia Castillo", "password" => "PC2026!"],
            ["name" => "Boris Lopez", "password" => "BL2026!"],
            ["name" => "Leslie Santiago", "password" => "LS2026!"],
            ["name" => "Dante Duran", "password" => "DD2026!"],
            ["name" => "Jhonny Mendoza", "password" => "JM2026!"],
            ["name" => "Catherine Rodriguez", "password" => "CR2026!"],
            ["name" => "Gustavo Mattos", "password" => "GM2026!"],
            ["name" => "Sergio Rivera", "password" => "SR2026!"],
            ["name" => "José Justiniano", "password" => "JJ2026!"],
            ["name" => "Eddy Vera", "password" => "EV2026!"],
            ["name" => "Yumi Martinez", "password" => "YM2026!"],
            ["name" => "Riery Rodriguez", "password" => "RR2026!"],
            ["name" => "Ramiro Atahuichi", "password" => "RA2026!"],
            ["name" => "Josafat Wunder", "password" => "JW2026!"],
            ["name" => "Gary Rodriguez", "password" => "GR2026!"],
            ["name" => "Grecia Contreras", "password" => "GC2026!"],
            ["name" => "Manuel Rojas", "password" => "MR2026!"],
            ["name" => "Michael Montealegre", "password" => "MM2026!"],
            ["name" => "Andrea Ariñez", "password" => "AA2026!"],
        ];

        foreach ($users as $userData) {
            $username = Str::slug($userData["name"], ".");
            $email = $username . "@it.com"; 
            $alias = explode(" ", $userData["name"])[0];

            User::updateOrCreate(
                ["email" => $email],
                [
                    "name" => $userData["name"],
                    "alias" => $alias,
                    "username" => $username,
                    "password" => Hash::make($userData["password"]),
                    "email_verified_at" => now(),
                ]
            );
        }
    }
}
