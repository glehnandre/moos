<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuRestrito extends Model
{
     protected $fillable = ['menu_id', 'user_id', 'cartao_id', 'quantidade', 'evento_id', 'restrito', 'frequencia'];

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

    public function evento()
    {
        return $this->belongsTo('App\Evento');
    }
}
