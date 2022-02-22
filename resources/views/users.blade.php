@extends('layouts.master')

@section('title', 'Usuários')


@section('content')
<!--Inicio Filtros -->
<div class="row" >
<form method="GET" action="/users" id="formUsers" name="formUsers">
{{ csrf_field() }}
		<div class="col-sm-12">
	          <div class="grid simple">
	            <div class="grid-title">
	              <h4>Filtros</h4>
	              <div class="tools">
	              <a href="javascript:;" class="collapse"></a></div>
	            </div>
	            <div class="grid-body">
	            	<div class="col-sm-12">
			            	<div style="float:left; padding:9px 0px; vertical-align: middle;">
			            		<label class="form-label">Nome:</label>
			            	</div>
			            	<div style="float:left; padding:0px 10px; vertical-align: middle;">
			            		<input type="text" id="usuario" name="usuario" value="{{$request->usuario}}">
			            	</div>
							<div style="float:left; padding:0px 10px; vertical-align: middle;">
									<select class="js-example-basic-multiple" style="width: 100%" name="select_eventos" id="select_eventos">
									  		<option value="0">Funcionário do evento</option>
											@foreach($eventos as $ev)
											  <option 
											  @if ($ev->id == $evento)
											  	selected="selected"
											  @endif
											  value="{{$ev->id}}"
											  >Funcionários da {{$ev->nome}}</option>
											@endforeach
									</select>
							</div>
							<div style="float:left; padding:0px 32px; vertical-align: middle;">
									<select class="js-example-basic-multiple" style="width: 100%" name="select_roles" id="select_roles">
									  		<option value="0">Com perfil de</option>
											@foreach($roles as $r)
											  <option 
											  @if ($r->id == $role)
											  	selected="selected"
											  @endif
											  value="{{$r->id}}"
											  >{{$r->display_name}}</option>
											@endforeach
									</select>
							</div>
							<div style="float:left; padding:10px 10px; vertical-align: middle;">
								<div class="checkbox check-primary">
			                      <input id="checkbox_ativos" name="checkbox_ativos" 
			                       @if ($ativos == 1)
										checked="checked"
									@endif
			                      type="checkbox" value="1" title="Os usuários que já acessaram uma vez o MOOS.">
			                      <label for="checkbox_ativos">Ativos</label>
			                    </div>
							</div>
							<div style="float:left; padding:10px 10px; vertical-align: middle;">
								<div class="checkbox check-danger">
			                      <input id="checkbox_excluidos" name="checkbox_excluidos" type="checkbox" 
			                       @if ($excluidos == 1)
										checked="checked"
									@endif
			                      value="1">
			                      <label for="checkbox_excluidos">Excluídos</label>
			                    </div>
							</div>
							<div style="float:left; padding:10px 10px; vertical-align: middle;">
								<div class="checkbox check-warning">
			                      <input id="checkbox_bloqueados" name="checkbox_bloqueados" type="checkbox" 
			                       @if ($bloqueados == 1)
										checked="checked"
									@endif
			                      value="1">
			                      <label for="checkbox_bloqueados">Bloqueados</label>
			                    </div>
							</div>
					</div>
	            </div>
	          </div>
	    </div>
</form>
</div>
<!--Fim Filtros -->


<div class="row" >
	<div class="col-sm-12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4>Moos <span class="semi-bold">Usuários</span></h4>

	              <div class="tools">
	              <a href="javascript:;" class="collapse"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
	            </div>
	            <div class="grid-body ">
	              <table class="table table-striped dataTable" id="example_wrapper" >
	                <thead>
	                  <tr>
	                    <th>Id</th>
	                    <th>Nome</th>
	                    <th>CPF</th>
	                    <th>Telefone</th>
	                  	<th>Criado em</th>
	                  	<th>Ativo</th>
	                  	<th>Perfis</th>
	                  	<th>Ações</th>
	                  </tr>
	                </thead>
	                <body>
	                @foreach($users as $user)
	                  <tr class="odd gradeX" id="{{ $user->id }}">
	                    <td>{{ $user->id }}</td>
	                    <td>{{ $user->nome }}</td>
	                    <td>{{ $user->cpf }}</td>
	                    <td>{{ $user->telefone }}</td>
	                    <td>{{ $user->created_at }}</td>
	                    <td>{{ $user->ativo == 1 ? 'Ativo':'Inativo' }}</td>
	                    <td>
	                    @if($user->ativo == 1 && $user->excluido !=1)
	                      <form>
	                     	    <input type="hidden" name="id" value="{{ $user->id }}">
								<select class="js-example-basic-multiple" style="width: 100%" id="roles" name="roles[]" multiple="multiple">
								@foreach($roles as $role)
								  <option 
								  @if (in_array($role->id, $user->rolesIds()))
								  	selected="selected"
								  @endif
								  value="{{$role->id}}">{{$role->display_name}}</option>
								@endforeach
								</select>
						  </form>
						@endif
	                    </td>
	                    <td>
		                    <div class="btn-group" data-toggle="buttons-radio">
		                    <button class="btn btn-default " data-original-title="Enviar e-mail" onClick="alert('Em breve')"><i class="fa fa-envelope"></i></button>
		                    @if($user->ativo == 1 && $user->excluido !=1)
			                    <button class="btn btn-default " data-original-title="Cartões" onClick="window.open('/user/{{ $user->id }}/cartoes');"><i class="fa fa-credit-card"></i></button>
			                    <button class="btn btn-default " data-original-title="Excluir o usuário" onclick="javascript:excluirUsuario('{{ $user }}', this);"><i class="fa fa-trash-o"></i></button>
			                    @if($user->bloqueado == 0)  
				                    <button class="btn btn-success "  data-original-title="Bloquear o usuário" onclick="javascript:bloqueiaUsuario('{{ $user }}', this);"><i class="fa fa-unlock"></i></button>
				                @else
				                    <button class="btn btn-danger "  data-original-title="Desbloquear o usuário" onclick="javascript:bloqueiaUsuario('{{ $user }}', this);"><i class="fa fa-lock"></i></button>
			                    @endif
			                @endif
			                </div>
						</td>
	                  </tr>	                 
	                @endforeach
	                </body>
	              </table>
	              	<div class="col-md-12" style="margin-top: 10px;">
			            @if(Auth::user()->isAdministrator() == 1)  
			             	{{$users}} 	
						@endif
			        </div>
	            </div>
	          </div>
	        </div>
	</div>


@endsection

@section('scripts')
<script>

    function transacoes(terminal){
    	$('#modal'+terminal).modal('toggle');
    }

	function bloqueiaUsuario(user, el) {
		var usuario = JSON.parse(user);
		var url = '/user/'+usuario.id+'/block';
	    $.ajax({
		   url: url,
		   type: 'GET',
		   success: function(response) {
		   		if(response == 'bloqueado') {
		   			$(el).attr('data-original-title', 'Desbloquear o Usuário');
		   			$(el).toggleClass('btn-primary btn-danger');
		   		}else{
		   			$(el).attr('data-original-title', 'Bloquear o Usuário');
		   			$(el).toggleClass('btn-primary btn-danger');
		   		}
		   		$(el).children().toggleClass('fa-lock fa-unlock');
		     	toastr.info('Usuário ' +  usuario.nome + ' '+ response, 'Sucesso ', {timeOut: 5000});
		   },
		   error: function(request,msg,error) {
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}

	function excluirUsuario(user, el) {
		var usuario = JSON.parse(user);
		var url = 'user/'+ usuario.id+'/delete';
	    $.ajax({
		   url: url,
		   type: 'GET',
		   success: function(response) {
		   		console.log(response)
		   		$(el).parent().parent().parent().remove();
		     	toastr.info('Usuário ' +  usuario.nome + ' excluído. ', 'Sucesso ', {timeOut: 5000});
		   },
		   error: function(response,msg,error) {
		   		console.log(response)
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}

$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
    	 width: 'resolve' 
    });
    $("#roles").on("change", function(){
    	var form = $(this).parent().serialize();
	    var roles_selecionadas = $(this).val();
	    $.ajax({
	            type: "POST",
	            url: "/api/user/role",
	            data: form,
	            success: function(response) {
				     	toastr.success('Roles atualizadas com sucesso: ' +response, 'Usuário', {timeOut: 9000});
				},
			    error: function(request,msg,error) {
			       console.log(request);
			       toastr.error(error, 'Erro ', {timeOut: 5000});
			    }
	    });
	});    
});

function sendEmail(mail) 
{
    window.location = mail;
}

$("#select_eventos").click(function() {
     	$('#formUsers').submit();
});

$("#select_roles").click(function() {
     	$('#formUsers').submit();
});

$("#checkbox_ativos").click(function() {
     	$('#formUsers').submit();
});

$("#checkbox_excluidos").click(function() {
     	$('#formUsers').submit();
});

$("#checkbox_excluidos").click(function() {
     	$('#formUsers').submit();
});

$("#checkbox_bloqueados").click(function() {
     	$('#formUsers').submit();
});

$("#usuario").focusout(function() {
     	$('#formUsers').submit();
});



</script>
<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@stop