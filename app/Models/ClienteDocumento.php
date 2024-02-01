<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteDocumento extends Model
{
    use HasFactory;

    protected $fillable=['id_cliente','tipo','vigencia','id_user','documento'];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }
}
