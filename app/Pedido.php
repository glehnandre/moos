<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

 	protected $fillable = ['quantidade', 'valor', 'menu_id', 'transacao_id'];

 	public function menu(){
        return $this->belongsTo('App\Menu');
    }
}
