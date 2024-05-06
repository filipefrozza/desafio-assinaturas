<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Fatura;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FaturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // $fatura = Fatura::create([
        //     "user_id" => 1,
        //     "assinatura_id" => 1,
        //     "descricao" => "Assinatura Básica",
        //     "data_vencimento" => "2024-05-24",
        //     "pago" => false,
        //     "cancelado" => false,
        //     "data_pagamento" => null,
        //     "codigo_barra" => "1234567890123",
        //     "valor" => 9.90,
        // ]);
        
        // $fatura = Fatura::create([
        //     "user_id" => 2,
        //     "assinatura_id" => 2,
        //     "descricao" => "Assinatura Premium",
        //     "data_vencimento" => "2024-05-25",
        //     "pago" => false,
        //     "cancelado" => false,
        //     "data_pagamento" => null,
        //     "codigo_barra" => "1234567890124",
        //     "valor" => 19.90,
        // ]);
        
        
    }
}