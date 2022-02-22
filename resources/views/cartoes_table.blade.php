<div class="row" >
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
	                    <th class="invisivel-max-900">Nome</th>
	                    <th class="invisivel-max-900">CPF</th>
	                    <th class="invisivel-max-900">Evento</th>
	                  	<th class="invisivel-max-900">Email</th>
	                  	<th class="invisivel-max-900">Criado em</th>
	                  	<th class="invisivel-max-900">Situação</th>
	                  	<th>Ações</th>
	                  </tr>
	                </thead>
	                <body>
	                @foreach($cartoes as $cartao)
	                  <tr class="odd gradeX" id="{{ $cartao->id }}{{ $cartao->nome }}">
	                    <td class="invisivel-max-900">{{ $cartao->id }}</td>
	                    <td>{{ $cartao->cartao_id }}</td>
	                    <td class="invisivel-max-900">{{ $cartao->user->nome }}</td>
	                    <td class="invisivel-max-900">{{ $cartao->user->cpf }}</td>
	                    <td class="invisivel-max-900">{{ $cartao->evento_id }}</td>
	                    <td class="invisivel-max-900">{{ $cartao->user->email }}</td>
	                    <td class="invisivel-max-900">{{ $cartao->timestamp }}</td>
	                    <td class="invisivel-max-900">{{ $cartao->ativo == 1 ? 'Ativo':'Inativo' }}</td>
	                    <td>
	                    <div class="btn-group" data-toggle="buttons-radio">
		                    <button class="btn btn-default " data-original-title="Transações" onClick="window.open('/cartao/{{ $cartao->id }}/transacoes');"><i class="fa fa-credit-card"></i></button>
		                    @if($cartao->ativo == 0)
		                    <button class="btn btn-danger disabled "  data-original-title="Cartão Inativo" title="Cartão Inativo"><i class="fa fa-minus-circle"></i></button>
		                    @elseif($cartao->bloqueado == 0)  
		                    <button class="btn btn-default " data-original-title="Transações" onclick="javascript:deletaCartao('{{ $cartao->id }}', this);"><i class="fa fa-power-off"></i></button>
		                    <button class="btn btn-primary "  data-original-title="Bloquear o cartão" onclick="javascript:bloqueiaCartao('{{ $cartao->id }}', this);"><i class="fa fa-unlock"></i></button>
		                    @if(Auth::user()->isAdministrator() == 1)  
			                @endif
		                    @else
		                    <button class="btn btn-default " data-original-title="Transações" onclick="javascript:deletaCartao('{{ $cartao->id }}', this);"><i class="fa fa-power-off"></i></button>
		                    <button class="btn btn-danger "  data-original-title="Desbloquear o cartão" onclick="javascript:bloqueiaCartao('{{ $cartao->id }}', this);"><i class="fa fa-lock"></i></button>
		                    							@if(Auth::user()->isAdministrator() == 1)  
			                @endif
		                    @endif
		                </div>
	                  </tr>
	                @endforeach
	                </body>
	              </table>

	            <div class="col-md-12" style="margin-top: 10px;">
	            	{{$cartoes}} 	
	            </div>

	            

	            </div>
	          </div>
	        </div>

	  </div>