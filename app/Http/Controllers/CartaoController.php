<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransacaoController;
use App\Evento;
use App\Cartao;
use App\User;
use App\Transacao;



class CartaoController extends Controller
{
    

    public function getTodosCartoesInicio()
    {
        if(Auth::user()->isAdministrator()){
            $eventos = $evento = Evento::all();
            return View('cartoes', [
            'cartoes' => Cartao::all(),
            'eventos' => $eventos,
            'request' => ''
            ]);   
        }else{
            return $this->showForUser(Auth::user()->id); 
        } 
    }

    public function getTableCartoes(Request $request){
        
    if(Auth::user()->isAdministrator()){

        DB::enableQueryLog();
        $cartoes = [];
        $ativo = $request->ativo;
        $evento = $request->evento;
        $ultimo = $request->ultimo;
        $user = $request->user;
        $users = User::all();
        
        if($ultimo == "1"){
            $cartoes =  Cartao::orderBy('cartoes.id', 'desc')
                            ->select('cartoes.id', 'cartoes.ativo as ativo', 'cartoes.timestamp', 'eventos.nome as evento_nome', 'users.email as email', 'users.nome as nome', 'users.cpf as cpf', 'users.id as user_id', 'cartoes.cartao_id', 'cartoes.bloqueado',
                            DB::raw(
                                'SUM(CASE
                                    WHEN transacoes.tipo_transacao = "credito" THEN transacoes.valor
                                    ELSE 0
                                END) AS total_credito'),
                            DB::raw(
                                'SUM(CASE
                                    WHEN transacoes.tipo_transacao = "debito" THEN transacoes.valor
                                    ELSE 0
                                END) AS total_debito'
                                ))
                            ->leftJoin('transacoes', 'cartoes.id', '=', 'transacoes.cartao')
                            ->join('eventos', 'cartoes.evento_id', '=', 'eventos.id')
                            ->join('users', 'cartoes.user_id', '=', 'users.id')
                            ->when(($evento), function ($query) use ($evento) {
                                return $query->where('transacoes.evento_id', $evento);
                            })
                            ->when(($user), function ($query) use ($user) {
                                return $query->where('cartoes.user_id', $user);
                            })
                            ->distinct()
                            ->groupBy('users.id','cartoes.id', 'cartoes.ativo', 'cartoes.timestamp','eventos.nome',
                             'users.email', 'users.nome', 'users.cpf', 'cartoes.cartao_id', 'cartoes.bloqueado')
                            ->paginate(20);
        }else{
            Log::info("evento do request: " . $request->evento_select);
            $cartoes =  Cartao::orderBy('cartoes.id', 'desc')
                            ->select('cartoes.id', 'cartoes.ativo as ativo', 'cartoes.timestamp', 'eventos.nome as evento_nome', 'users.email as email', 'users.nome as nome', 'users.cpf as cpf', 'cartoes.cartao_id', 'cartoes.bloqueado', 'users.id as user_id',
                            DB::raw(
                                'SUM(CASE
                                    WHEN transacoes.tipo_transacao = "credito" THEN transacoes.valor
                                    ELSE 0
                                END) AS total_credito'),
                            DB::raw(
                                'SUM(CASE
                                    WHEN transacoes.tipo_transacao = "debito" THEN transacoes.valor
                                    ELSE 0
                                END) AS total_debito'
                                ))
                            ->leftJoin('transacoes', 'cartoes.id', '=', 'transacoes.cartao')
                            ->join('eventos', 'cartoes.evento_id', '=', 'eventos.id')
                            ->join('users', 'cartoes.user_id', '=', 'users.id')
                            ->when($ativo, function ($query) use ($ativo) {
                                return $query->where('cartoes.ativo', $ativo);
                            })
                            ->when(($evento), function ($query) use ($evento) {
                                return $query->where('cartoes.evento_id', $evento);
                            })
                            ->when(($user), function ($query) use ($user) {
                                return $query->where('cartoes.user_id', $user);
                            })
                            ->groupBy('users.id', 'cartoes.id', 'cartoes.ativo', 'cartoes.timestamp','eventos.nome',
                             'users.email', 'users.nome', 'users.cpf', 'cartoes.cartao_id', 'cartoes.bloqueado')
                            ->paginate(20);
        }

    }else{       
        return $this->showForUser(Auth::user()->id); 
    } 
        $eventos = Evento::all();
        return View('cartoes', [
            'cartoes' => $cartoes,
            'eventos' => $eventos,
            'request' => $request,
            'ativo' => $ativo,
            'evento' => $evento,
            'ultimo' => $ultimo,
            'users' => $users,
            'user' => $user,
        ]);   
    }


    public function all()
    {
        return Cartao::all();
    }
 
    public function show($id)
    {
        $transacaoController = new TransacaoController();

        $cartao = Cartao::where('cartao_id', $id)
                       ->where('ativo',1)
                       ->first();
       
        if(is_null($cartao)){
            abort(404); 
        }else{
             $transferencias = $transacaoController->getTransferencias($cartao->id);
             return response()->json([
                'cartao' => $cartao, 'creditos_transferencias' => $transferencias,
            ]);
        }
    }

    public function showForUser($id)
    {
        $cartoes = $this->getCartoesPorUser($id);
        return View('cartoes', [
            'cartoes' => $cartoes
        ]);                      
    }

    public function getCartoesPorUser($id)
    {
        $cartoes = Cartao::where('user_id', $id)
                              ->where('ativo', 1)
                              ->get();
        return $cartoes;                    
    }

    public function store(Request $request)
    {   
        $userController = new UserController();

        try{
            DB::beginTransaction();
        //verifica se o cartao já está associado
            $cartaoNovo = Cartao::where('cartao_id', $request->cartao_id)
                              ->where('ativo', 1)
                              ->get();
            if(count($cartaoNovo)>0){
                throw new Exception("Cartão já está ativo. Não pode ser associado a outra pessoa.");
                return response('Cartão já está ativo. Não pode ser associado a outra pessoa.', 400);
            }
        //Envia email informando
            $user = $userController->getUser($request->cpf);
            if($user == null){
                $user = $userController->store($request);
                $userController->enviarPrimeiroAcesso($request);
            }if($user->bloqueado){
                return response('Usuário está bloqueado. Entre em contato com a equipe MOOS.', 400);
            }
        //Cria o cartão
            $cartao = Cartao::create($request->all() + ['user_id' => $user->id]);

            $userController->enviarEmailCadastro($request, $user, $cartao);

            DB::commit();  
            return $cartao;

        }  catch (Exception $e) {
            DB::rollback();

            throw $e;
        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        $cartao = Cartao::findOrFail($id);
        $cartao->update($request->all());

        return $cartao;
    }

    public function toogleBlock($id){
        $cartao = Cartao::findOrFail($id);
        ($cartao->bloqueado)? $cartao->bloqueado = false : $cartao->bloqueado = true;
        $cartao->save();
        return ($cartao->bloqueado)? 'bloqueado' : 'desbloqueado';
    }

    public function status($id){
        $cartao = Cartao::where('cartao_id', $id)
                              ->where('ativo', 1)
                              ->get();
        if(count($cartao) > 0){
            return ($cartao[0]->bloqueado);
        }else{
            abort(404); 
        }
    }

    public function delete($id)
    {   
        $cartao = Cartao::findOrFail($id);
        $cartao->ativo = false;
        $cartao->save();

        return response('Cartão excluído', 204);
    }
}
