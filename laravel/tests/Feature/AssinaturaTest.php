<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssinaturaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_crud()
    {
        $body = [
            "email" => "root",
            "password" => "password"
        ];
        
        $response = $this->json('post', 'api/login', $body)->assertStatus(200);
        
        $token = $response['token'];
        
        $this->assertNotNull($token);
        
        $this->json('get', 'api/assinaturas/info', [], ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        $body = [
            "user_id"=> 12,
            "descricao"=> "Assinatura Básica",
            "valor"=> "9.90"
        ];
        
        $response = $this->json('post', 'api/assinaturas', $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $body['descricao'] = "Assinatura Básica Atualizada";
        
        $this->json('put', 'api/assinaturas/' . $response['assinatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $this->json('get', 'api/assinaturas/' . $response['assinatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        $this->json('delete', 'api/assinaturas/' . $response['assinatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
    }
}
