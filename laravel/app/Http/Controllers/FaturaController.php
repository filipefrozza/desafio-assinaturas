<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fatura;

class FaturaController extends Controller
{
    /**
     * Retrieves all faturas from the database and returns them as a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing all faturas.
     */
    public function list()
    {
        $faturas = Fatura::all();
        return response()->json($faturas);
    }
    
    /**
     * Retrieves a specific fatura by its ID and returns it as a JSON response.
     *
     * @param int $id The ID of the fatura to retrieve.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the fatura.
     */
    public function show($id)
    {
        if(Fatura::where('id', $id)->exists())
        {
            $fatura = Fatura::find($id);
            return response()->json($fatura);
        }
        else
        {
            return response()->json([
               "message" => "Fatura não encontrada" 
            ], 404);
        }
    }
    
    /**
     * Retrieves and returns the faturas associated with the logged in user.
     *
     * @param Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the faturas.
     */
    public function info(Request $request)
    {
        $user_id = $request->user()->id;
        
        $faturas = Fatura::where('user_id', $user_id)->get();
        
        return response()->json($faturas);
    }
    
    /**
     * Store a new Fatura in the database.
     *
     * @param Request $request The HTTP request containing the Fatura data.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the created Fatura and a success message.
     */
    public function store(Request $request)
    {
        $fatura = new Fatura;
        $fatura->user_id = $request->user_id;
        $fatura->assinatura_id = $request->assinatura_id;
        $fatura->descricao = $request->descricao;
        $fatura->data_vencimento = $request->data_vencimento;
        $fatura->data_pagamento = $request->data_pagamento;
        $fatura->pago = $request->pago;
        $fatura->cancelado = $request->cancelado;
        $fatura->codigo_barra = $request->codigo_barra;
        $fatura->valor = $request->valor;
        $fatura->save();
        return response()->json([
            'message' => 'Fatura criada com sucesso',
            'fatura' => $fatura
        ], 201);
    }
    
    /**
     * Updates an existing Fatura based on the provided ID.
     *
     * @param Request $request The HTTP request containing the Fatura data.
     * @param int $id The ID of the Fatura to update.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the updated Fatura and a success message.
     */
    public function update(Request $request, $id)
    {
        if(Fatura::where('id', $id)->exists())
        {
            $fatura = Fatura::find($id);
            $fatura->user_id = is_null($request->user_id) ? $fatura->user_id : $request->user_id;
            $fatura->assinatura_id = is_null($request->assinatura_id) ? $fatura->assinatura_id : $request->assinatura_id;
            $fatura->descricao = is_null($request->descricao) ? $fatura->descricao : $request->descricao;
            $fatura->data_vencimento = is_null($request->data_vencimento) ? $fatura->data_vencimento : $request->data_vencimento;
            $fatura->data_pagamento = is_null($request->data_pagamento) ? $fatura->data_pagamento : $request->data_pagamento;
            $fatura->pago = is_null($request->pago) ? $fatura->pago : $request->pago;
            $fatura->cancelado = is_null($request->cancelado) ? $fatura->cancelado : $request->cancelado;
            $fatura->codigo_barra = $request->codigo_barra;
            $fatura->valor = is_null($request->valor) ? $fatura->valor : $request->valor;
            $fatura->save();
            return response()->json([
                "message" => "Fatura atualizada"
            ], 201);
        } 
        else 
        {
            return response()->json([
               "message" => "Fatura não encontrada"
            ], 404);
        }
    }
    
    /**
     * Deletes an Fatura from the database based on the provided ID.
     *
     * @param int $id The ID of the Fatura to delete.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the updated Fatura and a success message.
     */
    public function destroy($id)
    {
        if(Fatura::where('id', $id)->exists())
        {
            $fatura = Fatura::find($id);
            $fatura->delete();
            
            return response()->json([
               "message" => "Fatura excluída" 
            ]);
        }
        else
        {
            return response()->json([
               "message" => "Fatura não encontrada" 
            ], 404);
        }
    }
}