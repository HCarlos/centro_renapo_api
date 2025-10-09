<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo',
        'datos_consulta',
        'resultado'
    ];

    protected $casts = [
        'datos_consulta' => 'array',
        'resultado' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
