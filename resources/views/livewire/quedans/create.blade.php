<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" role="dialog"
    aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border: rgb(222, 222, 222) 1px solid;">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Nuevo Quedan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn" wire:click="$emit('refreshSelect2')">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    {{-- //todo num_quedan --}}
                    <div class="form-group" >
                        <label for="num_quedan"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Número de quedan</span>
                        <input wire:model="num_quedan" type="number" 
                             class="form-control" id="num_quedan"
                            placeholder="Num Quedan">@error('num_quedan') <span class="error text-danger">{{ $message
                            }}</span> @enderror
                    </div>

                    {{-- //todo factura_id  ################## --}}
                    

                    {{-- //todo fecha --}}
                    <div class="form-group">
                        <label for="fecha_emi"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Fecha de emisión</span>
                        <input wire:model="fecha_emi" type="date" 
                        class="form-control flatpickr flatpickr-input active mb-4" id="fecha_emi"  style="color: black"
                            placeholder="Fecha de emisión">@error('fecha_emi') <span class="error text-danger">{{ $message
                            }}</span> @enderror
                    </div>

                    {{-- //todo cant_num  ########## --}}
                    {{-- <div class="form-group">
                        <label for="cant_num"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Cantidad en número</span>
                        <input wire:model="cant_num" type="number"  class="form-control" id="cant_num"
                            placeholder="Escriba...">@error('cant_num') <span class="error text-danger">{{ $message
                            }}</span> @enderror
                    </div> --}}

                    {{-- ! divs with ids --}}

                    {{-- todo fuente_id --}}
                    <div  class="form-group" wire:ignore>
                        <label for="fuente_id"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Fuente de financiamiento (ID)</span>
                        <select class="form-control" style="width: 100%" wire:model="fuente_id" id="fuente_id">
                            <option value="">--- Seleccione el tipo de fuente ---</option>
                            @foreach ($select_fuentes as $selector_fuentes)
                            <option value="{{$selector_fuentes['id']}}"> {{ $selector_fuentes['nombre_fuente'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-top: -3%">
                        @error('fuente_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                     {{-- //todo proyecto_id --}}
                    <div  class="form-group" wire:ignore>
                        <label for="proyecto_id"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Proyecto (ID)</span>
                        <select class="form-control" style="width: 100%" wire:model="proyecto_id" id="proyecto_id">
                            <option value="">--- Seleccione el Proyecto ---</option>
                            @foreach ($select_proyectos as $selector_fuentes)
                            <option value="{{$selector_fuentes['id']}}"> {{ $selector_fuentes['nombre_proyecto'] }}</option>
                            {{-- @dd($selector) --}}
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-top: -3%">
                        @error('proyecto_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                     {{-- //todo proveedor_id --}}
                    <div  class="form-group" wire:ignore>
                        <label for="proveedor_id"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Proveedor (ID)</span>
                        <select class="form-control" style="width: 100%" wire:model="proveedor_id" id="proveedor_id">
                            <option value="">--- Seleccione el Proveedor ---</option>
                            @foreach ($select_proveedores as $selector_proveedor)
                            <option value="{{$selector_proveedor['id']}}"> {{ $selector_proveedor['nombre_proveedor'] }}</option>
                            {{-- @dd($selector) --}}
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-top: -3%">
                        @error('proveedor_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- ! scripts --}}

         
                    <script>
                        $('#createDataModal').show('show', function() { // coloca el número de quedan automáticamente
                            var x = $('.wizard').width();
                            $('#createDataModal').hide();
                            console.log('width: ' + x);
                            @this.functionNumQd();
                        });
                    </script>


                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                        $('#fuente_id').select2({
                                placeholder: "-- Seleccione el tipo de fuente --",
                                allowClear: true
                           }); //inicializar
                            //Captura el valor en el evento change
                            $('#fuente_id').on('change', function(e) {
                                var pId = $('#fuente_id').select2("val"); //get fuente id
                                @this.set('fuente_id', pId)
                                livewire.on('scan-code', action => {
                                    console.log('mi pid: ' + pId);
                                    $('#fuente_id').select2('')
                                });
                            });
                        });
                    </script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                        $('#proyecto_id').select2({
                                placeholder: "-- Seleccione el Proyecto --",
                                allowClear: true
                           }); //inicializar
                            //Captura el valor en el evento change
                            $('#proyecto_id').on('change', function(e) {
                                var pId = $('#proyecto_id').select2("val"); //get proyect id
                                @this.set('proyecto_id', pId)
                                livewire.on('scan-code', action => {
                                    console.log(pId);
                                    $('#proyecto_id').select2('')
                                });
                            });
                        });
                    </script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                        $('#proveedor_id').select2({
                                placeholder: "-- Seleccione el Proveedor --",
                                allowClear: true
                           }); //inicializar
                            //Captura el valor en el evento change
                            $('#proveedor_id').on('change', function(e) {
                                var pId = $('#proveedor_id').select2("val"); //get proyect id
                                @this.set('proveedor_id', pId)
                                livewire.on('scan-code', action => {
                                    console.log(pId);
                                    $('#proveedor_id').select2('')
                                });
                            });
                        });
                    </script>
                   

                </form>
            </div>

            {{-- //todo Buttons --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" wire:click="$emit('refreshSelect2')" data-dismiss="modal">Cancelar</button>
                {{-- <span wire:click="$emit('refreshSelect2')"> --}}
                    <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Guardar</button>
               {{-- </span> --}}
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function(){ // found
        Livewire.on('select2Send',() => {
            // Limpiando los selectores:
            $('#fuente_id').select2({
                        placeholder: "-- Seleccione el tipo de fuente --",
                        allowClear: true
                   }); //inicializar

            $('#proyecto_id').select2({
                        placeholder: "-- Seleccione el Proyecto --",
                        allowClear: true
                   }); //inicializar

            $('#proveedor_id').select2({
                        placeholder: "-- Seleccione el Proveedor --",
                        allowClear: true
                   }); //inicializar
        });
    }
</script>
