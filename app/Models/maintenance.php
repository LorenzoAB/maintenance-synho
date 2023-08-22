<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenance';

    protected $fillable = [
        'user_id',
        'fecha_inicio',
        'fecha_final',
        'maquina',
        'proceso',
        'descripcion',
        'estado',
        'ejecutor',
        'nivel_criticidad',
        'estado_previo',
        'solucion_efectuada',
        'estado_actual',
        'observacion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}