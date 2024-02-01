<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoDocumento extends Model
{
    use HasFactory;

    protected $fillable=['id_proyecto','tipo','vigencia','id_user','documento'];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }
}
