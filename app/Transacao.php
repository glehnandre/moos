<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pedido;
use App\Cartao;
use App\Terminal;
use App\Evento;

class Transacao extends Model
{
	protected $table = 'transacoes';

 	protected $fillable = ['cpf', 'cartao', 'transacao', 'tipo_transacao','bandeira','saldo','valor', 'terminal_id', 'latitude', 'longitude', 'data_transacao', 'transacao_id', 'evento_id', 'sync'];

    public function pedidos(){
    	return $this->hasMany('App\Pedido');
    }

    public function cartaoCredito(){
        return $this->hasOne('App\Cartao', 'id', 'cartao');
    }

    public function terminal(){
    	return $this->belongsTo('App\Terminal');
    }

    public function transacaoEquivalente(){
       return $this->hasOne('App\Transacao', 'id', 'transacao_equivalente');
    }

    public function evento(){
        return $this->belongsTo('App\Evento');
    }
}
