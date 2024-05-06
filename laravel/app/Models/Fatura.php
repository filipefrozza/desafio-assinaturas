<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assinatura;
use App\Models\User;

class Fatura extends Model
{
    use HasFactory;
    protected $table = 'faturas';
    protected $fillable = ['user_id', 'assinatura_id', 'descricao', 'data_vencimento', 'pago', 'cancelado', 'data_pagamento', 'codigo_barra', 'valor'];
    
    
    /**
     * Retrieve the associated assinatura for the fatura.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assinatura()
    {
        return $this->belongsTo(Assinatura::class, 'assinatura_id', 'id');
    }
    
    /**
     * Retrieve the user that owns the Fatura.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}