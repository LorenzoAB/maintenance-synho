<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Detailprevenmaintenance extends Model
{
    use HasFactory;

    protected $table = 'detailprevenmaintenance';

    protected $fillable = [
        'maquina',
        'elementos',
        'revision',
        'fechaprogramada',
    ];
}
