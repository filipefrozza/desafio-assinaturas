<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assinatura;

class AssinaturaController extends Controller
{
    /**
     * Retrieves all Assinaturas from the database.
     *
     * @throws \Exception If an error occurs.
     * @return \Illuminate\Http\JsonResponse The JSON response containing all Assinaturas.
     */
    public function list()
    {
        $assinaturas = Assinatura::all();
        return response()->json($assinaturas);
    }
    
    /**
     * Store a new Assinatura in the database.
     *
     * @param Request $request The HTTP request containing the Assinatura data.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the created Assinatura and a success message.
     */
    public function store(Request $request)
    {
        $assinatura = new Assinatura;
        $assinatura->user_id = $request->user_id;
        $assinatura->descricao = $request->descricao;
        $assinatura->valor = $request->valor;
        $assinatura->save();
        return response()->json([
            'message' => 'Assinatura criada com sucesso',
            'assinatura' => $assinatura
        ], 201);
    }
    
    /**
     * Retrieves and returns the Assinatura associated with the logged in user.
     *
     * @param Request $request The HTTP request
     * @throws 
     * @return \Illuminate\Http\JsonResponse JSON response containing the Assinatura model if found
     */
    public function info(Request $request)
    {
        $user_id = $request->user()->id;
        
        $assinaturas = Assinatura::where('user_id', $user_id)->get();
        
        return response()->json($assinaturas);
    }
    
    /**
     * Retrieves and returns the Assinatura model with the given ID.
     *
     * @param int $id The ID of the Assinatura model to retrieve.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the Assinatura model if found,
     *                                       or a JSON response with a 'message' key set to 'Assinatura não encontrada'
     *                                       and a 404 status code if not found.
     */
    public function show($id)
    {
        $assinatura = Assinatura::find($id);
        if(!empty($assinatura))
        {
            return response()->json($assinatura);
        }
        else
        {
            return response()->json([
                'message' => 'Assinatura não encontrada',
            ], 404);
        }
    }
    
    /**
     * Updates an existing Assinatura based on the provided ID.
     *
     * @param Request $request The HTTP request containing the updated data
     * @param int $id The ID of the Assinatura to be updated
     * @return \Illuminate\Http\JsonResponse JSON response with a message indicating the success or failure of the update
     */
    public function update(Request $request, $id)
    {
        if(Assinatura::where('id', $id)->exists())
        {
            $assinatura = Assinatura::find($id);
            $assinatura->user_id = is_null($request->user_id) ? $assinatura->user_id : $request->user_id;
            $assinatura->descricao = is_null($request->descricao) ? $assinatura->descricao : $request->descricao;
            $assinatura->data_vencimento = is_null($request->data_vencimento) ? $assinatura->data_vencimento : $request->data_vencimento;
            $assinatura->valor = is_null($request->valor) ? $assinatura->valor : $request->valor;
            $assinatura->save();
            return response()->json([
                'message' => 'Assinatura atualizada',
            ], 201);
        } 
        else 
        {
            return response()->json([
                'message' => 'Assinatura não encontrada',
            ], 404);
        }
    }
    
    /**
     * Deletes an Assinatura from the database based on the provided ID.
     *
     * @param int $id The ID of the Assinatura to be deleted.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success or failure of the deletion.
     */
    public function destroy($id)
    {
        if(Assinatura::where('id', $id)->exists())
        {
            $assinatura = Assinatura::find($id);
            $assinatura->delete();
            return response()->json([
                'message' => 'Assinatura excluída',
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Assinatura não encontrada',
            ], 404);
        }
    }
}