@section('title', __('Quedanfacturas'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h5><i class="fab fa-laravel text-info"></i>
							Asociación Quedan/Facturas </h5>
						</div>
						<div wire:poll.60s>
							{{-- <code><h5>• Fecha: {{ now()->format('d/m/Y') }} • Hora: {{ now()->isoFormat('H:mm:ss A') }}</h5></code> --}}
							<code><h5>Fecha: {{ now()->format('d/m/Y') }}</h5></code>

							{{-- <code><h5>{{ now()->format('H:i:s') }} UTC</h5></code> --}}
						</div>
							@if (session()->has('message1'))
								<div wire:poll.3s class="btn btn-danger" style="margin-top:0px; margin-bottom:0px;"> {{ session('message1') }} </div>
							@endif
							@if (session()->has('message2'))
								<div wire:poll.3s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message2') }} </div>
							@endif
						{{-- <div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Search Quedanfacturas">
						</div> --}}
						<div class="row" style="90%">
							<div style="float:left;width: 75%;
							inline: green solid thin; clear:both">
								<input wire:model='keyWord' type="text" class="form-control" name="search" id="search"
									placeholder="{{$filter}}" style="width: 100%;height: 5ch">
							</div>

							<div class="btn-group">
								<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" 
								          aria-haspopup="true" aria-expanded="false" style=" border-block-end-color: rgb(97, 129, 118);border-block-color: rgb(185, 193, 197)">
									<i style="color: rgb(144, 158, 168)" class="fa fa-filter"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-right">
								{{-- <a  class="dropdown-item" href="{{url('quedans/pdf')}}"><i class="fa fa-print"></i> Imprimir </a>							  --}}
								<a class="dropdown-item" wire:click="SearchByDateQd()"><i style="color: rgb(178, 191, 199)" class="far fa-calendar-alt"></i>  Filtrar por Fecha de Quedan </a>							 
								<a class="dropdown-item" wire:click="SearchByDateFc()"><i style="color: rgb(178, 191, 199)" class="far fa-calendar-alt"></i>  Filtrar por Fecha de Factura </a>							 
								<a class="dropdown-item" wire:click="SearchByFuent()"><i style="color: rgb(178, 191, 199)" class="fas fa-money-bill-wave"></i> Filtrar por Fuente de Financiamiento </a>							 
								<a class="dropdown-item" wire:click="SearchByNumF()"><i style="color: rgb(178, 191, 199)" class="fas fa-file-invoice-dollar"></i> Filtrar por Número de Factura </a>							 
								<a class="dropdown-item" wire:click="SearchByProve()"><i style="color: rgb(178, 191, 199)" class="fas fa-hands-helping"></i> Filtrar por Proveedor  </a>   
								</div>
							</div>
						</div>
						<div class="btn btn-outline-primary" data-toggle="modal" data-target="#createDataModal">
						<i class="fa fa-plus"></i>  Asociar
						</div>
					</div>
				</div>
				
				<div class="card-body">
						@include('livewire.quedanfacturas.create')
						@include('livewire.quedanfacturas.update')
				<div class="table-responsive">
					<table class="table table-bordered table-sm">
						<thead class="thead">
							<tr> 
								{{-- <td>#</td>  --}}
								<th style="width: 4%; color: rgb(174, 174, 174)">#</th>
								{{-- <th style="width: 4%; color: darkolivegreen">ID Quedan</th> --}}
								<th style="width: 5%">Nums Quedan</th>
								<th style="width: 11%">Fechas (Qd) Emisión</th>
								<th style="width: 12%">Montos Quedan</th>
								{{-- <th style="width: 35%">Cantidad Letra</th> --}}
								<th style="width: 15%">Fuentes Financiamiento</th>
								{{-- <th>Proyecto</th> --}}
								{{-- <th style="color: rgb(64, 98, 99)">ID fact</th> --}}
								<th style="width: 5%">Nums Factura</th>
								<th>Fechas (Fac) Emisión</th>
								<th>Montos Factura</th>
								<th>Proveedores</th>
								<td>ACCIONES</td>
							</tr>
						</thead>
						<tbody>
							@foreach($quedanfacturas as $row)
							<tr>
								{{-- <td>{{ $loop->iteration }}</td>  --}}
								<td style="color: rgb(174, 174, 174)">{{ $row->id }}</td>
								{{-- <td style="color: darkolivegreen">{{ $row->my_quedanId }}</td> --}}
								<td>{{ $row->num_quedan }}</td>
								{{-- <td>{{ $row->fecha_emi }}</td> --}}
								{{-- <td>{{ date('d-m-Y',$row->fecha_emi) }}</td> --}}
								{{-- <td>{{  strtotime($row->fecha_emi) }}</td> --}}
								<td>{{ date("d-m-Y", strtotime($row->fecha_emi)) }}</td>
								<td>$ {{ $row->cant_num }}</td>
								 {{-- <td>{{ $row->cant_letra }}</td> --}}
								{{-- <td>{{ $row->factura_id }}</td>
								<td>{{ $row->fuente_id }}</td>
								<td>{{ $row->filter_search }}</td> --}}
								{{-- <td>{{$row->fuente_id}} - {{ $row->fuente->nombre_fuente }}</td>
								<td>{{$row->filter_search}} - {{ $row->proyecto->nombre_proyecto }}</td> --}}
								{{-- <td>{{ $row->fuente->nombre_fuente }}</td> --}}
								<td>{{ $row->nombre_fuente }}</td>
								{{-- <td>{{ $row->proyecto->nombre_proyecto }}</td> --}}
								{{-- <td style="color: rgb(64, 98, 99)">{{ $row->my_factId }}</td> --}}
								<td>{{ $row->num_fac }}</td>
								<td>{{ date("d-m-Y", strtotime($row->fecha_fac)) }}</td>
								<td>$ {{ $row->monto }}</td>
								<td>{{ $row->nombre_proveedor }}</td>
								<td width="90">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Acciones
									</button>
									<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="{{action('App\Http\Controllers\PdfController@index', [$row->my_quedanId, $row->cant_num])}}"><i style="color: rgb(99, 203, 153)" class="fa fa-print"></i> Imprimir </a>							 
									{{-- //! respecto a editar quedanfactura, ¡funciona! El único inconveniente es que, no hay forma (lógica) de actualizar la cantidad numérica en quedan (tabla) propiamente, al compás del edit--}}
									{{-- //! se puede editar quedanfactura al descomentar la linea de abajo, pero cuando se edite, la cantidad numérica de quedan (tabla), quedará ilógica, porque no se modificará, no hay método para eso. Lo cual sería un error grave --}}
									{{-- <a data-toggle="modal" data-target="#updateModal" class="dropdown-item" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i> Modificar </a>							  --}}
									<a class="dropdown-item" onclick="confirm('Confirmar Eliminación Quedanfactura id {{$row->id}}? \nSeguro que quieres eliminarlo!')||event.stopImmediatePropagation()" wire:click= "hidenstate({{$row->id}},{{$row->my_quedanId}},{{$row->my_factId}})"><i style="color: firebrick" class="fa fa-trash"></i> Eliminar </a>   
									{{-- <a class="dropdown-item" onclick="confirm('Confirm Delete Quedanfactura id {{$row->id}}? \nDeleted Quedanfacturas cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i> Eliminar </a>    --}}
									</div>
								</div>
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $quedanfacturas->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
