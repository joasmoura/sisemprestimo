<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baixa extends Model
{
    use HasFactory;

    protected $table = 'baixas';
    protected $fillable = ['parcela_id', 'valor', 'user_id','created_at'];

    public function recebedor(){
        return $this->hasOne(User::class,'id', 'user_id');
    }
}
