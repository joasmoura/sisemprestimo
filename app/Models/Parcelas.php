<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcelas extends Model
{
    use HasFactory;
    protected $table = 'parcelas';
    protected $fillable = ['emprestimo_id', 'valor','vencimento', 'num'];

    public function emprestimo(){
        return $this->hasOne(Emprestimo::class, 'id', 'emprestimo_id');
    }

    public function baixa(){
        return $this->hasOne(Baixa::class, 'parcela_id','id');
    }
}
