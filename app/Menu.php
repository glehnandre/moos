<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	 protected $table = 'menus';
     protected $fillable = ['nome', 'valor', 'categoria', 'imagem','imagem_type','descricao','ativo','desconto', 'evento_id', 'full_image', 'teste'];

}
