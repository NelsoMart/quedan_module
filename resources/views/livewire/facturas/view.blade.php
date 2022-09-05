@section('title', __('Facturas'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Facturas </h4>
						</div>
						<div wire:poll.60s>
							{{-- <code><h5>{{ now()->format('H:i:s') }} UTC</h5></code> --}}
							<code><h5>Fecha de hoy: {{ now()->format('d-m-Y') }} </h5></code>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Facturas">
						</div>
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
						<i class="fa fa-plus"></i>  Añadir Facturas
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
								{{-- <td>#</td>  --}}
								<th>ID</th>
								<th>Fecha</th>
								<th>Número</th>
								<th>Monto</th>
								<th>Proveedor (ID)</th>
								<td>ACCIONES</td>
							</tr>
						</thead>
						<tbody>
							@foreach($facturas as $row)
							<tr>
								{{-- <td>{{ $loop->iteration }}</td>  --}}
								<td>{{ $row->id }}</td>
								{{-- <td>{{ $row->fecha_fac }}</td> --}}
								<td>{{ date("d-m-Y", strtotime($row->fecha_fac)) }}</td>
								<td>{{ $row->num_fac }}</td>
								<td>$ {{ number_format($row->monto, 2) }}</td>
								{{-- <td>{{ $row->proveedor_id }}</td> --}}
								<td>{{$row->proveedor_id}} - {{ $row->proveedore->nombre_proveedor }}</td>

								<td width="90">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Acciones
									</button>
									<div class="dropdown-menu dropdown-menu-right">
									<a data-toggle="modal" data-target="#updateModal" class="dropdown-item" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i> Editar </a>							 
									<a class="dropdown-item" onclick="confirm('Confirm Delete Factura id {{$row->id}}? \nDeleted Facturas cannot be recovered!')||event.stopImmediatePropagation()" wire:click="hidenstate({{$row->id}})"><i style="color: firebrick" class="fa fa-trash"></i> Eliminar </a>   
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
