@extends('layouts.master')

@section('title', 'Eventos Usuários')


@section('content')

<div class="row" >
		<div class="row-fluid">
	        <div class="span12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4>Moos <span class="semi-bold">Eventos</span> Funcionários</h4>
	              <div class="tools">
	              <a href="javascript:;" class="collapse"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
	            </div>

	            <div class="grid-body ">
	              <div>
	              	<form>		
	              				<label class="form-label">Nomes</label>
								<select class="js-example-basic-multiple" style="width: 100%" name="usuarios[]" multiple="multiple">
								@foreach($usuarios as $usuario)
								  <option 
								  @if (in_array($usuario->id, $funcionarios))
								  	selected="selected"
								  @endif
								  value="{{$usuario->id}}">{{$usuario->nome}}</option>
								@endforeach
								</select>
					</form>
	              </div>

	            </div>
	          </div>
	        </div>
      	</div>
	  </div>
@endsection

@section('scripts')

<script>


$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
    	 width: 'resolve' 
    });
    $("select").on("change", function(){
    	var form = $(this).parent().serialize();
	    var usuarios = $(this).val();

	    var url = "/api/evento/{{$evento_id}}/usuarios";
	    console.log(usuarios);
	    console.log(url);
	    $.ajax({
	            type: "POST",
	            url: url,
	            data: form,
	            success: function(response) {
				     	toastr.success('Funcionário associado ao evento ' +response + ' com sucesso.', 'Usuário', {timeOut: 9000});
				},
			    error: function(request,msg,error) {
			       toastr.error(error, 'Erro ', {timeOut: 5000});
			    }
	    });
	});
    
});

</script>

<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
@stop