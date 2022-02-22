@extends('layouts.master')

@section('title', 'Cartoes')


@section('content')
@if(Auth::user()->isAdministrator() == 1) 
<div class="invisivel-max-900">
<form method="GET" action="/cartoes" id="formCartoes" name="formCartoes">
{{ csrf_field() }}
		<div class="col-sm-12">
	          <div class="grid simple">
	            <div class="grid-title">
	              <h4>Filtros</h4>
	              <div class="tools">
	              <a href="javascript:;" class="collapse"></a></div>
	            </div>
	            <div class="grid-body">
	            	<div>

		            	<div class="btn-group" role="group" aria-label="Basic example" style="float:left; padding:0px 10px;">
		            	  <input type="hidden" id="ativo" name="ativo" value="{{$request->ativo}}">
						  <button type="button" id="cartoes_todos" class="btn btn-secondary {{ $ativo == 0 ? 'active':'' }}">Todos os cartões</button>
						  <button type="button" id="cartoes_ativos" class="btn btn-secondary {{ $ativo == 1 ? 'active':'' }}">Somente cartões ativos</button>
						</div>
						<div style="float:left;>	
							<span class="h-seperate"></span>
						</div>
						<div class="btn-group" role="group" aria-label="Basic example" style="float:left;padding:0px 10px;">
							<input type="hidden" id="ultimo" name="ultimo" value="{{$request->ultimo}}">
						  	<button type="button" id="criado_evento" class="btn btn-secondary {{ $ultimo == 0 ? 'active':'' }}">Criado no evento</button>
						  	<button type="button" id="ultimo_evento" class="btn btn-secondary {{ $ultimo == 1 ? 'active':''}}">Utilizado no evento</button>
						</div>
						<div style="float:left; padding:0px 5px; vertical-align: middle;">
							<select class="js-example-basic-multiple" style="width: 250;" name="evento" id="evento">
							  		<option value="0">Selecione evento</option>
									@foreach($eventos as $ev)
									  <option 
									  @if ($ev->id == $evento)
									  	selected="selected"
									  @endif
									  value="{{$ev->id}}"
									  >{{$ev->nome}}</option>
									@endforeach
							</select>
						</div>
						<div style="float:left; padding:0px 20px; vertical-align: middle;">
							<select class="js-example-basic-multiple" id="user" name="user">
								<option value="0">Selecione usuário</option>
								@foreach($users as $u)
								  <option 
								 	@if ($u->id == $user)
									  	selected="selected"
									@endif
								  value="{{$u->id}}">{{$u->nome}} ({{$u->cpf}})</option>
								@endforeach
							</select>
						</div>

					</div>
	            </div>
	          </div>
	    </div>
</form>
</div>
@endif
<div class="" >
		<div class="col-sm-12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4>Moos <span class="semi-bold">Cartões</span></h4>
	              <div class="tools">
	   		           	              		
	              </div>
	            </div>
	            <div class="grid-body ">
	              <table class="table table-striped dataTable" id="example_wrapper" >
	                <thead>
	                  <tr>
	                    <th class="invisivel-max-900">Id</th>
	                    <th>Cartão</th>
	                    <th class="invisivel-max-900">Total (R$)</th>
	                    <th class="invisivel-max-900">Dono</th>
	                    <th class="invisivel-max-900">Evento</th>
	                  	<th class="invisivel-max-900">Email</th>
	                  	<th class="invisivel-max-900">Criado em</th>
	                  	<th>Ações</th>
	                  </tr>
	                </thead>
	                <body>
	                @foreach($cartoes as $cartao)
	                  <tr class="odd gradeX" id="{{ $cartao->id }}{{ $cartao->nome }}">
	                    <td class="invisivel-max-900">{{ $cartao->id }}</td>
	                    <script>
	                    			  var calculo = {{ $cartao->total_credito - $cartao->total_debito }};
			                    	  var valor = getValorEmReal(calculo);
			                    	  var cartaoId = {{ $cartao->cartao_id }}.toString(16);
			                    	  if(calculo >0){
			                    	  	document.write(
								      		"<td class='invisivel-min-900' style='color:green' title='Dono: {{$cartao->nome}}'>"+valor+" ("+cartaoId+")</td>"
								     	 );
			                    	  }else{
			                    	  	document.write(
								      		"<td class='invisivel-min-900' title='Dono: {{$cartao->nome}}'>"+valor+" ("+cartaoId+")</td>"
								     	 );
			                    	  }
								      
						</script>
	                    <td class="invisivel-max-900">{{ $cartao->cartao_id }}</td>
	                    <script>
	                    			  var calculo = {{ $cartao->total_credito - $cartao->total_debito }};
			                    	  var valor = getValorEmReal(calculo);
			                    	  if(calculo >0){
			                    	  	document.write(
								      		"<td class='invisivel-max-900' style='color:green'>"+valor+"</td>"
								     	 );
			                    	  }else{
			                    	  	document.write(
								      		"<td class='invisivel-max-900'>"+valor+"</td>"
								     	 );
			                    	  }
								      
						</script>
	                    <td class="invisivel-max-900">{{ $cartao->nome }} ({{ $cartao->cpf }})</td>
	                    <td class="invisivel-max-900">{{ $cartao->evento_nome }}</td>
	                    <td class="invisivel-max-900">{{ $cartao->email }}</td>
	                    <td class="invisivel-max-900">{{ $cartao->timestamp }}</td>	                    
	                    <td>
	                    <div class="btn-group" data-toggle="buttons-radio">
		                    <button class="btn btn-default " title="Transações" onClick="window.open('/cartao/{{ $cartao->id }}/transacoes');"><i class="fa fa-credit-card"></i></button>
		                   	<button class="btn btn-default " title="Transferencia entre cartões" onClick="javascript:promptCartoes({{ $cartao->cartao_id }},{{ $cartao->id }},{{ $cartao->user_id }});"><i class="fa fa-long-arrow-down"></i><i class="fa fa-long-arrow-up"></i></button>
		                    @if($cartao->ativo == 0)
		                    <button class="btn btn-danger disabled " title="Cartão Inativo" title="Cartão Inativo"><i class="fa fa-power-off"></i></button>
		                    @elseif($cartao->bloqueado == 0)  
			                    @if(Auth::user()->isAdministrator() == 1)  
			                    		<button class="btn btn-default " title="Transações" onclick="javascript:deletaCartao('{{ $cartao->id }}', this);"><i class="fa fa-power-off"></i></button>
				                @endif
		                   		<button class="btn btn-default "  title="Bloquear o cartão" onclick="javascript:bloqueiaCartao('{{ $cartao->id }}', this);"><i class="fa fa-unlock"></i></button>
		                    @else
		                    	<button class="btn btn-danger " title="Desbloquear o cartão" onclick="javascript:bloqueiaCartao('{{ $cartao->id }}', this);"><i class="fa fa-lock"></i></button>

		                    @endif
		                </div>
	                  </tr>
	                @endforeach
	                </body>
	              </table>
	            <div class="col-md-12" style="margin-top: 10px;">
	            @if(Auth::user()->isAdministrator() == 1)  
	             	{{$cartoes}} 	
				@endif
	            </div>
	            </div>
	          </div>
	        </div>

	  </div>

@endsection


@section('scripts')
<script>

    function transacoes(cartao){
    	$('#modal'+cartao).modal('toggle');
    }

	function bloqueiaCartao(cartao, el) {
		var url = '/cartao/'+cartao+'/block';
	    $.ajax({
		   url: url,
		   type: 'GET',
		   success: function(response) {
		   		if(response == 'bloqueado') {
		   			$(el).attr('data-original-title', 'Desbloquear o cartão');
		   			$(el).toggleClass('btn-default btn-danger');
		   		}else{
		   			$(el).attr('data-original-title', 'Bloquear o cartão');
		   			$(el).toggleClass('btn-default btn-danger');
		   		}
		   		$(el).children().toggleClass('fa-lock fa-unlock');
		     	toastr.info('Cartão ' + response, 'Cartao ' + cartao, {timeOut: 5000});
		   },
		   error: function(request,msg,error) {
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}

	function deletaCartao(cartao, el) {
		var url = '/cartao/'+cartao+'/inativar';
	    $.ajax({
		   url: url,
           type: 'GET',
		   success: function(response) {
		   		console.log(response);
		     	toastr.info('Cartão Inativado. ' + response, 'Cartão', {timeOut: 5000});
		     	setTimeout(function(){
	                         location.reload();
	            }, 2000);    
		   },
		   error: function(request,msg,error) {
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}


	function promptCartoes(cartao_origem, id_cartao_origem, user_id) {
		var url = '/api/user/'+user_id+'/cartoes';
	    $.ajax({
		   url: url,
           type: 'GET',
		   success: function(response) {
		   		if(response.length > 0){
		   			escolheCartoes(cartao_origem, id_cartao_origem, response);  
		   		}else{
		   			toastr.warning('Usuário não possui outros cartões para transferir os fundos. ', {timeOut: 5000});
		   		}
		     	
		   },
		   error: function(request,msg,error) {
		       toastr.error(error, 'Erro ao recuperar os cartões do usuário. ', {timeOut: 5000});
		   }
		});
	}

	function escolheCartoes(cartao_origem, id_cartao_origem, cartoes){
		var options = [];
		
		for (var i = 0; i < cartoes.length; i++) {
			options.push({text: cartoes[i].cartao_id, value: cartoes[i].id});
		}

		var cartaoId = cartao_origem.toString(16);
		bootbox.prompt({
							    title: 'Escolha um cartão ' + cartaoId,
							    inputType: 'select',
							    closeButton: false,
							    inputOptions: options,
							    callback: function (result) {
							    	if(result != null){
							    		escolheValor(id_cartao_origem, result);
							    	}
							    }
						}
					);
	}

	function escolheValor(id_cartao_origem, id_cartao_destino){
		bootbox.prompt({
							    title: 'Valor a ser transferido para o cartão',
							    inputType: 'number',
							    closeButton: false,
							    callback: function (result) {
							    	if(result!=null && result != 0){
							    		transfereFundos(result, id_cartao_origem,id_cartao_destino);
							    	}
							    }
						}
					);
	}

	function transfereFundos(valor, id_cartao_origem, id_cartao_destino){
		var url = '/transacoes/valor/'+valor+'/origem/'+id_cartao_origem+ '/destino/' + id_cartao_destino;
	    $.ajax({
		   url: url,
           type: 'GET',
		   success: function(response) {
		     	console.log(response);
		     	toastr.success('Fundos transferidos. ', {timeOut: 5000});
		     	setTimeout(function(){
	                         location.reload();
	            }, 2000);    
		   },
		   error: function(response,msg,error) {
		   	   console.log(response);
		       toastr.error(response.responseText, 'Erro ao transferir os fundos de um cartão para o outro. ', {timeOut: 5000});
		   }
		});
	}

	function refreshTable() {
		 var url = '/cartoes/table';
		 var form = $('#formCartoes').serialize();
		 $('div.table-container').fadeOut();
		 $('div.spinner').addClass('loader')
		 $.ajax({
				   url: url,
				   type: 'GET',
				   data: form,
				   success: function(data) {
				     	$('div.table-container').html(data);
				     	$('div.spinner').removeClass('loader') 
				     	$('div.table-container').fadeIn(); 

				   },
				   error   : function (data) 
		           {	
		           		$('div.spinner').removeClass('loader') 
		           		$('div.table-container').fadeIn(); 
		           		console.log(data);
			            toastr.success('Erro ao carregar tabela.', 'Cartões', {timeOut: 9000});
		           }
				});
	}

	$(document).ready(function() {
	    $('.js-example-basic-multiple').select2({
	    	 width: 'resolve' 
	    });
	});

	$("#cartoes_todos").click(function() {
		$("#ativo").val(0);
		$("#cartoes_todos").addClass('active');
		$("#cartoes_ativos").removeClass('active');
     	$('#formCartoes').submit();
	});

	$("#cartoes_ativos").click(function() {
		$("#ativo").val(1);
		$("#cartoes_todos").removeClass('active');
		$("#cartoes_ativos").addClass('active');
     	$('#formCartoes').submit();
	});

	$("#criado_evento").click(function() {
		$("#ultimo").val(0);
		$("#criado_evento").addClass('active');
		$("#ultimo_evento").removeClass('active');
     	$('#formCartoes').submit();
	});

	$("#ultimo_evento").click(function() {
		$("#ultimo").val(1);
		$("#criado_evento").removeClass('active');
		$("#ultimo_evento").addClass('active');
     	$('#formCartoes').submit();
	});

	$("#evento").change(function() {
		$('#formCartoes').submit();
	});
	
	$("#user").change(function() {
		$('#formCartoes').submit();
	});

</script>
<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@stop