@extends('layouts.master')

@section('title', 'Extrato do Cartão')

@section('content')
	   <!-- Modal INICIO -->
	<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		   	<div class="modal-content">
		  	  <div id="map" style="height: 100%;"></div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
		      </div>
		    </div>
		    <!-- Modal content-->
		  </div>
	</div>

<!-- Modal FIM -->
       <div class="row" >
	        <div class="col-sm-12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4> Cartão ({{$cartao->cartao_id}}) do <span class="bold">{{$cartao->user->nome}}</span></h4>
	              <div class="tools"> <a href="javascript:;" class="collapse"></a></div>
	            </div>
	            <div class="grid-body ">
	            		<div class="row">
	   			<div class="col-sm-4">
		            <div class="tiles white m-b-10">
		              <div class="tiles-body">
		              <div class="controller">  </div>
		                <div class="title"><h2>Saldo <span style="color:green">R$ </span> 
		                <span style="color:green">
		                	<script>
			                    	  var creditos = {{$totalCreditos}};
			                    	  var debitos = {{$totalDebitos}};
			                    	  var total = parseFloat(creditos-debitos).toFixed(2);
			                    	  document.write(
								      	total.toString().replace(".", ",")
								      );
							</script>
		                </span></h2></div>

		                     <div class="widget-stats">
		                      <div class="wrapper transparent"> 
		                        <span class="item-title">Créditos (R$)</span> <span style="color:blue" class="item-count animate-number semi-bold" data-value="{{$totalCreditos}}" data-animation-duration="700" data-mask="#.###,00" data-mask-reverse="true">0</span>
		                      </div>
		                    </div>
		                    <div class="widget-stats">
		                      <div class="wrapper transparent">
		                        <span class="item-title">Compras (R$)</span> <span class="item-count animate-number semi-bold" data-value="{{$totalDebitos}}" data-animation-duration="700" style="color:red" >0</span> 
		                      </div>
		                    </div>
		                    <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
		                    @if($totalCreditos != 0)
		                      <div class="progress-bar progress-bar-info animate-progress-bar" data-percentage="{{($totalDebitos/$totalCreditos)*100}}%" ></div>
		                    @endif
		                    </div>
		                    <div class="description"> <span class="text-black mini-description "><span class="semi-bold">
		                    @if($totalCreditos != 0)
		                    	{{($totalDebitos/$totalCreditos)*100}}
		                    @else
		                    	0
		                    @endif
		                    </span>% Consumido</span></div>
		              </div>            
		            </div>  
		        </div>
	   			<div class="col-sm-4">
		            <div class="tiles white m-b-10">
		              <div class="tiles-body">
		              <div class="controller"> 
		              	
		              </div>
		              	<div class="title">
		               		 Gasto por produto
		                </div>
		                <div>
		                	<div>
		                		<div class="chart-container">
								    <canvas id="myChart"></canvas>
								</div>
		                	</div>
		                </div>
		            	</div>  
		        	</div>
	   			</div>
	   			<div class="col-sm-4">
		            <div class="tiles white m-b-10">
		              <div class="tiles-body">
		              <div class="controller"> 
		              	
		              </div>
		               <div class="title">
		               		 Gasto por festa
		               </div>
		                <div class="title">
		                	<div>
		                		<div class="chart-container">
								    <canvas id="myChartPorFesta"></canvas>
								</div>
		                	</div>
		                </div>
		            	</div>  
		        	</div>
	   			</div>
	   </div>



	            </div>
	          </div>
	        </div>
	    </div>


	   		
       <div class="row" >
	        <div class="col-sm-12">
	          <div class="grid simple ">
	            <div class="grid-title">
	              <h4>Moos <span class="semi-bold">Extrato</span></h4>
	              <div class="tools"> <a href="javascript:;" class="collapse"></a></div>
	            </div>
	            <div class="grid-body ">
	              <table class="table table-hover no-more-tables" id="example_wrapper">
	                <thead>
	                  <tr>
	                  	<th class="invisivel-max-415"> </th>
	                    <th class="invisivel-max-900">Tipo da Transação</th>
						<th>Valor (R$)</th>
						<th></th>
						<th>Data</th>
						<th class="invisivel-max-900">Terminal</th>
						<th>Açoes</th>
	                  </tr>
	                </thead>
	                <tbody>
	                @foreach($transacoes as $transacao)
	                  <tr class="odd gradeX"
	                  @if($transacao->transacaoEquivalente!=null && $transacao->transacaoEquivalente->transacao == 'estorno' && $transacao->transacao != 'estorno')
	                  		style="text-decoration:line-through;"
	                  @endif

	                  >
	                  	@if($transacao->tipo_transacao == 'credito')
						   <td  class="invisivel-max-415"><i class="fa fa-plus-circle red ml-2" title="Crédito" style="color:blue"></i></td>
						@else
						    <td  class="invisivel-max-415"><i class="fa fa-minus-circle  ml-2" title="Débito" style="color:red"></i></td>
						@endif
	                    <td class="invisivel-max-900">{{ $transacao->tipo_transacao }}</td>
	                    @if($transacao->tipo_transacao == 'credito')
	                    	<script>
			                    	  var valor = getValorEmReal({{ $transacao->valor }} );
								      document.write(
								      	"<td style='color:blue'>"+valor+"</td>"
								      );
							</script>
	                    @else
	                    	<script>
			                    	  var valor = getValorEmReal({{ $transacao->valor }});
								      document.write(
								      	"<td style='color:red'>"+valor+"</td>"
								      );
							</script>
	                    @endif	
	                    <td>
	                    	@if($transacao->transacao == 'transferencia')
	                    		Transferência (
	                    		<a href="/cartao/{{$transacao->transacaoEquivalente->cartaoCredito->id}}/transacoes">
	                    		{{$transacao->transacaoEquivalente->cartaoCredito->cartao_id}}
	                    		</a>
	                    		)
	                    	@elseif($transacao->transacao == 'estorno')
	                    		Estorno (
	                    		<a href="/cartao/{{$transacao->transacaoEquivalente->cartaoCredito->id}}/transacoes">
	                    		{{$transacao->transacaoEquivalente->cartaoCredito->cartao_id}}
	                    		</a>
	                    		)

	                    	@else
		                    	{{$transacao->transacao}} {{$transacao->bandeira}}
		                    	@foreach($transacao->pedidos as $pedido)
		                    		 {{$pedido->menu->nome}} ({{$pedido->quantidade}}) <br>
		                    	@endforeach
		                    @endif
	                    </td>
	                    	<script>
			                    	  var data = yyyymmddTempo('{{ $transacao->created_at }}');
								      document.write("<td>"+data+"</td>");
							</script>
	                    <td class="invisivel-max-900">
	                    @if($transacao->terminal!=null)
	                    	{{ $transacao->terminal->terminal_id }}
	                    @endif
	                    </td>
	                    <td>
	                    	@if($transacao->transacao != 'transferencia' && $transacao->transacao != 'estorno')
	                    		<button class="btn btn-default " title="Adicionar imagem" data-original-title="Onde foi feito o crédito ou o consumo?" title="Onde foi feito o crédito ou o consumo?" onclick="javascript:detalheOnde('{{ $transacao }}');"><i class="fa fa-globe "></i></button>
							@endif
							@if(Auth::user()->isAdministrator() == 1 && $transacao->cartaoCredito->ativo && $transacao->transacao != 'estorno')
								@if($transacao->transacaoEquivalente == null || $transacao->transacaoEquivalente->transacao !='estorno') 
								<button class="btn btn-default " title="Estornar transação" 
								onclick="

			                    bootbox.confirm({
								    message: 'Deseja realmente estornar essa transação? Esta ação não pode ser cancelada',
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
								        	estornar('{{ $transacao->id }}', this); 
								        }
								    }
								});"
								><i class="fa fa-ban"></i></button>
								@endif
							@endif
	                    </td>
	                  </tr>
	                  <!-- Modal INICIO -->
						<div id="modalPedidos" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <!-- Modal content-->
							   	<div class="modal-content">
							  	 {{csrf_field()}}
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title"><span class="semi-bold">O que </span>consumi?</h4>
							      </div>
							      <div class="modal-body">
							      	
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
							      </div>
							    </div>
							    <!-- Modal content-->
							  </div>
							</div>
					<!-- Modal FIM -->
	                @endforeach
	                </tbody>
	              </table>
	            </div>
	          </div>
	        </div>
	  </div>
@stop

@section('scripts')
<script>
      $(document).ready(function() {  
          $('#map').height($('.page-container').height()/1.3);
          $( window ).resize(function() {
             $('#map').height($('.page-container').height()/1.3);
          });  
      });

      function initMap(pedido) {
 		if (typeof pedido != 'undefined'){
 			var obj = JSON.parse(pedido);
 			var myLatLng = {lat: parseFloat(obj.latitude), lng: parseFloat(obj.longitude)};
	        var map = new google.maps.Map(document.getElementById('map'), {
	          zoom: 18,
	          center: myLatLng
	        });

          	var image = '/assets/img/pointer_beer.png';
          	var texto = 'Venda de R$ ' + obj.valor;
          	if(obj.tipo_transacao == 'credito'){
          		image = '/assets/img/pointer_credito.png';
          		texto = 'Credito de R$ ' + obj.valor;
          	}
          	new google.maps.Marker({
           	   position: myLatLng,
           	   map: map,
           	   title: texto,
           	   icon: image
          	});
        }

      }

	
	function detalheMenu(pedidos) {
		console.log(pedidos);
		$('#modalPedidos').modal('show');
	}	

	function detalheOnde(pedido) {
		$('#myModal').modal('show');
		initMap(pedido);
	}

	function estornar(id, el){
		$.ajax({
			   url: '/api/transacao/'+id+'/estorno/',
			   type: 'PUT',
			   success: function(response) {
			     	toastr.success('Estornado com sucesso.', 'Transação', {timeOut: 5000});
			     	setTimeout(function(){
	                         location.reload();
	                }, 5000);     
			   },
			   error   : function (data) 
	           {
		           toastr.error(data, 'Erro ao estornar a transação ', {timeOut: 5000});
	           }
		});
	}


	
	var arrayPedido = {!! $pedidosEstatistica !!};
	var valoresGrafico = [];
	var legendaGrafico = [];

	for (var i = 0; i < arrayPedido.length; i++) {
		valoresGrafico.push(arrayPedido[i].total);
		legendaGrafico.push(arrayPedido[i].nome + '(' + arrayPedido[i].quantidade + ')');
	}



	var ctx = document.getElementById("myChart");
	var myChart = new Chart(ctx, {
			    type: 'pie',
			    data: {
				    datasets: [{
				        data: valoresGrafico,
				        backgroundColor: [
				        'rgba(75, 192, 192, 0.3)',
				        'rgba(153, 102, 255, 0.3)',
						'rgba(255, 206, 86, 0.3)',
		                'rgba(255, 99, 132, 0.3)',
		                'rgba(54, 162, 235, 0.3)',                
		                'rgba(255, 159, 64, 0.3)'
		           		],
				    }], 

				    // These labels appear in the legend and in the tooltips when hovering different arcs
				    labels: legendaGrafico
				},
		    	options: {
			        legend: {
			            display: true,
			            position: 'right',
			            labels: {
			                fontColor: 'rgb(80, 84, 87)'
			            }
			        }
				}
	});	

	var arrayPedidoPorFesta = {!! $debitosPorEventoEstatistica !!};
	var valoresGraficoPorFesta = [];
	var legendaGraficoPorFesta = [];

	for (var i = 0; i < arrayPedidoPorFesta.length; i++) {
		valoresGraficoPorFesta.push(arrayPedidoPorFesta[i].total);
		legendaGraficoPorFesta.push(arrayPedidoPorFesta[i].nome);
	}



	var ctxPorFesta = document.getElementById("myChartPorFesta");
	var myChartPorFesta = new Chart(ctxPorFesta, {
			    type: 'doughnut',
			    data: {
				    datasets: [{
				        data: valoresGraficoPorFesta,
				        backgroundColor: [
				        'rgba(255, 99, 132, 0.3)',
		                'rgba(54, 162, 235, 0.3)',   
				        'rgba(75, 192, 192, 0.3)',
				        'rgba(153, 102, 255, 0.3)',
						'rgba(255, 206, 86, 0.3)',              
		                'rgba(255, 159, 64, 0.3)'
		           		],
				    }], 

				    // These labels appear in the legend and in the tooltips when hovering different arcs
				    labels: legendaGraficoPorFesta
				},
		    	options: {
			        legend: {
			            display: true,
			            position: 'right',
			            labels: {
			                fontColor: 'rgb(80, 84, 87)'
			            }
			        }
				}
	});	


	
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlCOo8peujVBQFKdveEAQ8-VJOookq4T8&libraries=places&callback=initMap&sensor=false" async defer>
</script>

<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
@stop