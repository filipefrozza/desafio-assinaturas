<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function login( Request $request )
    {
        $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                "message" => "Login inválido"
            ], 404);
        }
        
        $token = $user->createToken($user->email)->accessToken;
        
        $response = [
            "user" => $user,
            "token" => $token
        ];
        
        return response($response, 201);
    }
    
    function list()
    {
        $users = User::all();
        return response()->json($users);
    }
    
    function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            "message" => "Usuário criado"
        ], 201);
    }
    
    function destroy($id)
    {
        if(User::where('id', $id)->exists())
        {
            $user = User::find($id);
            $user->delete();
            
            return response()->json([
               "message" => "Usuário excluído" 
            ]);
        }
        else
        {
            return response()->json([
               "message" => "Usuário não encontrado" 
            ], 404);
        }
    }
    
    function show($id)
    {
        $user = User::find($id);
        if(!empty($user))
        {
            return response()->json($user);
        }
        else
        {
            return response()->json([
                "message" => "Usuário não encontrado"
            ], 404);
        }
    }
    
    function update(Request $request, $id)
    {
        if(User::where('id', $id)->exists())
        {
            $user = User::find($id);
            $user->name = is_null($request->name) ? $user->name : $request->name;
            $user->email = is_null($request->email) ? $user->email : $request->email;
            $user->password = is_null($request->password) ? $user->password : Hash::make($request->password);
            $user->save();
            return response()->json([
                "message" => "Usuário atualizado"
            ], 200);
        } 
        else 
        {
            return response()->json([
                "message" => "Usuário não encontrado"
            ], 404);
        }
    }
}
