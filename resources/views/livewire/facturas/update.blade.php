<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static"  role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border: rgb(222, 222, 222) 1px solid;">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Modificar Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  wire:click.prevent="cancel()">×</span>
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
                <input wire:model="num_fac" type="number" class="form-control" id="num_fac" placeholder="Num Fac">@error('num_fac') <span class="error text-danger">{{ $message }}</span> @enderror
                @if ($blackErr == true)
                <span class="error text-danger">El número ya existe para este proveedor.</span>
                @endif
            </div>
            <div class="form-group">
                <label for="monto"></label>
                <span style="color: lightgray">Monto $</span>
                <input wire:model="monto" type="number" class="form-control" id="monto" placeholder="Monto">@error('monto') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

          {{--? se comentó esta opción, pero funciona --}}
           {{-- @if ($this->updateMode == true)
                <div class="from-group" wire:ignore>
                    <div>
                        <span style="color: lightgray">Proveedor (ID)</span>
                        <select wire:model="proveedor_id"
                        class="form-control" id="select2">
                            @foreach ($selectores as $selector)
                            <option value="{{$selector->id}}">
                                {{ $selector['nombre_proveedor'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif --}}


        {{-- todo: section scripts --}}
        {{--? se comentó esta opción, pero funciona --}}
            {{-- @if ($updateMode == true)
                <script>
                    $('#select2').select2({
                        placeholder: "-- Buscar Nombre de Proveedor --",
                        // allowClear: true,
                        width: '100%'
                    });
                    $('#select2').on('change', function(e) {
                        var pId = $('#select2').select2("val"); //get id
                        @this.set('proveedor_id', pId)
                        livewire.on('scan-code', action => {
                            console.log(pId);
                        });
                    });
                </script>
            @endif --}}

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary close-modal">Cancelar</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary close-modal">Guardar</button>
            </div>
       </div>
    </div>
</div>