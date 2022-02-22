@extends('layouts.master')

@section('title', 'Creditos')

@section('content')
	   <div class="row row-eq-height">
			<div class="col-sm-12">
	          <div class="grid simple ">
	            <div class="grid-title">
	            	<h4>Estatísticas</h4>
	            </div>
	            <div class="grid-body ">
	            		<div class="col-sm-4">
		            <div class="tiles green m-b-10" style="height: 203px">
		              <div class="tiles-body">
		                <div class="tiles-title text-black">TOTAL DE <span class="semi-bold">CRÉDITOS</span></div>
		                     <div class="widget-stats">
		                      <div class="wrapper transparent"> 
		                      	<script>
			                    	  var valor = getValorEmReal({{ $totalCreditoDinheiro }} );
								      document.write(
								      	"<span class='item-title'> Em dinheiro (R$)</span> <span class='item-count semi-bold'>"+valor+"</span>"
								      );
								</script>
		                      </div>
		                    </div>
		                    <div class="widget-stats">
		                      <div class="wrapper transparent">
		                     	 <script>
			                    	  var valor = getValorEmReal({{ $totalCreditoCartao }} );
								      document.write(
								      	"<span class='item-title'> Em cartões(R$)</span> <span class='item-count semi-bold'>"+valor+"</span>"
								      );
								</script>
		                      </div>
		                    </div>
		                    <div class="widget-stats">
		                      <div class="wrapper transparent">
		                      	<script>
			                    	  var valor = getValorEmReal({{ $totalCreditos }} );
								      document.write(
								      	"<span class='item-title'> Total(R$)</span> <span class='item-count  semi-bold'>"+valor+"</span>"
								      );
								</script>
		                      
		                      </div>
		                    </div>

							@if($totalCreditoCartao != 0 || $totalCreditoDinheiro !=0)
		                    <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
		                    <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="{{($totalCreditoDinheiro/($totalCreditoCartao+$totalCreditoDinheiro))*100}}%" ></div>
		                    
		                    </div>
		                    <div class="description"> <span class="text-white mini-description "><span class="semi-bold">{{($totalCreditoDinheiro/($totalCreditoCartao+$totalCreditoDinheiro))*100}}</span>% de créditos em dinheiro</span>
		                    </div>
		                    @endif
		                    
		              </div>            
		            </div>  
		            </div>
		            <div class="col-sm-4">
		            <div class="tiles purple m-b-10">
		              <div class="tiles-body">
		                <div class="tiles-title text-black">TOTAL DE <span class="semi-bold">CRÉDITOS</span></div>
		                    <div class="widget-stats">
		                      <div>
		                        <div class="chart-container">
								    <canvas id="chartBandeira"></canvas>
								</div>
		                      </div>
		                    </div>
		              </div>            
		            </div>  
		            </div>
		            <div class="col-sm-4">
		            <div class="tiles blue m-b-10" style="height: 203px">
		              <div class="tiles-body">
		                <div class="tiles-title text-black">TOTAL DE <span class="semi-bold">DÉBITOS</span> </div>
		                     <div class="widget-stats">
		                      <div class="wrapper transparent"> 
			                    <script>
			                    	  var valor = getValorEmReal({{ $totalDebitos }} );
								      document.write(
								      	"<span class='item-title'> Vendas (R$)</span> <span class='item-count  semi-bold' data-value='"+valor+"'>"+valor+"</span>"
								      );
								</script>
		                      </div>
		                    </div>
		                    <div class="widget-stats">
		                      <div class="wrapper transparent">
		                        <span class="item-title">Número de Transações</span> <span class="item-count animate-number semi-bold" data-value="{{$qtdDebitos}}" data-animation-duration="700">0</span> 
		                      </div>
		                    </div>
							@if($totalCreditos != 0)
		                    <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
		                      <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="{{($totalDebitos/$totalCreditos)*100}}%" ></div>
		                    </div>
		                    <div class="description"> <span class="text-white mini-description "><span class="semi-bold">{{($totalDebitos/$totalCreditos)*100}}%</span> de créditos consumidos</span></div>
		                    @endif
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
	              <h4>Moos <span class="semi-bold">Transações</span> do {{$evento->nome}}</h4>
	              <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
	            </div>
	            <div class="grid-body ">
	              <table class="table table-striped dataTable" id="example_wrapper">
	                <thead>
	                  <tr>
	                  	<th> </th>
	                    <th>Valor (R$)</th>
	                    <th class="invisivel-max-900">Terminal</th>
	                    <th>CPF</th>
	                    <th class="invisivel-max-900">Tipo</th>
						<th>Cartão</th>
						<th>Data</th>
						<th class="invisivel-max-900">Sinc em</th>
	                  </tr>
	                </thead>
	                <tbody>
	                @foreach($transacoes as $transacao)
	                  <tr class="odd gradeX">
	                  	@if($transacao->tipo_transacao == 'credito')
						   <td><i class="fa fa-plus-circle red ml-2"  style="color:blue"></i></td>
						@else
						    <td><i class="fa fa-minus-circle  ml-2"  style="color:red"></i></td>
						@endif
						@if($transacao->tipo_transacao == 'credito')
							<script>
		                    	  var valor = getValorEmReal({{ $transacao->valor }} );
							      document.write("<td style='padding-top: 20px;color:blue'>" + valor + "</td>");
							</script>
	                    @else
	                    	<script>
		                    	  var valor = getValorEmReal({{ $transacao->valor }} );
							      document.write("<td style='padding-top: 20px;color:red'>" + valor + "</td>");
							</script>
	                    @endif	
	                    <td class="invisivel-max-900"><a href="/evento/{{ $transacao->evento_id }}/terminal/{{ $transacao->terminal_id }}/transacoes">{{ $transacao->terminal->terminal_id }}</a></td>
	                    <td>{{ $transacao->cpf }}</td>
	                    <td class="invisivel-max-900">{{ $transacao->tipo_transacao }}</td>
	                    <td><a href="/cartao/{{ $transacao->cartao }}/transacoes">{{ $transacao->cartaoCredito->cartao_id }}</a></td>
	                    <td>
	                    {{ $transacao->data_transacao }}
	                    </td>
	                    	<script>
			                    	  var data = yyyymmddTempo('{{ $transacao->created_at }}');
								      document.write("<td class='invisivel-max-900'>"+data+"</td>");
							</script>
	                  </tr>
	                @endforeach
	                </tbody>
	              </table>
	              <div class="col-md-12" style="margin-top: 10px;">
		            
		             	{{$transacoes}} 	
					
		          </div>
	            </div>
	          </div>
	        </div>
	  </div>

@stop

@section('scripts')
<script>
	
	function detalheMenu(pedidos) {
		console.log(pedidos);
		$('#modalPedidos').modal('show');
	}	

	function detalheOnde(pedidos) {
		toastr.info( 'Vem aí onde você consumiu' , 'Aguarde!', {timeOut: 5000});
	}


	
	var bandeirasCartao = {!! $bandeirasCartao !!};
	var valoresGrafico = [];
	var legendaGrafico = [];

	for (var i = 0; i < bandeirasCartao.length; i++) {
		valoresGrafico.push(bandeirasCartao[i].total);
		legendaGrafico.push(bandeirasCartao[i].bandeira + '(R$ ' + bandeirasCartao[i].total + ')');
	}

	console.log(valoresGrafico);
	console.log(legendaGrafico);


	var ctx = document.getElementById("chartBandeira");
	var chartBandeira = new Chart(ctx, {
			    type: 'pie',
			    data: {
				    datasets: [{
				        data: valoresGrafico,
				        backgroundColor: [
				        'rgba(255, 235, 59, 0.9)',
				        'rgba(250, 250, 250, 0.9)',
				        'rgba(255, 152, 0, 0.8)',
				        'rgba(255, 87, 34, 0.8)',
		           		],
				    }], 

				    // These labels appear in the legend and in the tooltips when hovering different arcs
				    labels: legendaGrafico
				},
		    	options: {
			        legend: {
			            display: false,
			            position: 'right',
			            labels: {
			                fontColor: 'rgb(80, 84, 87)'
			            }
			        }
				}
	});	

	
</script>

@stop