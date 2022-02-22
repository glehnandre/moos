<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    protected $table = 'cartoes';
    protected $fillable = ['cartao_id','terminal','latitude','longitude','timestamp', 'evento_id', 'ativo', 'bloqueado', 'user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function evento(){
        return $this->belongsTo('App\Evento');
    }

}
