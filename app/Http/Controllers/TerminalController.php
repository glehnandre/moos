<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Terminal;
use App\Evento;

class TerminalController extends Controller
{


    public function getTerminaisAtivos(){
          return $this->index(null, true);
    }

    public function getTerminaisTodos($id_evento){
          return $this->index($id_evento, null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $ativo)
    {
        $nome = "Ativos";
        if($id !=null){
          $evento = Evento::findOrFail($id);
          $nome = $evento->nome;
        }else{
          $eventos = Evento::where('user_id', Auth::id())
                              ->where('ativo', 1)
                              ->get();

          $hash = bin2hex(random_bytes(6));
        }

        $terminals = DB::table('terminals')
                       ->join('users', 'terminals.user_id', '=', 'users.id')
                       ->join('eventos', 'terminals.evento_id', '=', 'eventos.id')
                       ->join('transacoes', 'terminals.id', '=', 'transacoes.terminal_id')
                       ->when($id, function ($query) use ($id) {
                                    return $query->where('terminals.evento_id', $id);
                       })
                       ->when($ativo, function ($query) use ($ativo) {
                                    return $query->where('terminals.ativo', $ativo);
                       })
                       ->select('transacoes.tipo_transacao','terminals.caixa_fechado', 'terminals.caixa_conferido', 'terminals.sync_menu', 'terminals.valor_apurado', 'terminals.observacao','terminals.bloqueado', 'terminals.ativo','terminals.terminal_id','terminals.id', 'eventos.nome as nome_evento', 'eventos.id as evento_id', 'users.nome', 'terminals.updated_at', DB::raw('SUM(CASE
                                    WHEN transacoes.transacao = "Dinheiro" || transacoes.transacao = "Cartão" || transacoes.transacao is null THEN transacoes.valor
                                    ELSE 0 END) as total'))
                       ->groupBy('transacoes.tipo_transacao','terminals.terminal_id','terminals.id', 'eventos.nome', 'terminals.caixa_conferido', 'terminals.observacao', 'users.nome', 'terminals.updated_at', 'terminals.valor_apurado','terminals.sync_menu', 'terminals.bloqueado', 'terminals.ativo','terminals.caixa_fechado', 'eventos.id')
                       ->orderBy('terminals.updated_at', 'desc')
                       ->paginate(30);

        return View('terminais', [
            'terminais' => $terminals,
            'nome_evento' => $nome, 
            'eventos' => $eventos, 
            'id' => $id,
            'codigo_sync' => $hash,
        ]);  

    }

    public function all()
    {
        return Terminal::all();
    }
 
    public function show($id)
    {
        return Terminal::find($id);
    }

    public function store(Request $request)
    {   
        DB::beginTransaction();
            $terminal = Terminal::where('terminal_id', $request->terminal_id)
                                  ->where('ativo', 1)
                                  ->first();
            if(!empty($terminal)){
              $terminal->ativo = false;
              $terminal->save();
            }
            $input = $this->validate(request(), [
              'user_id' => 'required',
              'evento_id' => 'required',
            ]);
            $terminal_novo = Terminal::create($request->all());
        DB::commit();    
        return $terminal_novo;
    }

    public function update(Request $request, $id)
    {
        $terminal = Terminal::findOrFail($id);
        $terminal->update($request->all());

        return $terminal;
    }

    public function toogleBlock($id){
        $terminal = Terminal::findOrFail($id);
        ($terminal->bloqueado)? $terminal->bloqueado = false : $terminal->bloqueado = true;
        $terminal->save();
        return ($terminal->bloqueado)? 'bloqueado' : 'desbloqueado';
    }


    public function forceSync($id){
        $terminal = Terminal::where('terminal_id', $id)
                              ->where('ativo', 1)
                              ->get();
        if(count($terminal) > 0){
            ($terminal[0]->sync_menu)? $terminal[0]->sync_menu = false : $terminal[0]->sync_menu = true ;
            $terminal[0]->save();
            return ($terminal[0]->sync_menu)? 'sincronizado' : 'pendente';
         }else{
            abort(404); 
         }
    }

    public function statusSync($id){
        $terminal = Terminal::where('terminal_id', $id)
                              ->where('ativo', 1)
                              ->get();
        if(count($terminal) > 0){
            return ($terminal[0]->sync_menu)? 'sincronizado' : 'pendente';
         }else{
           abort(404); 
         }
    }

    public function atualizaStatusTerminais($evento_id){
          $terminals = Terminal::where('evento_id', $evento_id)
                              ->where('ativo', 1)
                              ->get();
          foreach($terminals as $terminal){
                $terminal->sync_menu = 0;
                $terminal->save();
          }                
    }

    public function setTerminalSincronizado($terminal_id){
        $terminal = Terminal::where('terminal_id', $terminal_id)
                              ->where('ativo', 1)
                              ->first();
        if(!empty($terminal)){
          $terminal->sync_menu = 1;
          $terminal->save();
        }                      
    }

    public function status($id){
        $terminal = Terminal::where('terminal_id', $id)
                              ->where('ativo', 1)
                              ->get();
         if(count($terminal) > 0){
            return ($terminal[0]);
         }else{
            abort(404); 
         }
    }

    public function conferir(Request $request, $id){
        $terminal = Terminal::where('id', $id)
                              ->first();
        Log::info("TERMINAL: " . $terminal);

        if(!empty($terminal)){
            $terminal->observacao = $request->formObservacao;
            $terminal->caixa_conferido = true;
            $terminal->valor_apurado = $request->formValorApurado;
            $terminal->save();
              Log::info("TERMINAL SALVO: " . $terminal);
            return response('Caixa conferido.', 200);
        }else{
            abort(404); 
        }
    }

    public function fechar($id){
        $terminal = Terminal::where('id', $id)
                              ->first();
        Log::info("TERMINAL: " . $terminal);

        if(!empty($terminal)){
            $terminal->caixa_fechado = true;
            $terminal->ativo = false;
            $terminal->save();
            Log::info("TERMINAL SALVO: " . $terminal);
            return response('Caixa fechado.', 200);
        }else{
            abort(404); 
        }
    }

    public function toogleAtivo($id){
        $terminal = Terminal::findOrFail($id);
        ($terminal->ativo)? $terminal->ativo = false : $terminal->ativo = true;
        $terminal->save();
        return ($terminal->ativo)? 'Ativo' : 'Inativo';
    }

    public function delete($id)
    {
        $terminal = Terminal::findOrFail($id);
        $terminal->delete();
    }
}
