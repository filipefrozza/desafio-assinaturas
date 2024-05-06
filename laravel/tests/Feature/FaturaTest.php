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
        $response = $this->get('/');

        $body = [
            "email" => "root",
            "password" => "password"
        ];
        
        $response = $this->json('post', 'api/login', $body)->assertStatus(200);
        
        $token = $response['token'];
        
        $this->assertNotNull($token);
        
        $this->json('get', 'api/faturas/info', [], ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        $user = User::where('username', 'root')->first();
        
        $assinatura = Assinatura::where('user_id', $user->id)->first();
        
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
        
        $response = $this->json('post', 'api/faturas', $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $body['descricao'] = "Assinatura Básica Atualizada";
        
        $this->json('put', 'api/faturas/' . $response['fatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $this->json('get', 'api/faturas/' . $response['fatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        $this->json('delete', 'api/faturas/' . $response['fatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
    }
}
