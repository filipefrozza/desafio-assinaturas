<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Logs in a user based on the provided Request.
     *
     * @param Request $request The request containing user credentials.
     * @return JsonResponse The JSON response with user information and token.
     */
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
        
        return response($response, 200);
    }
    
    /**
     * Retrieves a list of all users and returns it as a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the list of users.
     */
    function list()
    {
        $users = User::all();
        return response()->json($users);
    }
    
    /**
     * Retrieves the user information based on the authenticated user's ID.
     *
     * @param Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the user information.
     */
    function info(Request $request)
    {
        $user = User::find($request->user()->id);
        
        return response()->json($user);
    }
    
    /**
     * Store a new user in the database.
     *
     * @param Request $request The HTTP request containing the user data.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the created user and a success message.
     */
    function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->codigo = $request->codigo;
        $user->telefone = $request->telefone;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            "message" => "Usuário criado",
            "user" => $user
        ], 201);
    }
    
    /**
     * Deletes a user from the database.
     *
     * @param int $id The ID of the user to be deleted.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success or failure of the deletion.
     */
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
    
    /**
     * Retrieves a user by their ID and returns them as a JSON response.
     *
     * @param int $id The ID of the user to be retrieved.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the user, or a JSON response with a "Usuário não encontrado" message and a 404 status code if the user is not found.
     */
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
    
    /**
     * Updates a user in the database based on the provided ID.
     *
     * @param Request $request The HTTP request containing the updated user data.
     * @param int $id The ID of the user to be updated.
     * @return \Illuminate\Http\JsonResponse The JSON response containing a message indicating the success or failure of the update.
     */
    function update(Request $request, $id)
    {
        if(User::where('id', $id)->exists())
        {
            $user = User::find($id);
            $user->name = is_null($request->name) ? $user->name : $request->name;
            $user->email = is_null($request->email) ? $user->email : $request->email;
            $user->password = is_null($request->password) ? $user->password : Hash::make($request->password);
            $user->codigo = $request->codigo;
            $user->telefone = $request->telefone;
            $user->save();
            return response()->json([
                "message" => "Usuário atualizado"
            ], 201);
        } 
        else 
        {
            return response()->json([
                "message" => "Usuário não encontrado"
            ], 404);
        }
    }
}
