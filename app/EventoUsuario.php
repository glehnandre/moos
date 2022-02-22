<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoUsuario extends Model
{
    protected $fillable = ['evento_id', 'user_id'];

    public function usuario(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function evento(){
        return $this->belongsTo('App\Evento');
    }
}
