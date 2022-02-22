<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Evento;
use App\User;
use App\EventoUsuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class EventoController extends Controller
{



    public function index()
    {
        $eventos = Evento::all();

        Log::info("EVENTOS: " . $eventos);

        return View('eventos', [
            'eventos' => $eventos,
            ]); 
    }

    public function showForUser($id)
    {

        $eventos = Evento::where('user_id', $id)
                              ->where('ativo', 1)
                              ->get();
        return View('eventos', [
            'eventos' => $eventos
        ]);                      
    }

    public function all()
    {
        return Evento::all();
    }

    public function getAtivos()
    {
        $eventos = Evento::where('ativo', 1)->get();
        return $eventos;
    }

    public function getFuncionarios($id_evento)
    {
        $eventoUsuarios = EventoUsuario::where('evento_id', $id_evento)->get();
        $funcionarios = array();
        foreach( $eventoUsuarios as $usr ){
            array_push($funcionarios,$usr->user_id);
        }
        $usuarios = User::all();
        return View('evento_usuario', [
            'funcionarios' => $funcionarios, 'usuarios' => $usuarios, 'evento_id' => $id_evento
        ]);   
    }

    public function getFuncionariosApi($id_evento)
    {
        $eventoUsuarios = EventoUsuario::where('evento_id', $id_evento)->get();
        $funcionarios = array();
        foreach( $eventoUsuarios as $usr ){
            array_push($funcionarios,$usr->usuario);
        }
       return $funcionarios;
    }

    public function setFuncionarios(Request $request, $id_evento)
    {
        $evento = Evento::findOrFail($id_evento);
        $evento->usuarios()->sync($request->usuarios);
        return $evento->nome;
    }

    public function detalheEvento(){
        return View('evento_detalhe', [
            'eventos' => Evento::all()
        ]);
    }
 
 
    public function show($id_evento)
    {
        return Evento::find($id_evento);
    }

    public function store(Request $request)
    {	
    	$product = $this->validate(request(), [
          'nome' => 'required',
          'descricao' => 'required',
          'data_evento' => 'required'
        ]);
        
        Evento::create($product);

        return back()->with('success', 'Evento adicionado.');
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);
        $product = $this->validate(request(), [
          'nome' => 'required',
          'descricao' => 'required',
          'data_evento' => 'required'
        ]);
        $evento->update($request->all());

        return $evento;
    }

    public function delete($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();

        return 204;
    }

    public function toogleAtivo($id){
        $evento = Evento::findOrFail($id);
        ($evento->ativo)? $evento->ativo = false : $evento->ativo = true;
        $evento->save();
        return ($evento->ativo)? 'Ativo' : 'Inativo';
    }
}
