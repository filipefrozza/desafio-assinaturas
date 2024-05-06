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
    
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function faturas()
    {
        return $this->hasMany(Fatura::class, 'fatura_id', 'id');
    }
}