<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoProspecto extends Model
{
    use HasFactory;

    protected $fillable=[
            'prospecto_id',
            'nombre',
            'area',
            'posicion',
            'correo1',
            'correo2',
            'correo3',
            'telefono1',
            'telefono2',
            'telefono3',
            'notas'
    ];
}
