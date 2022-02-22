<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Transacao;
use App\Terminal;
use App\Pedido;
use App\Evento;
use App\Cartao;

class TransacaoController extends Controller
{

    public function getTransacoes($evento_id){
        return $this->getTransacoesTerminal($evento_id, null);
    }

    

    public function getTransacoesTerminal($evento_id, $terminal_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $debitos = Transacao::where('tipo_transacao', 'debito')
                              ->where('evento_id',  $evento_id)
                              ->when($terminal_id, function ($query) use ($terminal_id) {
                                return $query->where('terminal_id', $terminal_id);
                              })
                              ->sum('valor');
        $qtdDebitos = Transacao::where('tipo_transacao', 'debito')
                                ->where('evento_id',  $evento_id)
                                ->when($terminal_id, function ($query) use ($terminal_id) {
                                    return $query->where('terminal_id', $terminal_id);
                                })
                                ->count();

        $creditos = Transacao::where('tipo_transacao', 'credito')
                                ->where('evento_id',  $evento_id)
                                ->when($terminal_id, function ($query) use ($terminal_id) {
                                    return $query->where('terminal_id', $terminal_id);
                                })
                                ->sum('valor');
        
        $totalCreditoCartao = Transacao::where('tipo_transacao', 'credito')
                                        ->where('transacao','cartão')
                                        ->where('evento_id',  $evento_id)
                                        ->when($terminal_id, function ($query) use ($terminal_id) {
                                            return $query->where('terminal_id', $terminal_id);
                                        })
                                        ->sum('valor');

        $totalCreditoDinheiro = Transacao::where('tipo_transacao', 'credito')
                                            ->where('transacao','dinheiro')
                                            ->where('evento_id',  $evento_id)
                                            ->when($terminal_id, function ($query) use ($terminal_id) {
                                                return $query->where('terminal_id', $terminal_id);
                                            })  
                                            ->sum('valor');
        $qtdCreditos = Transacao::where('tipo_transacao', 'credito')
                                ->where('evento_id',  $evento_id)
                                ->when($terminal_id, function ($query) use ($terminal_id) {
                                    return $query->where('terminal_id', $terminal_id);
                                })                                
                                ->count();

        $bandeirasCartao = DB::table('transacoes')
                       ->select('transacoes.bandeira', DB::raw('SUM(transacoes.valor) as total'))
                       ->where('transacoes.transacao', '=', 'cartão')
                       ->when($terminal_id, function ($query) use ($terminal_id) {
                                    return $query->where('terminal_id', $terminal_id);
                       })
                       ->where('evento_id',  $evento_id)
                       ->groupBy('transacoes.bandeira')
                       ->get();

        $transacoes = Transacao::where('evento_id', $evento_id)
                                ->when($terminal_id, function ($query) use ($terminal_id) {
                                    return $query->where('terminal_id', $terminal_id);
                                })
                                ->orderBy('id', 'desc')->paginate(30);

        return View('transacoes', [
            'transacoes' => $transacoes,
            'totalDebitos' => $debitos,
            'qtdDebitos' => $qtdDebitos,
            'totalCreditos' => $creditos,
            'qtdCreditos' => $qtdCreditos,
            'totalCreditoCartao' => $totalCreditoCartao,
            'totalCreditoDinheiro' => $totalCreditoDinheiro,
            'evento' => $evento,
            'bandeirasCartao' => $bandeirasCartao
        ]);   
    }

    public function all()
    {
        return Transacao::all();
    }

    public function getCreditos($evento_id){
        $creditos = Transacao::where('tipo_transacao', 'credito')
                               ->where('evento_id', $evento_id)
                               ->get();
        return $creditos;
    }

    public function getVendas(){
        $vendas = Transacao::where('tipo_transacao', 'debito')
                               ->get();
        return $vendas;
    }

    //Verifica se há saldo suficiente naquele cartao
    public function temSaldo($id, $valorTransacao){
        $debitos = Transacao::where('tipo_transacao', 'debito')
                            ->where('cartao', $id)
                            ->sum('valor');
        $creditos = Transacao::where('tipo_transacao', 'credito')
                             ->where('cartao', $id)
                             ->sum('valor');
        return ($creditos - ($debitos + $valorTransacao) >= 0);
    }


 
    public function show($id)
    {   
        $cartao = Cartao::findOrFail($id);


        $transacoes = Transacao::where('cartao',  $cartao->id)->orderBy('created_at', 'desc')->get();

        $debitos = Transacao::where('tipo_transacao', 'debito')
                            ->where('cartao',  $cartao->id)
                            ->sum('valor');

        $qtdDebitos = Transacao::where('tipo_transacao', 'debito')
                                ->where('cartao',  $cartao->id)
                                ->count();

        $creditos = Transacao::where('tipo_transacao', 'credito')
                             ->where('cartao',  $cartao->id)
                             ->sum('valor');

        $totalCreditoCartao = Transacao::where('tipo_transacao', 'credito')
                                        ->where('transacao','cartão')
                                        ->where('cartao',  $cartao->id)
                                        ->sum('valor');

        $totalCreditoDinheiro = Transacao::where('tipo_transacao', 'credito')
                                         ->where('transacao','dinheiro')
                                         ->where('cartao',  $cartao->id)
                                         ->sum('valor');

        $qtdCreditos = Transacao::where('tipo_transacao', 'credito')
                                ->where('cartao',  $cartao->id)
                                ->count();

        $pedidos = DB::table('menus')
                       ->select('menus.nome', DB::raw('SUM(pedidos.valor) as total'), DB::raw('SUM(pedidos.quantidade) as quantidade'))
                       ->join('pedidos', 'menus.id', '=', 'pedidos.menu_id')
                       ->join('transacoes', 'pedidos.transacao_id', '=', 'transacoes.id')
                       ->where('transacoes.cartao', '=', $cartao->id)
                       ->groupBy('menus.nome')
                       ->get();

        $debitosPorEvento = DB::table('transacoes')
                       ->select('eventos.nome', DB::raw('SUM(transacoes.valor) as total'))
                       ->join('eventos', 'transacoes.evento_id', '=', 'eventos.id')
                       ->where('transacoes.cartao', '=', $cartao->id)
                       ->where('transacoes.tipo_transacao', '=', 'debito')
                       ->groupBy('eventos.id','eventos.nome')
                       ->get();

        return View('transacoes_detalhe', [
            'transacoes' => $transacoes,
            'totalDebitos' => $debitos,
            'qtdDebitos' => $qtdDebitos,
            'totalCreditos' => $creditos,
            'qtdCreditos' => $qtdCreditos,
            'totalCreditoCartao' => $totalCreditoCartao,
            'totalCreditoDinheiro' => $totalCreditoDinheiro,
            'cartao' => $cartao,
            'pedidosEstatistica' => $pedidos,
            'debitosPorEventoEstatistica' => $debitosPorEvento
        ]);   

    }

    public function estorno(Request $request, $id){
        DB::beginTransaction();
            $transacao = Transacao::findOrFail($id);
            $tipo_oposto = null;
            if($transacao->tipo_transacao == 'credito') {
              $tipo_oposto = 'debito';
            }else{
              $tipo_oposto = 'credito';
            }
            $date = new \DateTime();
            // Se for proveniente de transferência, ele faz a transferencia de forma inversa. Cria duas transações contrárias em cada cartão. Exatamente o oposto da transferencia.
            if(!empty($transacao->transacao_equivalente)){
              $estorno = ['tipo_transacao' => $tipo_oposto,'valor' => $transacao->valor,'sync' => false, 'cartao'=>$transacao->cartao, 'data_transacao' => $date, 'cpf'=>$transacao->cpf, 'transacao'=>'estorno'];
              $c1 = Transacao::create($estorno);

              $estorno_origem = ['tipo_transacao' => $transacao->tipo_transacao,'valor' => $transacao->valor,'sync' => false, 'cartao'=>$transacao->transacaoEquivalente->cartao, 'data_transacao' => $date, 'cpf'=>$transacao->cpf, 'transacao'=>'estorno'];
                $c2 = Transacao::create($estorno_origem);

                 $c1->transacao_equivalente = $c2->id;
                 $c2->transacao_equivalente = $c1->id;
                 $c1->save();
                 $c2->save();
            }else
            // Nesse caso, há apenas uma transação criada, contrária àquela escolhida.
            {
                    $estorno = ['tipo_transacao' => $tipo_oposto,'valor' => $transacao->valor,'sync' => false, 'cartao'=>$transacao->cartao, 'data_transacao' => $date, 'cpf'=>$transacao->cpf, 'transacao'=>'estorno', 'transacao_equivalente' => $transacao->id];
                    $transacao_estorno = Transacao::create($estorno);
                    $transacao_estorno->transacao_equivalente = $transacao->id;
                    $transacao->transacao_equivalente = $transacao_estorno->id;
                    $transacao->save();
                    $transacao_estorno->save();
            }
        DB::commit(); 
        return response('Transação efetuada', 204); 
    }

    public function transferencia(Request $request, $valor, $cartao_id_origem, $cartao_id_destino){
        //Log::info("Solicitação de transferencia: " . Auth::user()->cpf); 
        $origem = Cartao::where('id', $cartao_id_origem)
                              ->first();

        $destino = Cartao::where('id', $cartao_id_destino)
                              ->first();
        if(!empty($origem) && !empty($destino)){
           if($origem->user->id == $destino->user->id) {
              if($this->temSaldo($cartao_id_origem, $valor)){
                DB::beginTransaction();
                $date = new \DateTime();
                $credito = ['tipo_transacao' => 'credito','valor' => $valor,'sync' => false, 'cartao'=>$destino->id, 'data_transacao' => $date, 'cpf'=>$origem->user->cpf, 'transacao'=>'transferencia'];
                $debito = ['tipo_transacao' => 'debito','valor' => $valor,'sync' => false, 'cartao'=>$origem->id,  'data_transacao' => $date, 'cpf'=>$origem->user->cpf, 'transacao'=>'transferencia'];
                $transacao_credito = Transacao::create($credito);
                $transacao_debito = Transacao::create($debito);
                $transacao_credito->transacao_equivalente = $transacao_debito->id;
                $transacao_debito->transacao_equivalente = $transacao_credito->id;
                $transacao_credito->save();
                $transacao_debito->save();
                DB::commit(); 
                $this->enviarEmailRecibo($request, $origem->user, $transacao_credito);
                return response('Transação efetuada', 204);
              }else{
                return response('Cartão não tem saldo suficiente para transação.', 401);
              }
           }else{
            Log::info("Não pertence ao mesmo usuário"); 
            return response('Transferências só podem ser realizadas entre cartões de mesmo dono.', 401);
           }
        }else{
          Log::info("Cartão inativo"); 
          return response('Cartão de origem ou destino não encontrado.', 401);
        }
    }


    public function store(Request $request)
    {   
        DB::beginTransaction();
            $cartao = Cartao::where('cartao_id', $request->cartao)
                              ->where('bloqueado', 0)
                              ->where('ativo', 1)
                              ->first();
            Log::info("Request: " . $request); 
            $terminal = Terminal::where('terminal_id', $request->terminal_id)
                              ->where('bloqueado', 0)
                              ->where('ativo', 1)
                              ->first();
            Log::info("TERMINAL: " . $terminal);                  
            if(!empty($cartao)){
                if(!empty($terminal)){
                    if($this->validaTransacaoSuspeita($request->valor, $cartao->id, $request->tipo_transacao)){
                    Log::info("TRANSACAO SUSPEITA: " . $request);
                    return response('Transação suspeita.', 500);
                  }else{
                    $input = $request->all();
                    $input['cartao'] = $cartao->id;
                    $input['terminal_id'] = $terminal->id;
                    if($request->tipo_transacao=='debito'){ 
                        if( $this->temSaldo($cartao->id, $request->valor)){
                            $transacao = Transacao::create($input); 
                            $pedido = $request->pedido;
                            foreach($pedido as $item) {
                                $item['transacao_id'] = $transacao->id;
                                Pedido::create($item);
                            }
                        }else return "Não há saldo suficiente.";
                    }else{
                        $transacao = Transacao::create($input);
                    }
                  }
                  $this->sincronizaTransferenciasPendentes($request->transferencias, $transacao);
                  $this->enviarEmailRecibo($request, $cartao->user, $transacao);
                }else return response ('Terminal bloqueado', 400);
            } else return response('Cartão bloqueado ou não encontrado.', 400);
        DB::commit();    
        return response('Transação efetuada', 204);

    }

    /*Se o cartão tiver transacações pendentes ele considera como sincronizado. Os aparelhos terão recebido 
    * o valor e terão atualizado o total no cartão ou pulseira. É grava o id do aparelho o qual sincronizou os * créditos.
    */
    public function sincronizaTransferenciasPendentes($transferencias, $transacao_associada){
        Log::info("$$$$$$$$$ Transcao associadas: " . $transacao_associada); 
        if(!empty($transferencias)){
          foreach($transferencias as $transferencia) {
             $transferenciaPendente = Transacao::findOrFail($transferencia);
             $transferenciaPendente->sync = true;
             $transferenciaPendente->terminal_id = $transacao_associada->terminal_id;
             $transferenciaPendente->transacao_associada = $transacao_associada->id;
             $transferenciaPendente->save();
          }
        }
    }

    //Recupera apenas as transferencias não sincronizadas com o saldo
    public function getTransferencias($id){
        $creditos = Transacao::where('cartao', $id)
                             ->where('transacao', 'transferencia')
                             ->where('sync', false)
                             ->get();
        return $creditos;
    }

    /*
    * Verifique se houve transação recente semanticamente igual antes de salvar o registro.
    */
    public function validaTransacaoSuspeita($valor, $cartao_id, $tipo_transacao){
        $date = new \DateTime();
        $date->modify('-60 seconds');
        $formatted_date = $date->format('Y-m-d H:i:s');
        Log::info("TRANSACAO DATA: " . $formatted_date);
        $transacaoSuspeita = Transacao::where('cartao', $cartao_id)
                              ->where('valor', $valor)
                              ->where('tipo_transacao', $tipo_transacao)
                              ->where('created_at', '>',$formatted_date)
                              ->get();
        return (count($transacaoSuspeita) > 0);
    }


    public function update(Request $request, $id)
    {
        $article = Transacao::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Transacao::findOrFail($id);
        $article->delete();

        return 204;
    }

    /**
     * Envia email de transacao para o cliente
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function enviarEmailRecibo(Request $request, $user, $transacao)
    { 
        Log::info('USER: ' . $user);
        $text_subject = null;
        if($transacao->tipo_transacao == 'debito'){
              Mail::send('email_transacao_debito', ['user' => $user, 'transacao' => $transacao, 'texto' => $text_subject], function ($m) use ($user) {
                  $m->from('noreply@moospayment.com', 'MOOS Payments');

                  $m->to($user->email, $user->nome)->subject('Nova compra no seu cartão MOOS');
              });
        }else{
              Mail::send('email_transacao_credito', ['user' => $user, 'transacao' => $transacao, 'texto' => $text_subject], function ($m) use ($user) {
                $m->from('noreply@moospayment.com', 'MOOS Payments');

                $m->to($user->email, $user->nome)->subject('Novo crédito no seu cartão MOOS');
              });
        }
    }
}
