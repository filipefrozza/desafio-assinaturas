<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fatura;

class FaturaController extends Controller
{
    public function list()
    {
        $faturas = Fatura::all();
        return response()->json($faturas);
    }
    
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
    
    public function info(Request $request)
    {
        $user_id = $request->user()->id;
        
        $faturas = Fatura::where('user_id', $user_id)->get();
        
        return response()->json($faturas);
    }
    
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