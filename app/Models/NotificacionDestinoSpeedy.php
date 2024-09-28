<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionDestinoSpeedy extends Model
{
    use HasFactory;

    public function consultor()
    {
        return $this->belongsTo(User::class,'titular');
    }
    public function apoyo()
    {
        return $this->belongsTo(User::class,'adjunto');
    }
}
