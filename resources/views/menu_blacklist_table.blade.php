@if($menus!=null && !$menus->isEmpty()) 
<table class="table table-striped" id="example_wrapper" >
	                <thead>
	                  <tr>
	                  	<th>Restrito</th>
	                    <th>Produto</th>
	                    <th>Valor</th>
	                    <th>Quantidade</th>
	                    <th>Frequência</th>
	                  	<th></th>
	                  </tr>
	                </thead>
	                <body>
	               @foreach($menus as $menu)
	                  <tr class="odd gradeX" id="">
	                    <input type="hidden" id="id_restrito_{{$menu->id}}" name="id_restrito_{{$menu->id}}" value="{{$menu->restrito_id}}">
	                    <td>
		                   	<div class="form-check" style=" float:left;vertical-align: middle;">
							  <input class="form-check-input position-static" style="vertical-align: middle;" type="checkbox" id="menu_id" name="menu_id" value="{{$menu->id}}" {{ $menu->restrito == 1 ? 'checked':'' }}>
							</div>
						</td>
	                    <td>{{ $menu->nome }}</td>
						<td>{{number_format($menu->valor, 2)}}</td>
						<td><input type="number" class="quantidade" id="quantidade_{{$menu->id}}" value="{{$menu->quantidade == 0 ? '' : $menu->quantidade}}" placeholder="À vontade" style="width: 100px" min="0"></td>
						<td>
							<select class="js-example-basic frequencia" id="frequencia_{{$menu->id}}" name="frequencia_{{$menu->id}}" disabled="true">
										<option value="">Selecione a frequência</option>
										<option value="1">Dia</option>
										<option value="2">Semana</option>
										<option value="3">Mês</option>
							</select>
						</td>
	                    <td>
	                    	<div class="invisivel-max-900" style="margin-bottom: 40px">
	                    		<img src="data:image/{{$menu->imagem_type}};base64, {{$menu->imagem}}" alt="Thumbnail do Menu" id="imagemMenu" name="imagemMenu" style="zoom: 50%;    border-radius: 100px 100px 100px 100px; border-color: black; border-width: 1px;position: absolute;right: 300px;">
	                    		<img src="/assets/img/banned.png" alt="Thumbnail do Menu" id="imagemMenuBanned" name="imagemMenu" class="banned" style="width: 50px;height: 50px;position: absolute;right: 150px; display:{{$menu->restrito == 1 ? 'true':'none'}}">
	                    	</div>
	                    </td>
	                    
	                  </tr>
	                @endforeach
	                </body>
</table>

@else
	<p>Não há itens de menu</p>
@endif
<script>
	$( "input.form-check-input" ).click(function() {
	  $(this).parent().parent().parent().find("img.banned").toggle(500, 'swing', function(){
	  	$(this).parent().parent().find("input.quantidade").prop("ERR_HTTP2_PUSH_DISABLED", (_, val) => !val);
	  });
	});

	$("input.quantidade").change(function(event) {
		if($(this).val() > 0){
			$(this).parent().parent().find("select.frequencia").prop('disabled', false);
		}
	});
</script>