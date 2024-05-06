<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Assinatura;
use App\Models\User;

class FaturaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // Preparing the Login Data
        $body = [
            "email" => "root",
            "password" => "password"
        ];
        
        // Testing Login
        $response = $this->json('post', 'api/login', $body)->assertStatus(200);
        
        // Storing the token
        $token = $response['token'];
        
        $this->assertNotNull($token);
        
        // Testing your "Fatura" Data
        $this->json('get', 'api/faturas/info', [], ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        // Getting User root Data
        $user = User::where('username', 'root')->first();
        
        // Getting First root "Assinatura"
        $assinatura = Assinatura::where('user_id', $user->id)->first();
        
        // Preparing "Fatura" Data
        $body = [
            "user_id" => $user->id,
            "assinatura_id" => $assinatura->id,
            "descricao" => "Assinatura Básica",
            "valor" => "9.90",
            "codigo_barra" => "12345678901",
            "data_vencimento" => "2024-05-13",
            "pago" => false,
            "cancelado" => false
        ];
        
        // Testing create a "Fatura" 
        $response = $this->json('post', 'api/faturas', $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $body['descricao'] = "Assinatura Básica Atualizada";
        
        // Testing updating a "Fatura"
        $this->json('put', 'api/faturas/' . $response['fatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        // Testing getting a "Fatura"
        $this->json('get', 'api/faturas/' . $response['fatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        // Testing deleting a "Fatura"
        $this->json('delete', 'api/faturas/' . $response['fatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
    }
}
