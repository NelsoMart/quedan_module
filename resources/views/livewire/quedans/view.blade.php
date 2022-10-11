@section('title', __('Quedans'))

<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4>
								<i class="fab fa-laravel text-info"></i>
								Quedan
							</h4>
						</div>
						<div wire:poll.60s>
							<code><h5>Fecha de hoy: {{ now()->format('d-m-Y') }} </h5></code>
						</div>
						@if (session()->has('message'))
							<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						@if (session()->has('message3'))
							<div wire:poll.3s class="btn btn-danger" style="margin-top:0px; margin-bottom:0px;"> {{ session('message3') }} </div>
						@endif
						@if (session()->has('message4'))
							<div wire:poll.3s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message4') }} </div>
						@endif
						<div class="row" style="90%">
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
								{{-- <a  class="dropdown-item" href="{{url('quedans/pdf')}}"><i class="fa fa-print"></i> Imprimir </a>  --}} 
								<a class="dropdown-item" wire:click="SearchByQuedan()"><i style="color: rgb(178, 191, 199)" class="fas fa-list-ol"></i>  Filtrar por Número de Quedan </a>
								<a class="dropdown-item" wire:click="SearchByCantidad()"><i style="color: rgb(178, 191, 199)" class="fas fa-dollar-sign"></i>  Filtrar por Cantidad (sin coma) </a>
								<a class="dropdown-item" wire:click="SearchByDate()"><i style="color: rgb(178, 191, 199)" class="far fa-calendar-alt"></i>  Filtrar por Fecha (año/mes/día)</a>							 
								<a class="dropdown-item" wire:click="SearchByFuent()"><i style="color: rgb(178, 191, 199)" class="fas fa-money-bill-wave"></i> Filtrar por Fuente de Financiamiento </a>							 
								<a  class="dropdown-item" wire:click="SearchByProject()"><i style="color: rgb(178, 191, 199)" class="fas fa-project-diagram"></i> Filtrar por Proyecto </a>							 
								<a class="dropdown-item" wire:click="SearchByProve()"><i style="color: rgb(178, 191, 199)" class="fas fa-hands-helping"></i> Filtrar por Proveedor  </a>   
								</div>
							</div>
						</div>
						
						{{-- <div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
						<i class="fa fa-plus"></i>  Agregar Quedan
						</div> --}}

						<div>
							<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
							<i class="fa fa-plus"></i>    Añadir Quedan
							</div>
							
							{{-- <a href="{{url('quedans/pdf')}}" class="btn btn-sm btn-danger"> --}}
							{{-- <a href="{{ route('print_quedan') }}" class="btn btn-sm btn-danger"> --}}
							     {{-- <a href="{{action('App\Http\Controllers\PdfController@index')}}" class="btn btn-sm btn-danger"> --}}
							 {{-- <i class="fa fa-print"></i>  Imprimir
							</a> --}}
						</div>
						
					</div>
				</div>
				
				<div class="card-body">
						@include('livewire.quedans.create')
						@include('livewire.quedans.update')
						@include('livewire.quedans.associate')
						{{-- @include('livewire.quedans.pdf') --}}
				<div class="table-responsive">
					<table class="table table-bordered table-sm">
						<thead class="thead">
							<tr> 
								{{-- <td>#</td>  --}}
								{{-- <th style="width: 4%">ID</th> --}}
								<th style="width: 10%">Nums Quedan</th>
								<th style="width: 15%">Fechas Emis</th>
								<th style="width: 9%">Cantidades</th>
								{{-- <th style="width: 35%">Cantidad Letra</th> --}}
								<th style="width: 20%">Fuentes</th>
								<th>Proyectos</th>
								<th>Proveedores</th>
								<td>ACCIONES</td>
							</tr>
						</thead>
						<tbody>
							@foreach($quedans as $row)
							<tr>
								{{-- <td>{{ $loop->iteration }}</td>  --}}
								{{-- <td>{{ $row->id }}</td> --}}
								<td>{{ $row->num_quedan }}</td>
								{{-- <td>{{ $row->fecha_emi }}</td> --}}
								{{-- <td>{{ date('d-m-Y',$row->fecha_emi) }}</td> --}}
								{{-- <td>{{  strtotime($row->fecha_emi) }}</td> --}}
								<td>{{ date("d-m-Y", strtotime($row->fecha_emi)) }}</td>
								<td>${{ number_format($row->cant_num, 2 )  }}</td>
								{{-- <td>{{ $row->factura_id }}</td>
								<td>{{ $row->fuente_id }}</td>
								<td>{{ $row->filter_search }}</td> --}}
								{{-- <td>{{$row->fuente_id}} - {{ $row->fuente->nombre_fuente }}</td>
								<td>{{$row->filter_search}} - {{ $row->proyecto->nombre_proyecto }}</td> --}}
								<td>{{ $row->fuente->nombre_fuente }}</td>
								<td>{{ $row->proyecto->nombre_proyecto }}</td>
								<td>{{ $row->nombre_proveedor }}</td>
								<td width="90">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Acciones
									</button>
									<div class="dropdown-menu dropdown-menu-right">
									{{-- <a  class="dropdown-item" href="{{url('quedans/pdf')}}"><i class="fa fa-print"></i> Imprimir </a>							  --}}
									<a data-toggle="modal" data-target="#associateModal" class="dropdown-item" wire:click="editQF({{$row->id}}, {{$row->my_proveeId}})"><i style="color: rgb(113, 198, 126)" class="fas fa-file-invoice-dollar"></i> Asociar Facturas </a>							 
									<a class="dropdown-item" href="{{action('App\Http\Controllers\PdfController@index', [$row->id, $row->cant_num])}}" target="_blank"><i style="color: darkgoldenrod" class="fa fa-print"></i> Imprimir </a>							 	
									<a data-toggle="modal" data-target="#updateModal" class="dropdown-item" wire:click="edit({{$row->id}}, {{$row->my_proveeId}})"><i style="color: deepskyblue" class="fa fa-edit"></i> Editar </a>							 
									<a class="dropdown-item" onclick="confirm('Confirmar Eliminación Quedan id {{$row->id}}? \nSeguro que quieres eliminarlo!')||event.stopImmediatePropagation()" wire:click="hidenstate({{$row->id}})"><i style="color: firebrick" class="fa fa-trash"></i> Eliminar </a>   
									{{-- <a  class="dropdown-item" onclick="confirm('Quieres eliminar el quedan? {{$row->id}}? \nLos quedan eliminados no se podran recuperar!')||event.stopImmediatePropagation()" wire:click= "hidenstate({{$row->id}})"><i class="fa fa-plus"></i> eliminar {{$row->id}}</a> --}}
									</div>
								</div>
								</td>
							@endforeach
						</tbody>
					</table>
	

					{{ $quedans->links() }}
					</div>
					
					
				</div>
				{{-- <input type="text" id="datepicker"> --}}
			</div>
		</div>
	</div>
</div>

