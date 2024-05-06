<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Assinatura;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssinaturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'root')->first();
        
        $assinatura = Assinatura::create([
            "user_id" => $user->id,
            "descricao" => "Assinatura Básica",
            "data_vencimento" => now()->addDays(45),
            "valor" => 9.90,
        ]);
        
        $user = User::where('username', 'test')->first();
        
        $assinatura = Assinatura::create([
            "user_id" => $user->id,
            "descricao" => "Assinatura Premium",
            "data_vencimento" => now()->addDays(11),
            "valor" => 19.90,
        ]);
        
        $user = User::where('username', 'cliente.basico')->first();
        
        $assinatura = Assinatura::create([
            "user_id" => $user->id,
            "descricao" => "Assinatura Básica",
            "data_vencimento" => now()->addDays(5),
            "valor" => 9.90,
        ]);
        
        $user = User::where('username', 'cliente.padrao')->first();
        
        $assinatura = Assinatura::create([
            "user_id" => $user->id,
            "descricao" => "Assinatura Padrão",
            "data_vencimento" => now()->addDays(9),
            "valor" => 14.90,
        ]);
        
        $user = User::where('username', 'cliente.premium')->first();
        
        $assinatura = Assinatura::create([
            "user_id" => $user->id,
            "descricao" => "Assinatura Premium",
            "data_vencimento" => now()->addDays(15),
            "valor" => 19.90,
        ]);
    }
}