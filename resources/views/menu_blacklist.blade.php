@extends('layouts.master')

@section('title', 'Menu Restrições')


@section('links')

@stop

@section('content')
<form method="POST" action="/menu/restricoes" id="formMenu" name="formMenu">
		{{ csrf_field() }}
		<input type="hidden" name="itens_menu" id="itens_menu">
<div class="col-md-12" >

		<div class="row-fluid">
	        <div class="span12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4>Moos <span class="semi-bold">Restrições</span> do Menu</h4>
	              <div class="tools">
	              <button data-keyboard="false" type="button" class="btn btn-primary btn-cons" onclick="javascript:salvar();">Salvar</button>
	              </div>
	            </div>
	            <div class="grid-body ">
	               	<div>
								<div style="float:left;">
									<select class="js-example-basic-multiple" style="width: 250; margin-right: 10px; margin-top: 10px" name="evento" id="evento">
									  		<option value="0">Selecione um estabelecimento</option>
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
								<div style="float:left; margin-top: 10px">
									<select class="js-example-basic-multiple" id="cartao" name="cartao">
										<option value="0">Selecione um cartão</option>
										@foreach($cartoes as $ca)
											  <option 
											  @if ($ca->id == $cartao)
											  	selected="selected"
											  @endif
											  value="{{$ca->id}}"
											  >{{$ca->cartao_id}}</option>
										@endforeach
									</select>
								</div>
					</div>
				<div id="menu_blacklist_table" style="padding-top: 60px;">	
	            	@include('menu_blacklist_table')
	            </div>
	            </div>
	          </div>
	        </div>
      	</div>
	  </div>
</form>

@stop

@section('scripts')
<script>

	function salvar(){
		if($('#evento').val()==0 || $('#cartao').val() ==0){
			toastr.error('É necessário selecinar um estabelecimento e um cartão.', 'Erro ', {timeOut: 5000});
		}else{
			var itens_menu = [];
            $.each($("input[name='menu_id']"), function(){ 
            	var id = $(this).val(); 
            	var menu_id = {"menu_id": $(this).val(), "quantidade": $('#quantidade_'+ id).val(), "restrito": $(this).is(":checked"), "restrito_id": $('#id_restrito_' + id).val(), "frequencia": $('#frequencia_' + id).val()};
				var JSONString = JSON.stringify(menu_id);
                itens_menu.push(JSONString);
            });
            var itens_menu_json = JSON.stringify(itens_menu);
            console.log(itens_menu_json);
			$('#itens_menu').val(itens_menu_json);
			var form = $('#formMenu').serialize();
		    $.ajax({
		            type: "POST",
		            url: "/menu/restricoes",
		            data: form,
		            success: function(response) {
					     	toastr.success('Restrições salvas com sucesso. ', 'Restrições', {timeOut: 9000});

					},
				    error: function(request,msg,error) {
				       toastr.error(error, 'Erro ', {timeOut: 5000});
				    }
		    });
		}
	}

	$("#evento").change(function() {
		refreshTable($("#evento").val());
	});

	$("#cartao").change(function() {
		refreshTableCartao($("#evento").val(), $("#cartao").val());
	});


	function refreshTableCartao(evento_id, cartao_id) {
	  var url = '/menu/evento/'+evento_id+'/cartao/'+cartao_id;
	  $('#menu_blacklist_table').fadeOut();
	  $('#menu_blacklist_table').load(url, function() {
	      $('#menu_blacklist_table').fadeIn();
	  });
	}

	function refreshTable(evento_id) {
	  var url = '/menu/evento/'+evento_id;
	  $('#menu_blacklist_table').fadeOut();
	  $('#menu_blacklist_table').load(url, function() {
	      $('#menu_blacklist_table').fadeIn();
	  });
	}

	function changeLineColor(el) {
	  $('#menu_blacklist_table').fadeOut();
	  $('#menu_blacklist_table').load(url, function() {
	      $('#menu_blacklist_table').fadeIn();
	  });
	}

</script>

<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

@stop