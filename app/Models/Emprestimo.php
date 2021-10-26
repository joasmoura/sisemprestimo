<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;
    protected $table = 'emprestimos';
    protected $fillable = ['cliente_id', 'valor', 'parcelas', 'status','corretor_id', 'comissao_corretor','valor_total'];

    public function parcelas(){
        return $this->hasMany(Parcelas::class,'emprestimo_id', 'id');
    }

    public function cliente(){
        return $this->hasOne(User::class, 'id','cliente_id');
    }

    public function corretor(){
        return $this->hasOne(User::class, 'id','corretor_id');
    }
}
