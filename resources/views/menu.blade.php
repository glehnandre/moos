@extends('layouts.master')

@section('title', 'Menu')


@section('links')

@stop

@section('content')
<!-- Modal INICIO -->
	<div id="modalImagem" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header invisivel-max-900">
				        <h4 class="modal-title">Imagem do menu</h4>
				</div>

				<div class="modal-body">
					<img src="#" alt="Thumbnail do Menu" id="imagemMenu" name="imagemMenu" class="img-responsive center-block">
				</div>
				<div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>


	<div id="modalImagemUpload" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Adicione um icone</h4>
				</div>
				<form action="#" method="post" id="formImagem"  enctype="multipart/form-data">
			    	{{csrf_field()}}
					<div class="modal-body">
						
								<div>
						            <label class="form-label">Thumbnail</label>
						            <div class="input-group">
						                <label class="input-group-btn">
						                    <span class="btn btn-primary">
						                        Escolha a imagem <input type="file" name="imagem" id="imagem" style="display: none;"  accept="image/x-png,image/gif,image/jpeg">
						                    </span>
						                </label>
						                <input type="text" class="form-control" id="fileLabel" readonly="">
						            </div>
						            <div class="row">
									    <div class="col-lg-1 col-centered">
									    	<img id="blah" src="https://dummyimage.com/100" 
						            	height="100" width="100" class="img-rounded" />
									    </div>
									</div>
						        </div>
					</div>
					<div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					        <button type="submit" class="btn btn-primary">Ok</button>
					</div>
				</form>
			</div>			
		</div>
	</div>



	<div id="modalMenu" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		   	<div class="modal-content">
		  	 <form id="formNovoItemMenu">
		  	 {{csrf_field()}}
		      <div class="modal-header">
		        <button type="button" class="close invisivel-max-900" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title" id="tituloModal">Novo Item de Menu</h4>
		      </div>
		      <div class="modal-body">
		      	<input name="evento_id" type="hidden" value="{{ $evento->id }}" class="form-control">
		      	<input id="formNovoItemMenuId" name="id" type="hidden" class="form-control">
		      	<div class="row">
                	<div class="col-md-12">
          				<div class="grid simple">
				      		<label class="form-label">Nome</label>
							<input name="nome" id="formNovoItemMenuNome" type="text" placeholder="Cerveja Corona" class="form-control">
						</div>
					</div>
		      	</div>
		      	<div class="row">
                	<div class="col-md-12">
          				<div class="grid simple">
				      		<label class="form-label">Descrição</label>
							<input type="text" id="formNovoItemMenuDescricao" name="descricao" placeholder="Ex: Cerveja importada Corona 300 ml" class="form-control">
						</div>
					</div>
		      	</div>
				<div class="row">
                	<div class="col-md-12">
          				<div class="grid simple">
				        	<label class="form-label">Preço unitário</label>
							<input type="text" id="formNovoItemMenuValor" class="form-control auto" data-mask="##0,00" data-mask-reverse="true" name="valor" placeholder="R$ 25,00">
						</div>
					</div>
				</div>
				
				<div class="row">
                	<div class="col-md-12">
          				<div class="grid simple">
			                  <label class="form-label">Categoria</label>
			                  <select id="formNovoItemMenuCategoria" name="categoria" class="form-control">
			                  	<option value="">Selecione...</option>
			                    <optgroup label="Alimentação">
			                    <option value="entrada">Entradas</option>
			                    <option value="principal">Prato Principal</option>
			                    <option value="sobremesa">Sobremesa</option>
			                    </optgroup>
			                    <optgroup label="Bebida">
			                    <option value="cerveja">Cerveja</option>
			                    <option value="whisky">Whisky</option>
			                    <option value="vodka">Vodka</option>
			                    <option value="licor">Licor</option>
			                    <option value="vinho">Vinho</option>
			                    <option value="naoalcolico">Não alcólico</option>
			                    </optgroup>
			                  </select>
			            </div>
			        </div>
                </div>
                <div class="row">
                	<div class="col-md-12">
          				<div class="grid simple">
          					<label class="form-label">
								Desconto
								<span id="formNovoItemMenuOutputDesconto" style="font-weight:bold">0</span><span class="semi-bold">%</span>
								<span> (Estimativa com desconto: R$ </span><span id="formNovoItemMenuOutputDescontoValor" class="semi-bold"></span><span>) </span>
							</label>
          					<input type="range" min="0" max="100" value="0" class="slider-color" id="formNovoItemMenuDesconto"  name="desconto" >
						</div>
					</div>
				</div>
                <div class="row">
                	  <label>Inativo<input name="ativo" id="formNovoItemMenuAtivo" type="checkbox" value="1"></label>
                </div>
		      </div>
		    </form>
           	 <div class="modal-footer">
		        <button type="button" class="btn btn-default" onclick="limparFormMenu();" data-dismiss="modal">Cancelar</button>
		        <button type="button" class="btn btn-success" onclick="incluirItemMenu({{ $evento->id }});">
		     		Ok
		 		</button>
		     </div>
		    </div>
		    <!-- Modal content-->
		  </div>
		</div>

<!-- Modal FIM -->
<div class="row" >

		<div class="row-fluid">
	        <div class="span12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4>Moos <span class="semi-bold">Menu</span> do {{ $evento->nome }}</h4>

	              <div class="tools">
	              <button data-toggle="modal" data-backdrop="false" data-keyboard="false" data-target="#modalMenu" type="button" class="btn btn-primary btn-cons">Novo</button>
	              </div>
	            </div>
	            <div class="grid-body ">
	              <table class="table table-striped" id="example3" >
	                <thead>
	                  <tr>
	                    <th>Id</th>
	                    <th>Nome</th>
	                    <th>Descrição</th>
	                    <th>Valor</th>
	                  	<th class="invisivel-max-900">Categoria</th>
	                  	<th class="invisivel-max-900">Ativo</th>
	                  	<th>Desconto</th>
	                  	<th class="invisivel-max-900">Atualizado em</th>
	                  	<th>Ações</th>
	                  </tr>
	                </thead>
	                <body>
	                @foreach($menus as $menu)
	                  <tr class="odd gradeX" id="{{ $menu->id }}">
	                    <td>{{ $menu->id }}</td>
	                    <td>{{ $menu->nome }}</td>
						<td>{{ $menu->descricao }}</td>
	                    <td data-mask="###,00" data-mask-reverse="true">
	                    	{{number_format($menu->valor, 2)}}
	                    </td>
	                    <td class="invisivel-max-900">{{ $menu->categoria }}</td>
	                    @if($menu->ativo == 1)         
						      <td class="invisivel-max-900">Ativo</td>         
						@else
						      <td class="invisivel-max-900">Inativo</td>        
						@endif
						<td>
		                 	{{ $menu->desconto }} %
						</td>
						<td class="invisivel-max-900">
		                 	{{ $menu->updated_at }}
						</td>
	                    <td>
	                    	<div class="btn-group invisivel-max-900" data-toggle="buttons-radio">
			                    <button class="btn btn-default " title="Excluir o item de menu" data-original-title="Excluir o item de menu" 
			                    onclick="

			                    bootbox.confirm({
								    message: 'Deseja realmente excluir esse item de menu?',
								    buttons: {
								        confirm: {
								            label: 'Sim',
								            className: 'btn-success'
								        },
								        cancel: {
								            label: 'Não',
								            className: 'btn-danger'
								        }
								    },
								    callback: function (result) {
								        if(result){
								        	deletarItemMenu('{{ $menu->id }}', this); 
								        }
								    }
								});"


			                    ><i class="fa  fa-trash-o"></i></button>
			                    <button class="btn btn-default " data-original-title="Editar item de menu" onclick="javascript:editaMenu('{{ $evento->id }}','{{  $menu->id }}');" title="Editar item de menu"><i class="fa fa-edit "></i></button>
			                    <button class="btn btn-default " title="Adicionar imagem" data-original-title="Adicionar imagem" onclick="javascript:modalImagemUpload('{{ $evento->id }}','{{  $menu->id }}');"><i class="fa fa-cloud-upload"></i></button>
			                    <button class="{{$menu->imagem != null ? 'btn btn-success' : 'btn btn-danger'}}" title="Ver imagem" onclick="javascript:modalImagemVer('{{ $menu->imagem }}','{{  $menu->imagem_type }}');" data-original-title="Ver imagem"><i class="fa fa-picture-o"></i></button>
		                	</div>
	                    	<div class="btn-group invisivel-min-900"> <a class="btn btn-success dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"> Ações </a>
				                    <ul class="dropdown-menu">
				                      <li><a href="#" onclick="javascript:deletarItemMenu('{{ $menu->id }}', this);">Deletar Item Menu</a></li>
				                      <li><a href="#" onclick="javascript:editaMenu('{{ $evento->id }}','{{  $menu->id }}');">Editar Item Menu</a></li>
				                      <li><a href="#" onclick="javascript:modalImagemUpload('{{ $evento->id }}','{{  $menu->id }}');">Upload de um icone</a></li>
				                      <li><a href="#" onclick="javascript:modalImagemVer('{{ $menu->imagem }}','{{  $menu->imagem_type }}');">Visualizar o icone</a></li>
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


@stop

@section('scripts')
<script>
	function selected(){
	  var myselect = document.getElementById("acoes");
	  alert(myselect.options[myselect.selectedIndex].value);
	}

	function incluirItemMenu(id_evento) {
		$('#formNovoItemMenuValor').val($('#formNovoItemMenuValor').val().replace(',', '.'));
		var form = $('#formNovoItemMenu').serialize();
		var idMenu = $('#formNovoItemMenuId').val();
		if(idMenu == null || idMenu == ''){
			$.ajax({
			   url: '/evento/'+id_evento+'/menu',
			   type: 'POST',
			   data: form,
			   success: function(response) {
			   		$('#modalMenu').modal('hide');
			     	toastr.success('Adicionado com sucesso.', 'Item de Menu', {timeOut: 5000});
			     	setTimeout(function(){
	                         location.reload();
	                }, 5000);     
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
			   url: '/evento/'+id_evento+'/menu/'+idMenu,
			   type: 'PUT',
			   data: form,
			   success: function(response) {
			     	toastr.success('Atualizado com sucesso.', 'Item de Menu', {timeOut: 5000});
			     	$('#modalMenu').modal('hide');
			     	setTimeout(function(){
	                         location.reload();
	                }, 5000);     
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


	function deletarItemMenu(id_menu, el) {
		var url = '{{route('delete_menu', ['id' => 'id_menu'])}}';
		url = url.replace('id_menu', id_menu);
	    $.ajax({
		   url: url,
		   type: 'DELETE',
		   data: {'id':id_menu},
		   success: function(response) {
		     	toastr.info('Removido com sucesso.', 'Item de Menu ' + id_menu, {timeOut: 5000});
		     	setTimeout(function(){
	                         location.reload();
	            }, 5000); 
		   },
		   error: function(request,msg,error) {
		        alert(error);
		   }
		});
	}

	$(document).on('change', ':file', function() {

	    var input = $(this),
	        numFiles = input.get(0).files ? input.get(0).files.length : 1,
	        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	    input.trigger('fileselect', [numFiles, label]);
	});


	$(document).ready( function() {
	    $(':file').on('fileselect', function(event, numFiles, label) {
	        $('#fileLabel').attr('value', label);
	    });
	});

	function readURL(input) {
	    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#blah').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		}
	}

	function editaMenu(idEvento, idMenu){
		var url = '{{route('get_menu', ['id_evento' => '#idEvento', 'id_menu' => '#idMenu'])}}';
		url = url.replace('#idMenu', idMenu);
		url = url.replace('#idEvento', idEvento);
	    $.ajax({
		   url: url,
		   type: 'GET',
		   data: {'id':idMenu},
		   success: function(response) {
		   		$('#formNovoItemMenuNome').attr('value', response.nome);
		   		$('#formNovoItemMenuValor').attr('value', response.valor);
		   		$('#formNovoItemMenuAtivo').attr('value', response.ativo);
		   		$('#formNovoItemMenuCategoria').attr('value', response.categoria);
		   		$('#formNovoItemMenuDesconto').attr('value', response.desconto);
				$('#formNovoItemMenuOutputDesconto').html(response.desconto);
		   		$('#formNovoItemMenuDescricao').attr('value', response.descricao);
		     	$('#formNovoItemMenuId').attr('value', response.id);
		     	$('#tituloModal').text('Atualizar Menu '+response.nome);
		     	$("#modalMenu").modal();

		   },
		   error: function(request,msg,error) {
		        alert(error);
		   }
		});
	}


	function limparFormMenu(){
		$('#formNovoItemMenuNome').attr('value', '');
		$('#formNovoItemMenuValor').attr('value', '');
		$('#formNovoItemMenuAtivo').attr('value', '');
		$('#formNovoItemMenuCategoria').attr('value', '');
		$('#formNovoItemMenuDesconto').attr('value', '0');
		$('#formNovoItemMenuOutputDesconto').html('0');
		$('#formNovoItemMenuDescricao').attr('value', '');
		$('#formNovoItemMenuId').attr('value', '');
		$('#tituloModal').text('Novo Item de Menu');
	}

	$("#imagem").change(function(){
	    readURL(this);
	});

	function modalImagemUpload(id_evento, id_menu){
		$("#modalImagemUpload").modal();
		$("#formImagem").attr('action', '/evento/'+id_evento+'/menu/'+id_menu+'/imagem');
	}

	function modalImagemVer(imagem, tipo){
		if(imagem!=null && imagem!=""){
			$("#modalImagem").modal();
		$("#imagemMenu").attr('src', 'data:image/'+tipo+';base64, '+imagem);
		}else{
			toastr.error( 'Ainda não há imagem para esse item de menu.' , 'Erro', {timeOut: 5000});
		}
		
	}

	@if(session('success'))
			toastr.info("{{Session::get('success')}}");
	@endif

	@if (count($errors) > 0)
            @foreach ($errors->all() as $error)
            	toastr.error( 'Erro' , {{ $error }}, {timeOut: 5000});
            @endforeach
    @endif

    $('input.money-bank').on('change load',function(e){   
    	var ajustado = (getValorEmReal(parseFloat($(this).val())));
    	$(this).val(ajustado);
    });
    //Inicio Slider desconto
	var slider = document.getElementById("formNovoItemMenuDesconto");
	var output = document.getElementById("formNovoItemMenuOutputDesconto");
	var valorDesconto = document.getElementById("formNovoItemMenuOutputDescontoValor");
	output.innerHTML = slider.value;
	valorDesconto.innerHTML = $('#formNovoItemMenuValor').val()==''? '0' : $('#formNovoItemMenuValor').val();
	slider.oninput = function() {

	    output.innerHTML = this.value;
	    var desconto = Number(this.value);
	    var valor = Number($('#formNovoItemMenuValor').val().replace(',', '.'));
	    valorDesconto.innerHTML = valor - desconto/100*valor;
	}
	//Fim Slider desconto


</script>

<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

@stop