<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retirada extends Model
{
    use HasFactory;
    protected $table ='retiradas';
    protected $fillable = ['corretor_id','valor'];
}
