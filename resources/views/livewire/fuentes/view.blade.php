@section('title', __('Fuentes'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Fuente </h4>
						</div>
						<div wire:poll.60s>
							{{-- <code><h5>{{ now()->format('H:i:s') }} UTC</h5></code> --}}
							<code><h5>Fecha de hoy: {{ now()->format('d-m-Y') }} </h5></code>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Fuentes">
						</div>
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
						<i class="fa fa-plus"></i>  Añadir Fuentes
						</div>
					</div>
				</div>
				
				<div class="card-body">
						@include('livewire.fuentes.create')
						@include('livewire.fuentes.update')
				<div class="table-responsive">
					<table class="table table-bordered table-sm">
						<thead class="thead">
							<tr> 
								{{-- <td>#</td>  --}}
								<th>ID</th>
								<th>Nombre Fuente</th>
								<td>ACCIONES</td>
							</tr>
						</thead>
						<tbody>
							@foreach($fuentes as $row)
							<tr>
								{{-- <td>{{ $loop->iteration }}</td>  --}}
								<td>{{ $row->id }}</td>
								<td>{{ $row->nombre_fuente }}</td>
								<td width="90">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Acciones
									</button>
									<div class="dropdown-menu dropdown-menu-right">
									<a data-toggle="modal" data-target="#updateModal" class="dropdown-item" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i> Editar </a>							 
									{{-- <a class="dropdown-item" onclick="confirm('Confirm Delete Fuente id {{$row->id}}? \nDeleted Fuentes cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i> Eliminar </a>    --}}
									<a class="dropdown-item" onclick="confirm('¿Confirma que quiere eliminar la fuente con id {{$row->id}}? \n¡Eliminar esta fuente hará que se eliminen tabién los quedan y facturas relacionados con ella!')||event.stopImmediatePropagation()" wire:click="hidenstate({{$row->id}})"><i class="fa fa-trash"></i> Eliminar </a>   
									</div>
								</div>
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $fuentes->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
