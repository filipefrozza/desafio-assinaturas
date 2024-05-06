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
        // Preparing the Login Data
        $body = [
            "email" => "root",
            "password" => "password"
        ];
        
        // Testing login
        $response = $this->json('post', 'api/login', $body)->assertStatus(200);
        
        // store the token
        $token = $response['token'];
        
        $this->assertNotNull($token);
        
        
        // Testing your User Info
        $this->json('get', 'api/users/info', [], ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        // Preparing the "Assinatura" Data
        $body = [
            "name" => "Cliente de Test",
            "codigo"=> "00000099",
            "telefone"=> "51987987564",
            "email"=> "cliente.de.test@example.com",
            "username"=> "cliente.de.test",
            "password"=> "password"
        ];
        
        // Testing create User
        $response = $this->json('post', 'api/users', $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        $body['name'] = "Cliente de Test atualizado";
        
        // Testing update an User
        $this->json('put', 'api/users/' . $response['user']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(201);
        
        // Testing getting an User
        $this->json('get', 'api/users/' . $response['user']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
        
        // Testing deleting an User
        $this->json('delete', 'api/users/' . $response['user']['id'], $body, ['Authorization' => 'Bearer ' . $token])->assertStatus(200);
    }
}
