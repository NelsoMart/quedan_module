<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border: rgb(222, 222, 222) 1px solid;">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">
            <div class="form-group">
                <label for="nombre_proveedor"></label>
                <input wire:model="nombre_proveedor" type="text" class="form-control" id="nombre_proveedor" placeholder="Nombre Proveedor">@error('nombre_proveedor') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary close-modal">Cancelar</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary close-modal">Guardar</button>
            </div>
       </div>
    </div>
</div>
