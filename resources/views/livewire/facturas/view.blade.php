@section('title', __('Facturas'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: 
					space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
								Facturas </h4>
						</div>
						<div wire:poll.60s>
							{{-- <code><h5>{{ now()->format('H:i:s') }} UTC</h5></code> --}}
							<code><h5>Fecha de hoy: {{ now()->format('d-m-Y') }} </h5></code>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{
							session('message') }} </div>
						@endif

						{{-- <div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search"
								placeholder="Buscar Facturas">
						</div> --}}
						<div class="row">
							<div style="float:left;width: 75%;
										 inline: green solid thin; clear:both">
								<input wire:model='keyWord' type="text" class="form-control" name="search" id="search"
									placeholder="{{$filter}}" style="width: 100%;height: 5ch">
							</div>

							<div class="btn-group">
								<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false"
									style=" border-block-end-color: rgb(97, 129, 118);border-block-color: rgb(185, 193, 197)">
									<i style="color: rgb(144, 158, 168)" class="fa fa-filter"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-right">

									<!-- <a class="dropdown-item" wire:click="SearchByDate()"><i style="color: rgb(178, 191, 199)" class="far fa-calendar-alt"></i>  Filtrar por Fecha </a>							  -->
									<a class="dropdown-item" wire:click="SearchByNumFac()"><i
											style="color: rgb(178, 191, 199)" class="fas fa-money-bill-wave"></i>
										Filtrar por N° de Factura </a>
									<a class="dropdown-item" wire:click="SearchByDate()"><i
											style="color: rgb(178, 191, 199)" class="fas fa-project-diagram"></i>
										Filtrar por Fecha </a>
									<a class="dropdown-item" wire:click="SearchByProve()"><i
											style="color: rgb(178, 191, 199)" class="fas fa-hands-helping"></i> Filtrar
										por Proveedor </a>
								</div>
							</div>
						</div>

						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
							<i class="fa fa-plus"></i> Añadir Facturas
						</div>
					</div>
				</div>

				<div class="card-body">
					@include('livewire.facturas.create')
					@include('livewire.facturas.update')
					<div class="table-responsive">
						<table class="table table-bordered table-sm">
							<thead class="thead">
								<tr>
									{{-- <td>#</td> --}}
									<th>ID</th>
									<th>Número</th>
									<th>Monto</th>
									<th>Fecha</th>
									<th>Proveedor (ID)</th>
									<td>ACCIONES</td>
								</tr>
							</thead>
							<tbody>
								@foreach($facturas as $row)
								<tr>
									{{-- <td>{{ $loop->iteration }}</td> --}}
									<td>{{ $row->id }}</td>
									<td>{{ $row->num_fac }}</td>
									<td>$ {{ number_format($row->monto, 2) }}</td>
									{{-- <td>{{ $row->fecha_fac }}</td> --}}
									{{-- <td>{{ $row->proveedor_id }}</td> --}}
									<td>{{ date("d-m-Y", strtotime($row->fecha_fac)) }}</td>
									<td> {{ $row->proveedore->nombre_proveedor }}</td>

									<td width="90">
										<div class="btn-group">

											<button type="button" class="btn btn-info btn-sm dropdown-toggle"
												data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Acciones
											</button>

											<div class="dropdown-menu dropdown-menu-right">
												<a data-toggle="modal" data-target="#updateModal" class="dropdown-item"
													wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i> Modificar
												</a>
												@if($row->added > 0)
												<a class="dropdown-item" onclick="confirm('¿Confirma que desea eliminar la Factura Nº {{$row->num_fac}}? \n\nEsta factura está asociada a un quedan, al aceptar eliminar, se descontará el monto al quedan que está asociada.')
											        ||event.stopImmediatePropagation()" wire:click="hidenstate({{$row->id}})">
												
												@else
												<a class="dropdown-item" onclick="confirm('¿Confirma que desea eliminar la Factura Nº {{$row->num_fac}}?')
											        ||event.stopImmediatePropagation()" wire:click="hidenstate({{$row->id}})">

												@endif
												<i style="color: firebrick" class="fa fa-trash"></i> Eliminar
												</a>

											</div>
										</div>
									</td>
									@endforeach
							</tbody>
						</table>
						{{ $facturas->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>