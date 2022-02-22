<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['nome', 'data_evento','descricao', 'local', 'ativo', 'latitude', 'longitude', 'sync'];


    public function usuarios()
    {
        return $this->belongsToMany('App\User','evento_usuarios');
    }

        public function terminais()
    {
        return $this->belongsToMany('App\Terminal');
    }

}
