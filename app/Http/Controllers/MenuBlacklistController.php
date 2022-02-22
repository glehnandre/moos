<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use App\Menu;
use App\Evento;
use App\User;
use App\Cartao;
use App\MenuRestrito;

class MenuBlacklistController extends Controller
{

    public function index(Request $request)
    {   
        $evento_selecionado = null;
        $cartao_selecionado = null;
        $evento_id = $request->evento;
        $eventos = Evento::where('ativo', 1)
                          ->when($evento_id, function ($query) use ($evento_id) {
                                    return $query->where('id', $evento_id);
                          })
                          ->get();

        $cartoes = Cartao::where('user_id', Auth::user()->id)
                              ->where('ativo', 1)
                              ->get();

        return View('menu_blacklist', [
          'eventos' => $eventos,
          'evento' => $evento_selecionado,
          'cartoes' => $cartoes,
          'cartao' => $cartao_selecionado,
          'menus' => []
        ]);   
    }

    public function salvar(Request $request){
      $itens =  $request->itens_menu;
      Log::info("Item: " . $itens);
      $jsonCollection = json_decode($itens, true);
      

       if(!empty($request->evento) && !empty($request->cartao) ){
          foreach ($jsonCollection as $json) {
            $input = [];
            Log::info("Item: " . $json);
            $item = json_decode($json);
            $quantidade = 0;
            $frequencia = null;
            if($item->quantidade != '') {
              $quantidade = $item->quantidade;
            }
            if($item->frequencia != ''){
              $frequencia = $item->frequencia;
            }
            $input['quantidade'] = $quantidade;
            $input['restrito'] = $item->restrito;
            $input['menu_id'] = $item->menu_id;
            $input['evento_id'] = $request->evento;
            $input['cartao_id'] = $request->cartao;
            $input['frequencia'] = $frequencia;
            $input['user_id'] = Auth::user()->id;

            $menuRestrito = MenuRestrito::updateOrCreate(['id' => $item->restrito_id, 'evento_id' => $request->evento],$input);        
          }
          return response('Restrições salvas', 204);
       }else{
          return response ('Nenhum evento ou cartão informados', 400);
       }
    }

    public function getEventos(Request $request, $evento_id)
    {   
        $menu =  Menu::where('evento_id', $evento_id)
                      ->where('ativo', true)
                      ->get();  

        return View('menu_blacklist_table', [
          'menus' => $menu,
        ]);   
    }

    public function getMenuBlacklist(Request $request, $evento_id, $cartao_id)
    {   
        $menu =  MenuRestrito::select('menus.nome', 'menus.imagem_type', 'menus.imagem', 'menus.id', 'menu_restritos.id as restrito_id', 'menus.valor', 'menu_restritos.quantidade as quantidade', 'menu_restritos.restrito as restrito')
                      ->join('eventos', 'menu_restritos.evento_id', '=', 'eventos.id')
                      ->join('menus', 'menu_restritos.menu_id', '=', 'menus.id')
                      ->where('menu_restritos.evento_id', $evento_id)
                      ->where('menu_restritos.cartao_id', $cartao_id)
                      ->get();  

        return View('menu_blacklist_table', [
          'menus' => $menu,
        ]);   
    }
  
  
    public function all()
    {
        return Menu::all();
    }

 
 
    public function show($id_evento, $id_menu)
    {   
        return Menu::find($id_menu);
    }


    public function delete(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->ativo = false;
        $menu->save();

        return 204;
    }
}
