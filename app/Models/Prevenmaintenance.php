<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Detailprevenmaintenance;

class Prevenmaintenance extends Model
{
    use HasFactory;

    protected $table = 'prevenmaintenance';

    protected $fillable = [
        'parametro',
        'factibilidad_revision',
        'personal',
        'pruebas',
        'estado',
        'solucion',
        'observacion',
    ];

    public function Detailprevenmaintenance()
    {
        return $this->hasMany(Detailprevenmaintenance::class,'prevenmaintenance_id','id');
    }
}
