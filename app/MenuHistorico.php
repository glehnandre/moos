<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuHistorico extends Model
{
     protected $fillable = ['desconto_antigo', 'desconto_novo', 'valor_antigo', 'valor_novo','menu_id'];
}
