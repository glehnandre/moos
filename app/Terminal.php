<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    
 	protected $fillable = ['user_id', 'evento_id', 'sync_menu', 'ativo', 'bloqueado','terminal_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function evento(){
        return $this->belongsTo('App\Evento');
    }
}
