<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
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
        
        $this->json('get', 'api/users/info', [], ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        $body = [
            "name" => "Cliente de Test",
            "codigo"=> "00000099",
            "telefone"=> "51987987564",
            "email"=> "cliente.de.test@example.com",
            "username"=> "cliente.de.test",
            "password"=> "password"
        ];
        
        $response = $this->json('post', 'api/users', $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $body['name'] = "Cliente de Test atualizado";
        
        $this->json('put', 'api/users/' . $response['user']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $this->json('get', 'api/users/' . $response['user']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        $this->json('delete', 'api/users/' . $response['user']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
    }
}
