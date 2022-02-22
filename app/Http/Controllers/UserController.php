<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Mail;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CartaoController;
use Illuminate\Support\Facades\DB;
use App\Evento;

class UserController extends Controller
{   



    public function index(Request $request)
    {   
        $evento = $request->select_eventos;
        $role = $request->select_roles;
        $ativos = $request->checkbox_ativos;
        $excluidos = $request->checkbox_excluidos;
        $nome = $request->usuario;
        $bloqueados = $request->checkbox_bloqueados;
        $users = User::orderBy('users.id', 'desc')
                        ->when(($evento), function ($query) use ($evento) {
                                return $query->join('evento_usuarios', 'users.id', '=', 'evento_usuarios.user_id')->where('evento_usuarios.evento_id', $evento);
                        })
                        ->when(($role), function ($query) use ($role) {
                                return $query->join('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', $role);
                        })
                        ->when(($ativos), function ($query) use ($ativos) {
                                return $query->where('ativo', $ativos);
                        })
                        ->when(($excluidos), function ($query) use ($excluidos) {
                                return $query->where('excluido', $excluidos);
                        })
                        ->when(($bloqueados), function ($query) use ($bloqueados) {
                                return $query->where('bloqueado', $bloqueados);
                        })
                        ->when(($nome), function ($query) use ($nome) {
                                return $query->where('nome', 'like', '%' . $nome . '%');
                        })
                        ->paginate(20);

        return View('users', [
            'users' => $users,
            'roles' => Role::all(),
            'eventos' => Evento::all(),
            'evento' => $evento,
            'request' => $request,
            'role' => $role,
            'excluidos' => $excluidos,
            'ativos' => $ativos,
            'bloqueados' => $bloqueados
        ]); 
    }
 
    public function show($id)
    {
        return User::find($id);
    }

    public function store(Request $request)
    {
        return User::create($request->all());
    }

    public function getUser($cpf)
    {
        return User::where('cpf', $cpf)
                           ->first();
    }

    public function getUserPorCPF($cpf)
    {
        return User::where('excluido', 0)
                           ->where('cpf', $cpf)
                           ->first();
    }

    public function getUserPorEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function update(Request $request, $id)
    {
        $article = User::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function toogleBlock($id){
        $user = User::findOrFail($id);
        ($user->bloqueado)? $user->bloqueado = false : $user->bloqueado = true;
        $user->save();
        return ($user->bloqueado)? 'bloqueado' : 'desbloqueado';
    }

    /**
    *Atualiza as roles de um usuário
    *
    */
    public function updateRoles(Request $request){
        $user = User::findOrFail($request->id);
        $user->roles()->sync($request->roles);
        return $user->nome . " atualizado";
    }

     /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function enviarEmailCadastro(Request $request, $user, $cartao)
    {

        Mail::send('email_senha', ['user' => $user, 'cartao' => $cartao], function ($m) use ($user) {
            $m->from('noreply@moospayment.com', 'MOOS Payments');

            $m->to($user->email, $user->nome)->subject('Novo cartão MOOS');
        });
    }

    /**
    * Usado para o primeiro acesso de um usuário envia uma requisição para definir nova senha para o email.
    */
    public function enviarPrimeiroAcesso(Request $request)
    {
        $client = new ForgotPasswordController();
        $res = $client->sendResetLinkEmail($request);
        echo $res;
    }

    public function delete(Request $request, $id)
    {
        DB::beginTransaction();
        $user = User::findOrFail($id);
        $user->excluido = true;
        $user->ativo = false;
        //Desativar os cartões do usuário.
        $cartaoController = new CartaoController();

        $cartoes = $cartaoController->getCartoesPorUser($id);

        foreach ($cartoes as $cartao) {
            $cartao->ativo = false;
            $cartao->save();
        }
        $user->save();
        DB::commit();  

        return response('Usuário excluído', 204);
    }
}
