<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Menu;
use App\MenuHistorico;
use App\Evento;
use App\Http\Controllers\TerminalController;

class MenuController extends Controller
{


    public function index(Request $request, $id_evento)
    {   
        if ($request == null) {
          $menus = null;
        } else {
          $menus = Menu::where('evento_id',  $id_evento)
                          ->where('ativo', true)
                          ->get();
        }
        

        return View('menu', [
        	'menus' => $menus,
          'evento' => Evento::find($id_evento)
        ]);   
    }

    public function filtraTipo(Request $request){
        $menus = Menu::where('categoria', $tipo)
                      ->where('evento_id', $id_evento)
                      ->get();

        return View('menu', [
          'menus' => $menus,
          'evento' => Evento::find($id_evento)
        ]);  
    }

    public function getMenu($evento_id, $terminal_id)
    {   
        $menu =  Menu::where('evento_id', $evento_id)
                      ->where('ativo', true)
                      ->get();  
        $terminalController = new TerminalController();
        $terminalController->setTerminalSincronizado($terminal_id);
        return $menu;
    }

    public function getMenuSite($evento_id){
      $menu =  Menu::where('evento_id', $evento_id)
                      ->where('ativo', true)
                      ->get();  
      return $menu;
    }


    public function all()
    {
        return Menu::all();
    }
 
 
    public function show($id_evento, $id_menu)
    {   
        return Menu::find($id_menu);
    }


    public function saveImage(Request $request, $id_evento, $id_menu)
    {
       if ($request->hasFile('imagem')) {
            $menu = Menu::find($id_menu);

            $image = $request->file('imagem');
            $imageType = $image->getClientOriginalExtension();
            $imageStr = (string) Image::make( $image )->
                                     resize( 100, 100, function ( $constraint ) {
                                         $constraint->aspectRatio();
                                     })->encode( $imageType );
            $menu->imagem = base64_encode( $imageStr );
            $menu->imagem_type = $imageType;
            $menu->update();
           return back()->with('success', 'Imagem adicionada');
       }
    }

    public function store(Request $request, $id_evento)
    {

        $product = $this->validate(request(), [
          'nome' => 'required',
          'valor' => 'required|numeric',
          'evento_id' => 'required',
          'desconto'=> 'numeric|max:100',
        ]);
        
        $menu = Menu::create($request->all());
        MenuHistorico::create(['desconto_antigo'=>0, 'desconto_novo'=>$request->desconto, 'valor_antigo' => 0, 'valor_novo'=>$request->valor, 'menu_id'=>$menu->id]);

        return back()->with('success', 'Item de menu adicionado. $product;');
    }

    public function update(Request $request, $id_evento, $id_menu)
    {
        $article = Menu::findOrFail($id_menu);
        $product = $this->validate(request(), [
          'nome' => 'required',
          'valor' => 'required|numeric',
          'evento_id' => 'required',
          'desconto'=> 'numeric|max:100',
        ]);
        
        MenuHistorico::create(['desconto_antigo'=>$article->desconto, 'desconto_novo'=>$request->desconto, 'valor_antigo' => $article->valor, 'valor_novo'=>$request->valor, 'menu_id'=>$id_menu]);

        $article->update($request->all());

        //Atualiza o status de todos os terminais do evento.
        $terminalController = new TerminalController();
        $terminalController->atualizaStatusTerminais($id_evento);

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->ativo = false;
        $menu->save();

        return 204;
    }
}
