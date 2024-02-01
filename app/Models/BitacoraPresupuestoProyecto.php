<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraPresupuestoProyecto extends Model
{
    use HasFactory;

    protected $fillable=[
                        'id_proyecto',
                        'campo',
                        'descripcion',
                        'original',
                        'diferencia',
                        'nuevo',
                        'id_user',
                        ];

    public function usuario()
    {
        return $this->belongsTo(User::class,'id_user');
    }
}
