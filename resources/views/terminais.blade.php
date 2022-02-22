@extends('layouts.master')

@section('title', 'Terminais')

@section('content')
<!-- Modal INICIO -->
<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		   	<div class="modal-content">
		  	 <form id="formFecharCaixaTerminal">
		  	 {{csrf_field()}}
		      <div class="modal-header">
		        <h4 id="tituloModal" class="modal-title invisivel-max-900">Fechamento Caixa</h4>
		      </div>
		      <div class="modal-body">
		        <input id="formTerminal" name="id" type="hidden" class="form-control">
				<label class="form-label">Valor Total</label>
				<h4 id="formValorLabel">0,00</h4>
				<input id="formValorTotal"  name="formValorTotal" type="hidden" class="form-control disabled">
		        
		        <label class="form-label">Valor Apurado</label>
				<input id="formValorApurado" name="formValorApurado" type="text" placeholder="Ex: Informe o valor apurado. Valor total das notas + recebido em dinheiro" class="form-control">

				<label class="form-label" style="margin-top: 10px;">Diferença de caixa: </label>
				<h2 id="formValorDiferençaCaixa">0,00</h2>
				<input id="formDiferenca" name="formDiferenca" type="hidden" class="form-control">
				<label class="form-label">Observação</label>
				<input id="formObservacao" name="formObservacao" type="text" placeholder="Detalhes do fechamento." class="form-control">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
		        <button id="formBotaoConferir" type="button" class="btn btn-success" onclick="conferirCaixa();">
		     		Ok
		 		</button>
		      </div>
		     </form>
		    </div>
		    <!-- Modal content-->
		  </div>
</div>
<!-- Modal FIM -->

<!-- Modal INICIO Terminal -->
<div id="novoTerminal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		   	<div class="modal-content">
		  	 <form id="formFecharCaixaTerminal">
		  	 {{csrf_field()}}
		      <div class="modal-header">
		        <h4 id="tituloModal" class="modal-title invisivel-max-900">Novo terminal</h4>
		      </div>
		      <div class="modal-body">
		        <input id="formTerminal" name="id" type="hidden" class="form-control">
				<select class="js-example-basic-multiple" style="width: 250; margin-right: 10px; margin-top: 10px" name="evento" id="evento">
									  		<option value="0">Selecione um estabelecimento</option>
											@foreach($eventos as $ev)
											  <option 
											  @if ($ev->id == $id)
											  	selected="selected"
											  @endif
											  value="{{$ev->id}}"
											  >{{$ev->nome}}</option>
											@endforeach
				</select>
				<label class="form-label" style="margin-top: 10px;">Código de sincronização</label>
				<div style=" display: flex;">
						<h3 id="formValorDiferençaCaixa">{{$codigo_sync}}</h2> 
						<button type="button" class="btn btn-warning" data-dismiss="modal" style="margin-left: 10px;">Novo Código</button>
				</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
		        <button id="formBotaoConferir" type="button" class="btn btn-success" onclick="conferirCaixa();">
		     		Ok
		 		</button>
		      </div>
		     </form>
		    </div>
		    <!-- Modal content-->
		  </div>
</div>
<!-- Modal FIM Terminal-->



<div class="row" >

	        <div class="col-sm-12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4>Moos <span class="semi-bold">Terminais</span> {{$nome_evento}}</h4>

	              <div class="tools">
	              	<button data-toggle="modal" data-backdrop="false" data-keyboard="false" data-target="#novoTerminal" type="button" class="btn btn-primary btn-cons">Novo Terminal</button>
	              </div>
	            </div>
	            <div class="grid-body ">
	              <table class="table table-striped dataTable" id="example_wrapper" >
	                <thead>
	                  <tr>
	                    <th>Terminal</th>
	                    <th>Tipo</th>
	                    <th>Usuário</th>
	                    @if($nome_evento == 'Ativos')
	                    	<th>Evento</th>
	                    @endif
	                    <th>Total(R$)</th>
	                    <th>Apurado(R$)</th>
	                    <th>Diferença(R$)</th>
	                  	<th class="invisivel-max-900">Atualizado</th>
	                  	<th>Ações</th>
	                  </tr>
	                </thead>
	                <body>
	                @foreach($terminais as $terminal)
	                  <tr class="odd gradeX" id="{{ $terminal->id }}" style="padding-top: 20px;">
	                    <td><a href="/evento/{{ $terminal->evento_id }}/terminal/{{ $terminal->id }}/transacoes">{{ $terminal->terminal_id }}</a></td>
	                    <td>{{ $terminal->tipo_transacao == 'credito' ? 'Caixa':'Bar' }}</td>
	                    <td >{{ $terminal->nome }}</td>
	                    @if($nome_evento == 'Ativos')
	                    	<td>{{ $terminal->nome_evento }}</td>
	                    @endif
	                    <script>
			                    	  var valor = getValorEmReal({{ $terminal->total == ''? 0 : $terminal->total}} );
								      document.write(
								      	"<td style='color:blue'>"+valor+"</td>"
								      );
						</script>
						<script>
			                    	  var valor = getValorEmReal({{ $terminal->valor_apurado }} );
								      document.write(
								      	"<td>"+valor+"</td>"
								      );
						</script>
						<script>
			                    	  var diferenca = {{ $terminal->valor_apurado }} - {{ $terminal->total == ''? 0 : $terminal->total}};
			                    	  if({{ $terminal->caixa_conferido }} == 1){
			                    	  		if(diferenca > 0){
			                    	  			document.write(
											      	"<td style='color:green'>"+getValorEmReal(diferenca)+"</td>"
											    );
			                    	  		}else if(diferenca < 0){
			                    	  			document.write(
											      	"<td style='color:red'>"+getValorEmReal(diferenca)+"</td>"
											    );
			                    	  		}else{
			                    	  			document.write("<td>R$ 0,00</td>");
			                    	  		}
			                    	  }else{
			                    	  		document.write("<td>R$ 0,00</td>");
			                    	  }
						</script>
	                    <td class="invisivel-max-900" >{{ $terminal->updated_at }}</td>
	                    <td>
	                    <div class="btn-group invisivel-max-900" data-toggle="buttons-radio">
	                    	<button class="btn {{ $terminal->caixa_fechado == 1 ? 'btn-primary disabled ':'btn-default' }} "  title="Fechar caixa" 
							onclick="bootbox.confirm('Deseja realmente fechar esse caixa?', function(result){ fecharCaixa({{ $terminal->id }}, {{$terminal->caixa_conferido}}, this); });"
	                    	 ><i class="fa fa-check"></i></button>
	                    	<button class="btn {{ $terminal->caixa_conferido == 1 ? 'btn-primary ':'btn-default' }}
		                	 " title="{{ $terminal->caixa_conferido == 1 ? 'Caixa conferido':'Conferir valores do caixa' }}" onclick="javascript:openModal('{{ $terminal->id }}', {{ empty($terminal->total) ? 0 : $terminal->total }} , {{$terminal->valor_apurado}}, '{{$terminal->observacao}}', {{$terminal->caixa_conferido}});"><i class="fa fa-money"></i></button>
	                     @if($terminal->ativo == 1)
		                    <button class="btn btn-default {{ $terminal->sync_menu == 1 ? '':'btn-danger' }} " title="{{ $terminal->sync_menu == 1 ? 'Forçar sincronização':'Aguardando a sincronização' }}" onclick="javascript:sincronizaTerminal('{{ $terminal->terminal_id }}', this);"><i class="fa fa-refresh"></i></button>
		                    @if($terminal->bloqueado == 0)  
		                    <button class="btn btn-default "  title="Bloquear o terminal" onclick="javascript:bloqueiaTerminal('{{ $terminal->id }}', this);"><i class="fa fa-unlock"></i></button>
		                    @else
		                    <button class="btn btn-danger "  title="Desbloquear o cartão" onclick="javascript:bloqueiaTerminal('{{ $terminal->id }}', this);"><i class="fa fa-lock"></i></button>
		                    @endif
		                    <button class="btn btn-default " title="Terminal Ativo" onclick="javascript:toggleAtivoTerminal('{{ $terminal->id }}', this);"><i class="fa fa-power-off"></i></button>
		                @else
		                	<button class="btn btn-danger disabled " title="Terminal Inativo" onclick="javascript:toggleAtivoTerminal('{{ $terminal->id }}', this);"><i class="fa fa-power-off"></i></button>
		                @endif
		                </div>
		                <div class="btn-group invisivel-min-900"> <a class="btn btn-success dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"> Ações </a>
				                    <ul class="dropdown-menu">
				                      <li><a href="#" onclick="bootbox.confirm('Deseja realmente fechar esse caixa?', function(result){ fecharCaixa({{ $terminal->id }}, {{$terminal->caixa_conferido}}, this); });">Fechar o Caixa</a></li>
				                      <li><a href="#" onclick="javascript:openModal('{{ $terminal->id }}', {{ empty($terminal->total) ? 0 : $terminal->total }} , {{$terminal->valor_apurado}}, '{{$terminal->observacao}}', {{$terminal->caixa_conferido}});">Conferir o Caixa</a></li>
				                      <li><a href="#" onclick="javascript:sincronizaTerminal('{{ $terminal->terminal_id }}', this);">Sincronizar o terminal</a></li>
				                      <li><a href="#" onclick="javascript:bloqueiaTerminal('{{ $terminal->id }}', this);">Bloquear o terminal</a></li>
				                    </ul>
				        </div>
	                  </tr>
	                  


	                @endforeach
	                </body>
	              </table>
	               <div class="col-md-12" style="margin-top: 10px;">
	            
	             	{{$terminais}} 	
				
	            </div>
	            </div>
	          </div>
	        </div>

	  </div>

@endsection

@section('scripts')
<script>
function toggleAtivoTerminal(terminal, el) {
		var url = '/terminal/'+terminal+'/active';
	    $.ajax({
		   url: url,
		   type: 'GET',
		   success: function(response) {
		   		if(response == 'Inativo') {
		   			$(el).attr('title', 'Terminal Inativo');
		   			$(el).toggleClass('btn-default btn-danger');
		   			toastr.info('Terminal Inativo.', 'Terminal ' + terminal, {timeOut: 5000});
		   		}else{
		   			$(el).attr('title', 'Terminal Ativo');
		   			$(el).toggleClass('btn-default btn-danger');
		   			toastr.info('Terminal Ativo.', 'Terminal ' + terminal, {timeOut: 5000});
		   		}
		   		location.reload();
		   },
		   error: function(request,msg,error) {
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}

	function bloqueiaTerminal(terminal, el) {
		var url = '/terminal/'+terminal+'/block';
	    $.ajax({
		   url: url,
		   type: 'GET',
		   success: function(response) {
		   		if(response == 'bloqueado') {
		   			$(el).attr('data-original-title', 'Desbloquear o Terminal');
		   			$(el).toggleClass('btn-default btn-danger');
		   		}else{
		   			$(el).attr('data-original-title', 'Bloquear o Terminal');
		   			$(el).toggleClass('btn-default btn-danger');
		   		}
		   		$(el).children().toggleClass('fa-lock fa-unlock');
		     	toastr.info('Terminal ' + response, 'Terminal ' + terminal, {timeOut: 5000});
		   },
		   error: function(request,msg,error) {
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}

	function conferirCaixa(el) {
		var form = $('#formFecharCaixaTerminal').serialize();
		var terminal = $('#formTerminal').val();
		var url = '/terminal/'+terminal+'/conferir';
		console.log(url);
	    $.ajax({
		   url: url,
		   type: 'POST',
		   data: form,
		   success: function(response) {
		   	console.log('sucesso');
		   	console.log(response);
		   		$('#myModal').modal('hide');
		   		location.reload();
		   		
		     	toastr.info('Caixa conferido', {timeOut: 5000});
		   },
		   error: function(request,msg,error) {
		   	console.log('erro');
		   	console.log(request);
		   	console.log(msg);
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}


	function fecharCaixa(id, isConferido, el) {
		if(isConferido == 1){
					var url = '/terminal/'+id+'/fechar';
				    $.ajax({
					   url: url,
					   type: 'get',
					   success: function(response) {
					   		$(el).attr('title', 'Caixa fechado');
					   		$(el).removeClass('btn-default');
					   		$(el).addClass('btn-primary');
					   		$(el).addClass('disabled');
					     	toastr.info('Caixa fechado', {timeOut: 5000});
					     	location.reload();
					   },
					   error: function(request,msg,error) {
					       toastr.error(error, 'Erro ', {timeOut: 5000});
					   }
					});
		}else{

			 toastr.error('O Caixa ainda não está conferido. Clique no botão de conferir o caixa, cheque os valores apurados e dê o OK. O valor sobrando ou faltando do caixa, junto com a justificativa, serão lançados e o caixa terminal poderá ser fechado.', 'Erro ', {timeOut: 10000});
		}
	}

	function openModal(terminal, valorTotal, valorConferido, observacao, conferido){
		$('#formTerminal').val(terminal);
		$('#formValorTotal').val(valorTotal);
		var valorTratado = getValorEmReal(valorTotal); 
		$('#formValorLabel').html("R$ " + valorTratado);
    	$('#myModal').modal('show');

    	if(conferido == 1){
    		$('#formValorDiferençaCaixa').html("R$ " + (valorConferido - valorTotal));
			$('#formValorApurado').val(valorConferido);
			$('#formValorApurado').attr("disabled", true);
			$('#formObservacao').val(observacao);
			$('#formObservacao').attr("disabled", true);
			$('#formBotaoConferir').attr("disabled", true);
    	}
	}

	$('#formValorApurado').focusout(function(){
		var valor =  $('#formValorApurado').val() - parseFloat($('#formValorTotal').val());
    	$('#formDiferenca').val(valor);
    	var valorTratado = getValorEmReal(valor); 
    	$('#formValorDiferençaCaixa').html("R$ " + valorTratado);
    	if(valor > 0){
			$('#formValorDiferençaCaixa').addClass('text-success');
			$('#formValorDiferençaCaixa').removeClass('text-error');
		}else{
			$('#formValorDiferençaCaixa').addClass('text-error');
			$('#formValorDiferençaCaixa').removeClass('text-success');
		}
		
	});


	function sincronizaTerminal(terminal, el) {
		var url = '/terminal/'+terminal+'/sync';
	    $.ajax({
		   url: url,
		   type: 'GET',
		   success: function(response) {
		   		if(response == 'Pendente') {
		   			$(el).attr('data-original-title', 'Forçar a sincronização');
		   		}else{
		   			$(el).attr('data-original-title', 'Cancelar a sincronização');
		   		}
		   		toastr.info('Sincronizando...', 'Terminal ' + terminal, {timeOut: 2500});
				$(el).children().addClass('fa-spin');
				setTimeout(function() {
					location.reload();
				    $(el).children().removeClass('fa-spin');
				},1000);
		   },
		   error: function(request,msg,error) {
		       toastr.error(error, 'Erro ', {timeOut: 5000});
		   }
		});
	}

	

</script>
<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
@stop