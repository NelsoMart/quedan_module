@section('title', __('Proveedores'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Proveedores </h4>
						</div>
						<div wire:poll.60s>
							{{-- <code><h5>{{ now()->format('H:i:s') }} UTC</h5></code> --}}
							<code><h5>Fecha de hoy: {{ now()->format('d-m-Y') }} </h5></code>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Proveedores">
						</div>
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
						<i class="fa fa-plus"></i>  Añadir Proveedor
						</div>
					</div>
				</div>
				
				<div class="card-body">
						@include('livewire.proveedores.create')
						@include('livewire.proveedores.update')
				<div class="table-responsive">
					<table class="table table-bordered table-sm">
						<thead class="thead">
							<tr> 
								{{-- <td>#</td>  --}}
								<th>ID</th>
								<th>Nombre Proveedor</th>
								<td>ACCIONES</td>
							</tr>
						</thead>
						<tbody>
							@foreach($proveedores as $row)
							<tr>
								{{-- <td>{{ $loop->iteration }}</td>  --}}
								<td>{{ $row->id }}</td>
								<td>{{ $row->nombre_proveedor }}</td>
								<td width="90">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Acciones
									</button>
									<div class="dropdown-menu dropdown-menu-right">
									<a data-toggle="modal" data-target="#updateModal" class="dropdown-item" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i> Modificar </a>							 
									
									{{-- <a class="dropdown-item" onclick="confirm('¿Confirma que quiere eliminar el proveredor con id {{$row->id}}? \n¡Eliminar este proveedor hará que se eliminen tabién los quedan y facturas relacionados con él!')||event.stopImmediatePropagation()" wire:click="hidenstate({{$row->id}})"><i class="fa fa-trash"></i> Eliminar </a>    --}}
									
									<a class="dropdown-item" 
									onclick="confirm('¿Confirma que desea eliminar el proveedor {{$row->nombre_proveedor}}?')
									   ||event.stopImmediatePropagation()" 
									   wire:click="hidenstate({{$row->id}})"
									   >
									   <i class="fa fa-trash"></i> Eliminar </a> 
									   
									   {{-- <a class="dropdown-item" wire:click="$emit('triggerDelete',{{ $row->id }})">
										<i class="fa fa-trash"></i> Eliminar </a>  --}}

									   {{-- <a class="dropdown-item" wire:click="hidingfact({{$row->id}})">
										<i class="fa fa-trash"></i> Eliminar </a>  --}}

									{{-- <a class="dropdown-item" onclick="confirm('Se ha eliminado el proveredor con id {{$row->id}}? \n¿Desea eliminar las facturas que no están asociadas a ningún quedan?')||event.stopImmediatePropagation()" wire:click="hidingfact({{$row->id}})"><i class="fa fa-trash"></i> Eliminar </a>    --}}
									</div>
								</div>
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $proveedores->links() }}
					</div>


				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {

        @this.on('triggerDelete', orderId => {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'Order record will be deleted!',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: 'var(--success)',
                cancelButtonColor: 'var(--primary)',
                confirmButtonText: 'Delete!'
            }).then((result) => {
		//if user clicks on delete
                if (result.value) {
		     // calling destroy method to delete
                    @this.call('destroy',orderId)
		    // success response
                    responseAlert({title: session('message'), type: 'success'});
                    
                } else {
                    responseAlert({
                        title: 'Operation Cancelled!',
                        type: 'success'
                    });
                }
            });
        });
    })
</script>
@endpush

<script>
	Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something went wrong!',
  footer: '<a href="">Why do I have this issue?</a>'
})
</script>