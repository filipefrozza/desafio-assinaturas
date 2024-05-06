<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assinatura;

class AssinaturaController extends Controller
{
    public function list()
    {
        $assinaturas = Assinatura::all();
        return response()->json($assinaturas);
    }
    
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
    
    public function info(Request $request)
    {
        $user_id = $request->user()->id;
        
        $assinaturas = Assinatura::where('user_id', $user_id)->get();
        
        return response()->json($assinaturas);
    }
    
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