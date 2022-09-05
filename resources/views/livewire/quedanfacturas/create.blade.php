<!-- Modal -->

<div wire:ignore.self class="modal" id="createDataModal" data-backdrop="static"  role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Asociar facturas a Quedan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
            {{-- <div class="form-group">
                <label for="factura_id"></label>
                <span style="font-size: 80%; color: rgb(190, 206, 218)">Factura (ID)</span>
                <input wire:model="factura_id" type="text" class="form-control" id="factura_id" placeholder="Factura Id">@error('factura_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div> --}}

            {{-- //todo factura_id  ################## --}}
            <div class="form-group" wire:ignore>
                <label for="factura_id"></label>
                <span style="font-size: 80%; color: rgb(177, 200, 216)">Factura (ID)</span>
                <select  wire:onchange="selectMonto(event.target.value)" class="form-control 
                    @error('category') is-invalid @enderror" 
                    style="width: 100%" wire:model="factura_id" id="factura_id">
                    <option value="">--- Seleccione la factura ---</option>
                    @foreach ($select_facturas as $selector_factura)
                    <option value="{{$selector_factura['id']}}">
                        {{-- ID: {{$selector_factura['id'] }}  --}}
                        • Número: {{$selector_factura['num_fac'] }} 
                        • Monto: ${{ $selector_factura['monto'] }}
                        • Proveedor: {{ $selector_factura['nombre_proveedor'] }}
                        {{-- {{$selector_factura['num_fac'] }} --}}
                    </option>
                    @endforeach
                </select>
                @error('factura_id') <span class="error text-danger">{{ $message
                    }}</span> @enderror
            </div>
            {{-- <div class="form-group">
                <label for="quedan_id"></label>
                <span style="font-size: 80%; color: rgb(190, 206, 218)">Quedan (ID)</span>
                <input wire:model="quedan_id" type="text" class="form-control" id="quedan_id" placeholder="Quedan Id">@error('quedan_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div> --}}
             {{-- //todo quedan_id  ################## --}}
             <div class="form-group" wire:ignore>
                <label for="quedan_id"></label>
                <span style="font-size: 80%; color: rgb(177, 200, 216)">Quedan (ID)</span>
                <select  wire:onchange="selectMonto(event.target.value)" class="form-control 
                    @error('category') is-invalid @enderror"
                    style="width: 100%" wire:model="quedan_id" id="quedan_id">
                    <option value="">--- Seleccione el quedan ---</option>
                    @foreach ($select_quedans as $selector_quedan)
                    {{-- <option value="{{$selector_quedan['id']}}" $monto_fact="{{ $selector_quedan['monto']}}"> --}}
                    <option value="{{$selector_quedan['id']}}">
                        {{-- ID: {{$selector_quedan['id'] }}  --}}
                        • Número: {{$selector_quedan['num_quedan'] }} 
                        • Fuente: {{ $selector_quedan['nombre_fuente'] }}
                        {{-- • Fecha: {{ $selector_quedan['fecha_emi'] }} --}}
                    </option>
                    @endforeach
                </select>
                @error('quedan_id') <span class="error text-danger">{{ $message
                    }}</span> @enderror
            </div>

            {{-- ! scripts --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () { //script factura
                        $('#factura_id').select2({
                            placeholder: "-- Seleccione la factura --",
                            allowClear: true
                        }); //inicializar
                        //Captura el valor en el evento change
                        $('#factura_id').on('change', function(e) {
                            var pId = $('#factura_id').select2("val"); //get factura id
                            @this.set('factura_id', pId)
                            // @this.set('monto_fact', pId)
                            // @this.set('monto_fact', e.target.find("option:selected").text())
                            // @this.set('monto_fact',$(this).find("option:selected").text())
                            // @this.getSelectedMonto(pId)
                            // // @this.functionNumQd()
                            // @this.Get_numberWords()
                            
                            // alert(pId);
                            // var selected = $(this).find("option:selected").text();
                            livewire.on('scan-code', action => {
                                console.log(pId);
                                $('#factura_id').select2('');
                                // $('#monto_fact').select2('')
                               
                            });
                        });
                    });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () { //script quedan
                        $('#quedan_id').select2({
                            placeholder: "-- Seleccione el quedan --",
                            allowClear: true
                        }); //inicializar
                        //Captura el valor en el evento change
                        $('#quedan_id').on('change', function(e) {
                            var pId = $('#quedan_id').select2("val"); //get factura id
                            @this.set('quedan_id', pId)
                            livewire.on('scan-code', action => {
                                console.log(pId);
                                $('#quedan_id').select2('');
                            });
                        });
                    });
            </script>

                </form>
            </div>
            <div class="modal-footer">
                @if (session()->has('message1'))
                    <div wire:poll.3s class="btn btn-danger" style="margin-top:0px; margin-bottom:0px;"> {{ session('message1') }} </div>
                @endif
                @if (session()->has('message2'))
                    <div wire:poll.3s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message2') }} </div>
                @endif
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store({{$quedan_id}},{{$factura_id}})" class="btn btn-primary close-modal">Crear Asociación</button>
            </div>
        </div>
    </div>
</div>
