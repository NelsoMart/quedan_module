<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Asociación Quedan-facturas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
			{{-- <input type="hidden" wire:model="selected_id">
            <div class="form-group">
                <label for="factura_id"></label>
                <input wire:model="factura_id" type="text" class="form-control" id="factura_id" placeholder="Factura Id">@error('factura_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div> --}}
            {{-- * select2_0 factura id --}}
            <div class="form-group" wire:ignore id="factura_id">
                <span style="font-size: 80%; color: rgb(190, 206, 218)">Número de factura (ID)</span>
                <label for="factura_id"></label>
                <select class="form-control" style="width: 100%" data-container="#factura_id"
                    wire:model="factura_id" id="factura_id" disabled>
                    @foreach ($select_facturas as $selector_factura)
                    <option value="{{$selector_factura['id']}}">
                        ID: {{$selector_factura['id'] }}
                        • Número: {{$selector_factura['num_fac'] }} 
                        • Monto: ${{ $selector_factura['monto'] }}
                        • Proveedor: {{ $selector_factura['nombre_proveedor'] }}
                        {{-- {{ $selector_factura['num_fac'] }} --}}
                    </option>
                    @endforeach
                </select>
                <select class="input-group" style="width: 265" data-container="#factura_id"
                    wire:model="factura_id" id="select2_0">
                    <option value="">--- Buscar por Número de Factura ---</option>
                    {{-- <option selected disabled>--- Buscar por Número de Factura ---</option> --}}
                    @foreach ($select_facturas as $selector_factura)
                    <option value="{{$selector_factura['id']}}">
                        ID: {{$selector_factura['id'] }}
                        • Número: {{$selector_factura['num_fac'] }} 
                        • Monto: ${{ $selector_factura['monto'] }}
                        • Proveedor: {{ $selector_factura['nombre_proveedor'] }}
                        {{-- {{ $selector_factura['num_fac'] }} --}}
                    </option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="form-group">
                <label for="quedan_id"></label>
                <input wire:model="quedan_id" type="text" class="form-control" id="quedan_id" placeholder="Quedan Id">@error('quedan_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div> --}}
            {{-- * select2_1 quedan id --}}
            <div class="form-group" wire:ignore id="quedan_id">
                <span style="font-size: 80%; color: rgb(190, 206, 218)">Número de Quedan (ID)</span>
                <label for="quedan_id"></label>
                <select class="form-control" style="width: 100%" data-container="#quedan_id"
                    wire:model="quedan_id" id="quedan_id" disabled>
                    @foreach ($select_quedans as $selector_quedan)
                    <option value="{{$selector_quedan['id']}}">
                        {{-- ID: {{$selector_quedan['id'] }} --}}
                        • Número: {{$selector_quedan['num_quedan'] }} 
                        • Fuente: {{ $selector_quedan['nombre_fuente'] }}
                        • Fecha: {{ $selector_quedan['fecha_emi'] }}
                    </option>
                    @endforeach
                </select>
                <select class="input-group" style="width: 265" data-container="#quedan_id"
                    wire:model="quedan_id" id="select2_1">
                    <option value="">--- Buscar por Número de Quedan ---</option>
                    {{-- <option selected disabled>--- Buscar por Número de Quedan ---</option> --}}
                    @foreach ($select_quedans as $selector_quedan)
                    <option value="{{$selector_quedan['id']}}">
                        {{-- ID: {{$selector_quedan['id'] }} --}}
                        • Número: {{$selector_quedan['num_quedan'] }}
                        • Fuente: {{ $selector_quedan['nombre_fuente'] }}
                    </option>
                    @endforeach
                </select>
            </div>

             {{-- todo: section scripts --}}

            {{-- * script factura id --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    $('#select2_0').select2({
                        width: '265', // ? esto permite que el ancho del select2 se mantenga fijo siempre
                        placeholder: "-- Buscar por Número de Factura --",
                        allowClear: true
                    }); //inicializar
                    //Captura el valor en el evento change
                    $('#select2_0').on('change', function(e) { //? select2_0
                        select2_0:open
                        var pId = $('#select2_0').select2("val"); //get proveedor id //? select2_0
                        // // @this.set('factura_id', e.target.value) //found
                        // // @this.set('factura_id', $(this).val()); //found
                        @this.set('factura_id', pId)
                        // @this.getSelectedMonto(pId)
                        // @this.Get_numberWords()
                        livewire.on('scan-code', action => {
                            console.log(pId);
                            $('#factura_id').select2('')
                        });    
                    });
                });
            </script>

            {{-- * script quedan id --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    $('#select2_1').select2({
                        width: '265', // ? esto permite que el ancho del select2 se mantenga fijo siempre
                        placeholder: "-- Buscar por Número de Quedan --",
                        allowClear: true
                    }); //inicializar
                    //Captura el valor en el evento change
                    $('#select2_1').on('change', function(e) { //? select2_0
                        select2_1:open
                        var pId = $('#select2_1').select2("val");
                        // // @this.set('quedan_id', e.target.value) //found
                        // // @this.set('quedan_id', $(this).val()); //found
                        @this.set('quedan_id', pId)
                        // @this.getSelectedMonto(pId)
                        // @this.Get_numberWords()
                        livewire.on('scan-code', action => {
                            console.log(pId);
                            $('#quedan_id').select2('')
                        });    
                    });
                });
            </script>

                </form>
            </div>
            <div class="modal-footer">
                @if (session()->has('message1'))
                    <div wire:poll.5s class="btn btn-danger" style="margin-top:0px; margin-bottom:0px;"> {{ session('message1') }} </div>
                @endif
                @if (session()->has('message2'))
                    <div wire:poll.5s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message2') }} </div>
                @endif
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                {{-- <button type="button" wire:click.prevent="update({{$quedan_id}},{{$factura_id}})" class="btn btn-primary">Actualizar</button> --}}
                <button type="button" wire:click.prevent="update({{$quedan_id}},{{$factura_id}})" class="btn btn-primary" data-dismiss="modal">Actualizar</button>
            </div>
       </div>
    </div>
</div>
