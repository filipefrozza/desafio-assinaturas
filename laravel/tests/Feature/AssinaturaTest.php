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
        // Preparing the Login Data
        $body = [
            "email" => "root",
            "password" => "password"
        ];
        
        // Testing login
        $response = $this->json('post', 'api/login', $body)->assertStatus(200);
        
        // Storing the token
        $token = $response['token'];
        
        $this->assertNotNull($token);
        
        // Testing your "Assinaturas" data
        $this->json('get', 'api/assinaturas/info', [], ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        $body = [
            "user_id"=> 12,
            "descricao"=> "Assinatura Básica",
            "valor"=> "9.90"
        ];
        
        // Testing create an "Assinatura"
        $response = $this->json('post', 'api/assinaturas', $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $body['descricao'] = "Assinatura Básica Atualizada";
        
        // Testing updating a "Assinatura"
        $this->json('put', 'api/assinaturas/' . $response['assinatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        // Testing getting a "Assinatura"
        $this->json('get', 'api/assinaturas/' . $response['assinatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        // Testing deleting a "Assinatura"
        $this->json('delete', 'api/assinaturas/' . $response['assinatura']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
    }
}
