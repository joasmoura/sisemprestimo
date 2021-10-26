<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baixa extends Model
{
    use HasFactory;

    protected $table = 'baixas';
    protected $fillable = ['parcela_id', 'valor', 'user_id'];
}
