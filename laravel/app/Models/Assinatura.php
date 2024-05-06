<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Fatura;

class Assinatura extends Model
{
    use HasFactory;
    protected $table = 'assinaturas';
    protected $fillable = ['user_id', 'descricao', 'valor', 'ativo', 'data_vencimento'];
    
    
    /**
     * Retrieve the associated user for the assinatura.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    /**
     * Retrieve the associated faturas for the assinatura.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faturas()
    {
        return $this->hasMany(Fatura::class, 'fatura_id', 'id');
    }
}