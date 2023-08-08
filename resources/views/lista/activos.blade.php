@extends('includes.default')

@section('title', 'Activos')
@section('content')


<div class="app-wrapper">

	<div class="app-content pt-3 p-md-3 p-lg-4">
		<div class="container-xl">

			<div class="row g-3 mb-4 align-items-center justify-content-between">
				<div class="col-auto">
					<h1 class="app-page-title mb-0"></h1>
				</div>
				<div class="col-auto">
					<div class="page-utilities">
						<div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                            <div class="col-auto d-none">
                                <select class="form-select w-auto">
                                    <option selected="" value="option-1">All</option>
                                    <option value="option-2">This week</option>
                                    <option value="option-3">This month</option>
                                    <option value="option-4">Last 3 months</option>
                                    
                              </select>
                            </div>
							<div class="col-auto">
                                <a class="btn app-btn-secondary bg-success text-white" href="{{ route('activos')}}">
                                    <i class="fa fa-user" aria-hidden="true"></i>
									Activos 
								</a>
								</div>

                            <div class="col-auto">
                                <a class="btn app-btn-secondary border border-danger bg-danger text-white" href="{{ route('desistentes')}}">
									<i class="fa fa-user-times" aria-hidden="true"></i>
									Desistentes
								</a>

							</div>
							<!--//col-->


						</div>
						<!--//row-->
					</div>
					<!--//table-utilities-->
				</div>
				<!--//col-auto-->
			</div>
			<!--//row-->

			@if (isset($search))
				<nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
				<a class="flex-sm-fill nav-link active" id="orders-all-tab" data-bs-toggle="tab" role="tab" aria-controls="orders-all" aria-selected="true" style="text-align: left; cursor: normal; text-transform: uppercase;">Resultado</a>
			</nav>

			@else 
			<nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
				<a class="flex-sm-fill nav-link active" id="orders-all-tab" data-bs-toggle="tab" role="tab" aria-controls="orders-all" aria-selected="true" style="text-align: left; cursor: normal; text-transform: uppercase;">Lista de alunos activo</a>
			</nav>
			@endif
			

			@if (count($alunos) == 0 && isset($search))
			<div class="alert alert-danger" role="alert">
                Não foi encontrado  aluno : <b> {{$search}}</b>
              </div>
			
			  @elseif(count($alunos) == 0)
			  <div class="alert alert-danger" role="alert">
                Lista de vazia  
               </div>

			   @else 

			   <div class="tab-content" id="orders-table-tab-content">
				<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
					<div class="app-card app-card-orders-table shadow-sm mb-5">
						<div class="app-card-body">
							<div class="table-responsive" style="background-color: #fff;">
								
								<table class="table app-table-hover mb-0 text-left table-striped ">
									<thead>
										<tr>
                                            <th class="cell"></th>
											<th class="cell"></th>
											<th class="cell">Nome</th>
											<th class="cell">Classe</th>
											<th class="cell">Telefone</th>
											<th class="cell">Estado</th>
											<th class="cell">Data</th>
										</tr>
									</thead>
							<tbody>
								
							<tr>
                            @foreach ($alunos as $aluno)
								
							
                             <td class="cell"></td>
							
							 <td class="cell"></td>

							 @if ($aluno->imagem == null)
							 <td class="cell"><a href="{{ route('perfil-aluno', $aluno->slug)}}"><img src="{{ asset('imagem/avatar.png')}}" class="rounded-circle" alt="..." width="60"></a> </td>

							 @else 
							 
							 <td class="cell"><a href="{{ route('perfil-aluno', $aluno->slug)}}"><img src="{{ url("storage/{$aluno->imagem}")}}" class="rounded-circle" alt="..." width="60"></a> </td>

							 @endif
							 
							<td class="cell"><a href="{{ route('perfil-aluno', $aluno->slug)}}">{{$aluno->nome}}</a> </td>
							<td class="cell"><span class="truncate">{{$aluno->classe}} </span></td>
							<td class="cell">{{$aluno->telefone}}</td>

							@if ($aluno->estado == 'activo')
								<td class="cell"><span class="badge bg-success">activo</span></td>
							
								@else 

								<td class="cell"><span class="badge bg-danger">Desistente</span></td>

							@endif
							

							<td class="cell"><span>{{ date('d/m/Y', strtotime($aluno->created_at)) }} </span><span class="note">{{ date('H:i', strtotime($aluno->created_at)) }}</span></td>
							
							<td class="cell"><a class="text-warning " href="{{ route('propina', $aluno->slug)}}"><span class="badge bg-warning text-dark">propina</span></a></td>

							<td class="cell"><a class=" " href="{{ route('uniforme', $aluno->slug)}}"><span class="badge bg-info text-dark">uniforme</span></a></td>

							<td class="cell d-none"><a class=" " href="{{ route('propina', $aluno->slug)}}"><span class="badge bg-secondary text-dark">certificado</span></a></td>

							<td class="cell"><a href="{{ route('editar-aluno', $aluno->slug)}}"><i class="fa fa-edit fa-2x" aria-hidden="true"></i></a></td>

							<td class="cell"><a href="#modal?id={{$aluno->id}}" data-bs-toggle="modal" data-bs-target="#modal{{$aluno->id}}" class="text-danger"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></td>

						<!-- Modal -->
						<div class="modal fade" id="modal{{$aluno->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Desejas excluir <strong class="text-success"> {{$aluno->nome}}</strong> ?</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									
									<div class="modal-footer">
									<form action="{{ route('delete-aluno', $aluno->id)}}" method="post">
										@method('delete')
										@csrf
													
										<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>

										<button type="submit" class="btn btn-danger">Excluir</button>

									</form>
										
										
									</div>
								</div>
							</div>
						</div>
						
									</tr>
									@endforeach
									  

									</tbody>
								</table>
							</div>
							
							
							<!--//table-responsive-->

						</div>
						<!--//app-card-body-->
					</div>
					<!--//app-card-->

			</div>
			<!--//tab-content-->

			<div>
				{{$alunos->links()}}
				</div>
				

		</div>

			@endif


			
		<!--//container-fluid-->
	</div>
	<!--//app-content-->

@endsection