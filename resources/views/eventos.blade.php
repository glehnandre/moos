@extends('layouts.master')

@section('title', 'Eventos')

@section('content')
<!-- Modal INICIO -->
	<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		   	<div class="modal-content">
		  	 <form id="formNovoEvento">
		  	 {{csrf_field()}}
		      <div class="modal-header">
		        <h4 id="tituloModal" class="modal-title invisivel-max-900">Novo Evento</h4>
		      </div>
		      <div class="modal-body">
		      	<input id="formNovoEventoId" name="id" type="hidden" class="form-control">
		      	<label class="form-label">Nome</label>
				<input id="formNovoEventoNome" name="nome" type="text" placeholder="Ex: Seu João" class="form-control">
				<label class="form-label">Descrição</label>
				<input id="formNovoEventoDescricao" type="text" name="descricao" placeholder="Ex: Festa de São João das ASBAC" class="form-control">

				<div class="input-append success date no-padding">
					<label class="form-label">Data do evento</label>
		            <input id="formNovoEventoDataEvento" type="date" name="data_evento" class="form-control">
		        </div>
		        
		        <label class="form-label">Local</label>
				<input id="formNovoEventoLocal" name="local" type="text" placeholder="Ex: SCES trecho 2 ASBC" class="form-control">

				<label class="form-label">Latitude</label>
				<input id="formNovoEventoLatitude" name="local" type="text" placeholder="Ex: -15.2738" class="form-control">

				<label class="form-label">Longitude</label>
				<input id="formNovoEventoLongitude" name="local" type="text" placeholder="Ex: -15.999" class="form-control">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
		        <button type="button" class="btn btn-success" onclick="incluiEvento();">
		     		Adicionar
		 		</button>
		      </div>
		     </form>
		    </div>
		    <!-- Modal content-->
		  </div>
		</div>

<!-- Modal FIM -->
<div class="row" >
		<div>
	        <div class="col-sm-12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4>Moos <span class="semi-bold">Eventos</span></h4>
	              <div class="tools">
	              <button data-toggle="modal" data-backdrop="false" data-keyboard="false" data-target="#myModal" type="button" class="btn btn-primary btn-cons">Novo</button>
	              </div>
	            </div>
	            <div class="grid-body ">
	              <table class="table table-striped dataTable" id="example_wrapper" >
	                <thead>
	                  <tr>
	                    <th>Id</th>
	                    <th>Nome</th>
	                    <th class="invisivel-max-900">Descrição</th>
	                    <th class="invisivel-max-900">Data</th>
	                  	<th class="invisivel-max-900">Cadastrado em</th>
	                  	<th class="invisivel-max-900">Status</th>
	                  	<th>Ações</th>
	                  </tr>
	                </thead>
	                <body>
	                @foreach($eventos as $evento)
	                  <tr class="odd gradeX" id="{{ $evento->id }}{{ $evento->nome }}">
	                    <td>{{ $evento->id }}</td>
	                    <td>{{ $evento->nome }}</td>
	                    <td class="invisivel-max-900">{{ $evento->descricao }}</td>
	                    <td class="invisivel-max-900">{{ $evento->data_evento }}</td>
	                    <td class="invisivel-max-900">{{ $evento->created_at }}</td>
	                    <td class="invisivel-max-900">{{ $evento->ativo? 'Ativo' : 'Inativo' }}</td>
	                    <td>
	                   
	                    <div class="btn-group invisivel-max-900" data-toggle="buttons-radio">
	                       @if(Auth::user()->isAdministrator() == 1)  
		                    <button class="btn btn-default " title="Excluir o evento" onclick="javascript:deletaEvento('{{ $evento->id }}', this);"><i class="fa fa-trash-o"></i></button>
		                    <button class="btn btn-default " title="Editar o evento" onclick="javascript:editaMenu('{{ $evento->id }}');"><i class="fa fa-pencil"></i></button>
		                   @endif
		                    <button class="btn btn-default " title="Menu do evento" onClick="window.open('evento/{{ $evento->id }}/menu');"><i class="fa fa-cutlery"></i></button>
		                    <button class="btn btn-default " title="Transações do evento" onClick="window.open('evento/{{ $evento->id }}/transacoes');"><i class="fa fa-usd"></i></button>
		                    <button class="btn btn-default" title="Terminais do evento" onClick="window.open('evento/{{ $evento->id }}/terminais');"><i class="fa fa-mobile-phone"></i></button>
		                    <button class="btn btn-default " onClick="window.open('evento/{{ $evento->id }}/usuarios');" title="Funcionários do evento"><i class="fa fa-group"></i></button>
		                    @if($evento->ativo == 1)  
		                    <button class="btn btn-default " title="Evento Ativo"  title="Inativar o evento" onclick="javascript:toggleAtivoEvento('{{ $evento->id }}', this);"><i class="fa fa-power-off"></i></button>
		                    @else
		                    <button class="btn btn-danger " title="Evento Inativo" data-original-title="Ativar o evento" onclick="javascript:toggleAtivoEvento('{{ $evento->id }}', this);"><i class="fa fa-power-off"></i></button>
		                    @endif
		                </div>
		                <div class="btn-group invisivel-min-900"> <a class="btn btn-success dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"> Ações </a>
				                    <ul class="dropdown-menu">
				                    @if(Auth::user()->isAdministrator() == 1) 
				                      <li><a href="#" onclick="javascript:deletaEvento('{{ $evento->id }}', this);">Excluir Evento</a></li>
				                      <li><a href="#" onclick="javascript:editaMenu('{{ $evento->id }}');">Editar Evento</a></li>
				                    @endif
				                      <li><a href="#" onclick="window.open('evento/{{ $evento->id }}/menu');">Menu do Evento</a></li>
				                      <li><a href="#" onclick="window.open('evento/{{ $evento->id }}/transacoes');">Transações do evento</a></li>
				                      <li><a href="#" onclick="window.open('evento/{{ $evento->id }}/terminais');">Terminais do evento</a></li>
				                      <li><a href="#" onclick="window.open('evento/{{ $evento->id }}/usuarios');" >Funcionários do evento</a></li>
				                      @if($evento->ativo == 1)  
				                      <li><a href="#" title="Inativar Evento" onclick="javascript:toggleAtivoEvento('{{ $evento->id }}', this);">Inativar Evento</a></li>
					                    
					                    @else
					                  <li><a href="#" title="Ativar Evento" onclick="javascript:toggleAtivoEvento('{{ $evento->id }}', this);">Ativar Evento</a></li>
					                  @endif
				                    </ul>
				        </div>
		                
	                    </td>
	                  </tr>
	                @endforeach
	                </body>
	              </table>
	            </div>
	          </div>
	        </div>
      	</div>
	  </div>
@endsection

@section('scripts')

<script>
	function incluiEvento() {
		var url = '{{route('cria_evento')}}';
		var form = $('#formNovoEvento').serialize();
		var idEvento = $('#formNovoEventoId').val();
		if(idEvento == null || idEvento == ''){
				   $.ajax({
				   url: url,
				   type: 'POST',
				   data: form,
				   success: function(response) {
				     	toastr.success('Adicionado com sucesso.', 'Evento', {timeOut: 9000});
				     	$('#myModal').modal('hide');
				     	setTimeout(function(){
		                         location.reload();
		                }, 2000);     
				   },
				   error   : function (data) 
		           {
			            var resposta = $.parseJSON(data.responseText);
			            var erros = resposta.errors;
			            console.log(resposta);
			            for (const key of Object.keys(erros)) {
			            	toastr.error( erros[key] , key, {timeOut: 5000});
						}
		           }
				});
		}else{
				$.ajax({
				   url: '/evento/'+idEvento,
			   	   type: 'PUT',
				   data: form,
				   success: function(response) {
				     	toastr.success('Atualizado com sucesso.', 'Evento', {timeOut: 9000});
				     	$('#myModal').modal('hide');
				     	setTimeout(function(){
		                         location.reload();
		                }, 2000);     
				   },
				   error   : function (data) 
		           {
			            var resposta = $.parseJSON(data.responseText);
			            var erros = resposta.errors;
			            console.log(resposta);
			            for (const key of Object.keys(erros)) {
			            	toastr.error( erros[key] , key, {timeOut: 5000});
						}
		           }
				});

		}
	}


	function deletaEvento(id_evento, el) {
		var url = '{{route('delete_evento', ['id' => 'id_evento'])}}';
		url = url.replace('id_evento', id_evento);
	    $.ajax({
		   url: url,
		   type: 'DELETE',
		   data: {'id':id_evento},
		   success: function(response) {
		   		$(el).parent().parent().remove();
		     	toastr.info('Removido com sucesso.', 'Evento ' + id_evento, {timeOut: 5000});
		   },
		   error: function(request,msg,error) {
		        alert(error);
		   }
		});
	}

	function toggleAtivoEvento(evento, el) {
		var url = '/evento/'+evento+'/active';
	    $.ajax({
		   url: url,
		   type: 'GET',
		   success: function(response) {
		   		if(response == 'Inativo') {
		   			$(el).attr('title', 'Evento Inativo');
		   			$(el).toggleClass('btn-default btn-danger');
		   			toastr.info('Evento Inativo.', 'Evento ' + evento, {timeOut: 5000});
		   		}else{
		   			$(el).attr('title', 'Evento Ativo');
		   			$(el).toggleClass('btn-default btn-danger');
		   			toastr.info('Evento Ativo.', 'Evento ' + evento, {timeOut: 5000});
		   		}
		   		location.reload();
		   },
		   error: function(request,msg,error) {
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}



	function editaMenu(idEvento){
		var url = '/evento/'+idEvento;
	    $.ajax({
		   url: url,
		   type: 'GET',
		   success: function(response) {
		   		console.log(response);
		   		$('#formNovoEventoId').attr('value', response.id);
		   		$('#formNovoEventoNome').attr('value', response.nome);
		   		$('#formNovoEventoDescricao').attr('value', response.descricao);
		   		var now = new Date(response.data_evento);
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
		   		$('#formNovoEventoDataEvento').val(today);
		   		$('#formNovoEventoLocal').attr('value', response.local);
		   		$('#formNovoEventoLatitude').attr('value', response.latitude);
		   		$('#formNovoEventoLongitude').attr('value', response.longitude);
		     	$('#tituloModal').text('Atualizar Evento '+response.nome);
		     	$("#myModal").modal();

		   },
		   error: function(request,msg,error) {
		        alert(error);
		   }
		});
	}

</script>

<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
@stop