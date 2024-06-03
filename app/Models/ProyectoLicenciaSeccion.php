<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoLicenciaSeccion extends Model
{
    use HasFactory;

    protected $fillable=['id_proyecto','nombre','f_inicio','f_fin'];
}
