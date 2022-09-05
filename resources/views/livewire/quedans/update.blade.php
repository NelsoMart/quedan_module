<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" role="dialog"
    aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Quedan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    {{-- <input type="hidden" wire:model="selected_id"> --}}
                    <div class="form-group">
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Número de quedan</span>
                        <label for="num_quedan"></label>
                        <input wire:model="num_quedan" type="number" class="form-control" id="num_quedan"
                            placeholder="Num Quedan">@error('num_quedan') <span class="error text-danger">{{ $message
                            }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_emi"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Fecha de emisión</span>
                        <input wire:model="fecha_emi" type="date" class="form-control" id="fecha_emi"
                            placeholder="Fecha Emi">@error('fecha_emi') <span class="error text-danger">{{ $message
                            }}</span> @enderror
                    </div>
                    {{-- <div class="form-group">
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Cantidad en número</span>
                        <label for="cant_num"></label>
                        <input wire:model="cant_num" type="number" class="form-control" id="cant_num"
                            placeholder="Cant Num">@error('cant_num') <span class="error text-danger">{{ $message
                            }}</span> @enderror
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="cant_letra"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Cantidad en letra</span>
                        <input wire:model="cant_letra" type="text" class="form-control" id="cant_letra"
                            placeholder="Cant Letra">@error('cant_letra') <span class="error text-danger">{{ $message
                            }}</span> @enderror
                    </div> --}}
                    



                    {{-- todo: section IDs --}}

                    {{-- * select2_1 fuente id --}}
                    <div class="form-group" wire:ignore id="fuente_id">
                        <label for="fuente_id"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Fuente de financiamiento (ID)</span>
                        <select class="form-control" style="width: 100%" data-container="#fuente_id" disabled
                            wire:model="fuente_id" id="fuente_id">
                            @foreach ($select_fuentes as $selector_fuentes)
                            <option value="{{$selector_fuentes['id']}}"> {{ $selector_fuentes['nombre_fuente'] }}</option>
                            @endforeach
                        </select>
                        <select class="input-group" style="width: 265" data-container="#fuente_id"
                            wire:model="fuente_id" id="select2_1">
                            <option value="">--- Buscar por Nombre de Fuente ---</option>
                            @foreach ($select_fuentes as $selector_fuentes)
                            <option value="{{$selector_fuentes['id']}}"> {{ $selector_fuentes['nombre_fuente'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- * select2_2 proyecto id --}}
                    <div class="from-group" wire:ignore id="proyecto_id">
                        <label for="proyecto_id"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Proyecto (ID)</span>
                        <select class="form-control" style="width: 100%" data-container="#proyecto_id" disabled
                            wire:model="proyecto_id" id="proyecto_id">
                            @foreach ($select_proyectos as $selector_proyecto)
                            <option value="{{$selector_proyecto->id}}" wire:key="{{ $selector_proyecto->id }}">
                                {{ $selector_proyecto['nombre_proyecto'] }}</option>
                            @endforeach
                        </select>
                        <select class="input-group" style="width: 265" data-container="#proyecto_id"
                            wire:model="proyecto_id" id="select2_2">
                            <option value="">--- Buscar Nombre de Proyecto ---</option>
                            @foreach ($select_proyectos as $selector_proyecto)
                            <option value="{{$selector_proyecto->id}}" wire:key="{{ $selector_proyecto->id }}">
                                {{ $selector_proyecto['nombre_proyecto'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- * select2_3 proveedor id --}}
                    <div class="from-group" wire:ignore id="proveedor_id" style="margin-top: 3%">
                        <label for="proveedor_id"></label>
                        <span style="font-size: 80%; color: rgb(190, 206, 218)">Proveedor (ID)</span>
                        <select class="form-control" style="width: 100%" data-container="#proveedor_id" disabled
                            wire:model="proveedor_id" id="proveedor_id">
                            @foreach ($select_proveedores as $selector_proveedor)
                            <option value="{{$selector_proveedor->id}}" wire:key="{{ $selector_proveedor->id }}">
                                {{ $selector_proveedor['nombre_proveedor'] }}</option>
                            @endforeach
                        </select>
                        <select class="input-group" style="width: 265" data-container="#proveedor_id"
                            wire:model="proveedor_id" id="select2_3">
                            <option value="">--- Buscar Nombre de Proveedor ---</option>
                            @foreach ($select_proveedores as $selector_proveedor)
                            <option value="{{$selector_proveedor->id}}" wire:key="{{ $selector_proveedor->id }}">
                                {{ $selector_proveedor['nombre_proveedor'] }}</option>
                            @endforeach
                        </select>
                    </div>

                   
                    {{-- <div class="checkbox" style="margin-top: 5%">
                       <label for="proveedor_id">Facturas Asociadas</label>
                        @if ($select_facturas != null)
                        @foreach ($select_facturas as $index => $selector_factura)
                        <div>
                        <input type="checkbox" value="{{$selector_factura->id}}"
                               wire:model="ArrayFacturas.{{ $index }}" name="ArrayFacturas[]">
                              Núm: {{$selector_factura['num_fac'] }} 
                              • Monto: ${{ number_format($selector_factura['monto'], 2) }} 
                              • Fecha: {{  $selector_factura['fecha_fac'] }}
                        
                        </div>
                       @endforeach
                            <a class="dropdown-item" onclick="confirm('Confirmar Deasociación? \nSeguro que quieres quitar las facturas seleccionadas!')||event.stopImmediatePropagation()" wire:click=""><i style="color: firebrick" class="fa fa-trash"></i> Quitar </a>
                       @endif  
                    </div> --}}


             {{-- todo: section scripts --}}

                    {{-- * script fuente id --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            $('#select2_1').select2({
                                width: '265', // ? esto permite que el ancho del select2 se mantenga fijo siempre
                                placeholder: "-- Buscar por Nombre de Fuente --",
                                allowClear: true
                            }); //inicializar
                            //Captura el valor en el evento change
                            $('#select2_1').on('change', function(e) { //? select2_1
                                select2_1:open
                                var pId = $('#select2_1').select2("val"); //get proveedor id //? select2_1
                                @this.set('fuente_id', pId)
                                livewire.on('scan-code', action => {
                                    console.log(pId);
                                    $('#fuente_id').select2('')
                                });
                                
                            });
                        });
                    </script>

                    {{-- * script proyecto id --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            $('#select2_2').select2({
                                    width: '265', // ? esto permite que el ancho del select2 se mantenga fijo siempre
                                    placeholder: "-- Buscar Nombre de Proyecto --",
                                    allowClear: true
                            }); //inicializar
                                //Captura el valor en el evento change
                                $('#select2_2').on('change', function(e) { //? select2
                                    select2:open
                                    var pId = $('#select2_2').select2("val"); //get proveedor id //? select2_2
                                    @this.set('proyecto_id', pId)
                                    livewire.on('scan-code', action => {
                                        console.log(pId);
                                        $('#proyecto_id').select2('')
                                    });
                                    
                                });
                            });
                    </script>

                    {{-- * script Proveedor id --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            $('#select2_3').select2({
                                    width: '265', // ? esto permite que el ancho del select2 se mantenga fijo siempre
                                    placeholder: "-- Buscar Nombre de Proveedor --",
                                    allowClear: true
                            }); //inicializar
                                //Captura el valor en el evento change
                                $('#select2_3').on('change', function(e) { //? select2
                                    select2:open
                                    var pId = $('#select2_3').select2("val"); //get proveedor id //? select2_3
                                    @this.set('proveedor_id', pId)
                                    livewire.on('scan-code', action => {
                                        console.log(pId);
                                        $('#proveedor_id').select2('')
                                    });
                                    
                                });
                            });
                    </script>

                   

                    {{-- <script>
                        $timeout(function(){
                    $(document).ready(function() {
                    $('#select2').select2();
                    $('#select2').on('change', function (e) {
                        var data = $('#select2').select2("val");
                        @this.set('proyecto_id', data);
                    });
                });
                    }, 50);

                </script> --}}


                    {{-- <script>
                        document.addEventListener("DOMContentLoaded", () => {
                    Livewire.hook('message.received', (message, component) => {
                        $('proyecto_id').select2('refresh');
                    })
                });

                window.addEventListener('contentChanged', event => {
                    $('#proyecto_id').selectpicker('refresh');
                });
                    </script> --}}


                    {{-- <script>
                        window.addEventListener('contentChanged', event => {
                        // $('#proyecto_id').select2();
                        $("#proyecto_id").select2("destroy");
                        $("#proyecto_id").select2();
                });
                    </script>

                    <script>
                        document.addEventListener("livewire:load", function (event) {
            window.livewire.hook('afterDomUpdate', () => {
                let proyecto_id = @this.get('proyecto_id')
                $('#proyecto_id').val(proyecto_id).trigger('change');
            });
        });
                    </script> --}}




                    {{-- @push('scripts')
                    <script>
                        $(document).ready(function () {
                    //todo: este script funciona
                    $('proyecto_id').select2();
                    $(document).on('change', '#select2', function (e) {
                        //when ever the value of changes this will update your PHP variable 
                        @this.set('proyecto_id', e.target.value);
                    });
                });
                    </script>
                    @endpush --}}



                    {{-- <script>
                        $("#proyecto_id").select2("destroy");

                $("#proyecto_id").select2();
                    </script> --}}


                    {{-- <script>
                        $(function(){
                    $('#select2').select2({
                        theme:'bootstrap4',
                    }).on('chage', function(){
                        @this.set('proyecto_id', $(this).val())
                    })
                });
                    </script> --}}




                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary"
                    data-dismiss="modal">Cancelar</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary"
                    data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    $('.proyecto_id').html('').select2({
     alert('here')
                     // var pId = $('#select2').select2("val"); //get proveedor id //? select2
                     @this.set('proyecto_id', $(this).val())
                     livewire.on('scan-code', action => {
                         console.log(pId);
                         $('#proyecto_id').select2('')
                     });
         })
</script> --}}

{{-- <script>
    (function($){
           $(document).on('livewire:load',function(){
               $('#proyecto_id').select2({
                   "language":"pt-BR",
               })
               Livewire.hook('message.processed',(message,component)=>{
                   $('#proyecto_id').elect2();
               })
           })
       })(jQuery)
</script> --}}

{{-- <script>
    $('#proyecto_id').trigger('change.select2');
</script> --}}