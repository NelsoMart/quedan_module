<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static"  role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">
            <div class="form-group">
                <label for="fecha_fac"></label>
                <span style="color: lightgray">Fecha</span>
                <input wire:model="fecha_fac" type="date" class="form-control" id="fecha_fac" placeholder="Fecha Fac">@error('fecha_fac') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="num_fac"></label>
                <span style="color: lightgray">Número de factura</span>
                <input wire:model="num_fac" type="text" class="form-control" id="num_fac" placeholder="Num Fac">@error('num_fac') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="monto"></label>
                <span style="color: lightgray">Monto</span>
                <input wire:model="monto" type="text" class="form-control" id="monto" placeholder="Monto">@error('monto') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- <div class="form-group">
                <label for="proveedor_id"></label>
                <input wire:model="proveedor_id" type="text" class="form-control" id="proveedor_id" placeholder="Proveedor Id">@error('proveedor_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div> --}}
            {{-- <div class="form-group" wire:ignore>
                <label for="proveedor_id"></label>
                <span style="color: lightgray">Proveedor</span>
                <select class="form-control"  id="select2_2">
                    {{-- <option disabled selected>--- Seleccione el proveedor ---</option> --}}
                    {{-- @foreach ($selectores as $selector) --}}
                    {{-- <option value="{{ $selector->id }}"> {{ $selector['nombre_proveedor'] }}</option>  --}}
                    {{-- <option value="{{$selector['id']}}"> {{ $selector['nombre_proveedor'] }}</option>
                    @endforeach
                </select>
            </div> --}}


            <div class="from-group" wire:ignore id="proveedor_id">
                <label for="proveedor_id"></label>
                <span style="font-size: 80%; color: rgb(190, 206, 218)">Proveedor (ID)</span>
                <select class="form-control" style="width: 100%" data-container="#proveedor_id" disabled
                    wire:model="proveedor_id" id="proveedor_id">
                    @foreach ($selectores as $selector)
                    <option value="{{$selector->id}}" wire:key="{{ $selector->id }}">
                        {{ $selector['nombre_proveedor'] }}</option>
                    @endforeach
                </select>
                <select class="input-group" style="width: 265" data-container="#proveedor_id"
                    wire:model="proveedor_id" id="select2_2">
                    <option value="">--- Buscar Nombre de Proyecto ---</option>
                    @foreach ($selectores as $selector)
                    <option value="{{$selector->id}}" wire:key="{{ $selector->id }}">
                        {{ $selector['nombre_proveedor'] }}</option>
                    @endforeach
                </select>
            </div>


            {{-- todo: section scripts --}}

            {{-- @push('scripts')
            <script>
                $(document).ready(function() {
                    $('.select2').select2();
                });
            </script>
            @endpush --}}

            {{-- <script>
                document.addEventListener('DOMContentLoaded', function () {
                   $('#proveedor_id').select2(); //inicializar
                    //Captura el valor en el evento change
                    $('#proveedor_id').on('change', function(e) {
                        var pId = $('#proveedor_id').select2("val"); //get proveedor id
                        @this.set('proveedor_id', pId)
                        livewire.on('scan-code', action => {
                            console.log(pId);
                            $('#proveedor_id').select2('')
                        });
                    });
                });
            </script> --}}

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
                                    @this.set('proveedor_id', pId)
                                    livewire.on('scan-code', action => {
                                        console.log(pId);
                                        $('#proveedor_id').select2('')
                                    });
                                    
                                });
                            });
                    </script>

            {{-- <script>
                $(document).ready(function() {
                    var genre_select2 = $('.proveedor_id').select2({
                        placeholder: "Seleccione el Género"
                    }).prepend('<option selected=""></option>')
                    $('.proveedor_id').on('change', function(e) {
                        @this.set('proveedor_id', e.target.value);
                    });
            
                    var selected__ = $('.proveedor_id').find(':selected').val();
                    if(selected__ !="") genre_select2.val(selected__);
                });
            </script> --}}

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Save</button>
            </div>
       </div>
    </div>
</div>
