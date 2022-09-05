<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" role="dialog" 
aria-labelledby="createDataModalLabel" aria-hidden="true">
{{-- <div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true"> --}}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Nueva Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
            <div class="form-group">
                <label for="fecha_fac"></label>
                <input wire:model="fecha_fac" type="date" class="form-control" id="fecha_fac" placeholder="Fecha Fac">@error('fecha_fac') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="num_fac"></label>
                <input wire:model="num_fac" type="number" class="form-control" id="num_fac" placeholder="Número de factura">@error('num_fac') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="monto"></label>
                <input wire:model="monto" type="number" class="form-control" id="monto" placeholder="Monto">@error('monto') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            {{-- <div class="form-group">
                <label for="proveedor_id"></label>
                <input wire:model="proveedor_id" type="text" class="form-control" id="proveedor_id" placeholder="Proveedor Id">@error('proveedor_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div> --}}
    
            <div class="form-group" wire:ignore>
                <label for="proveedor_id"></label>
                <select class="form-control" style="width: 100%" wire:model="proveedor_id" id="proveedor_id">
                    <option value="">-- Seleccione el Proveedor --</option>
                     @foreach ($selectores as $selector)
                    <option value="{{$selector['id']}}"> {{ $selector['nombre_proveedor'] }}</option>
                    @endforeach
                </select>
            </div>

            
           {{-- <div class="form-group" wire:ignore>
                <label for="proveedor_id"></label>
                <select class="form-control" style="width: 100%" wire:model="proveedor_id" id="proveedor_id">
                    <option value="">--- Seleccione el proveedor ---</option>
                    @foreach ($selectores as $selector)
                    <option value="{{ $selector->id }}"> {{ $selector['nombre_proveedor'] }}</option>
                    @endforeach
                </select>
            </div> --}}

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                $('#proveedor_id').select2({
                        placeholder: "-- Seleccione el Proveedor --",
                        allowClear: true
                   }); //inicializar
                    //Captura el valor en el evento change
                    $('#proveedor_id').on('change', function(e) {
                        var pId = $('#proveedor_id').select2("val"); //get fuente id
                        @this.set('proveedor_id', pId)
                        livewire.on('scan-code', action => {
                            console.log('mi pid: ' + pId);
                            $('#proveedor_id').select2('')
                        });
                        // $("#proveedor_id").val('').trigger('change')
                    });
                    $('#proveedor_id').on('hidden.bs.modal', function(e) {
                        alert('hola');

                        // $("#proveedor_id").val('').trigger('change');
                        $("#proveedor_id").select2("val", "");
                    });
                   
                });
            </script>

            <script>
                $('#createDataModal').on('hidden.bs.modal', function () {
                    alert('holaaa');
                })
            </script>
           
            {{-- <script>
                $(document).ready(function() {
                    $('#proveedor_id').select2();
                    $('#proveedor_id').on('change', function (e) {
                        var data = $('#proveedor_id').select2("val");
                        @this.set('foo', data);
                    });
                });
            </script> --}}

            {{-- <script>
                $('#proveedor_id').select2({
                    dropdownParent: $('#createDataModal')
                });
            </script> --}}

            {{-- <script>
                $('#select2').select2()
            </script> --}}

            {{-- <script>
                $("#proveedor_id").select2().select2('val','2');
            </script> --}}

        {{-- <script>
           $('.select2').val(@this.parent_id).trigger('change');
        </script> --}}

                </form> 

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Save</button>
                <button type="button" wire:click="$emit('refreshData')" class="btn">run JavaScript script</button>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    window.onload = function(){ // fopund
        Livewire.on('dataSend',(postID, MyString) => {
            alert("Tu formulario no quiere enviarse, jajaja." + postID + MyString )
        })
    }
</script> --}}

{{-- <script>
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('#proveedor_id').select2()
        
        }); });
   </script> --}}

   {{-- <script>
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'target'    => '#proveedor_id',
            'component' => $this->id // this is component id
        ]);
   </script> --}}

   {{-- <script>
	$("#proveedor_id").select2().select2('val','1');
</script> --}}

