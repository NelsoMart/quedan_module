<!-- Modal -->
<div wire:ignore.self class="modal fade" id="associateModal" data-backdrop="static" role="dialog"
    aria-labelledby="associateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border: rgb(222, 222, 222) 1px solid;">
            <div class="modal-header">
                <style>
                    .myclass {
                        /* display:flex;
                                  align-items:center;
                                  background-color:grey;
                                  color:#fff;
                                  height:50px; */
                        width: 100%;
                    }
                </style>
                <div class="row" style="margin-top: 2%; width: 95%; margin-left: 2%">
                    <h5 class="ml-2 text-sm" style="color: rgb(48, 45, 45)">Asociar Facturas del Proveedor:</h5>
                    <h5 class="ml-2 text-sm" style="color: rgb(110, 116, 119)">{{$NomProvForAssocModal}}</h5>
                    <h5 class="ml-2 text-sm" style="color: rgb(48, 45, 45)">al Quedan:</h5>
                    <h5 class="ml-2 text-sm" style="color: rgb(110, 116, 119)"> Nº {{$NumQForAssocModal}}</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            @if ($select_facturas != null)
                <div class="row" style="90%">
                    {{-- todo: Div Search Box --}}
                    <div style="float:left; margin-top: 3%; width: 70%; margin-left: 10%;
                                    inline: green solid thin; clear:both">
                        <input id="inputsearch" wire:model='keyWordCheck' type="number" class="form-control" name="search2"
                            id="search2" placeholder="Buscar Num Factura" style="width: 100%;height: 5ch">
                    </div>
                    <div style="margin-top: 3.1%">
                        <button type="button" wire:click.prevent="editQFSearch()" style=" background-color: white; padding: 35%;width: 185%; 
                                                border-radius: 15%; 
                                                border-color: rgb(247, 247, 247)">
                            <i style="color: rgb(144, 158, 168)" class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    {{-- todo: div Input CheckBox --}}
                    <div class="checkbox">
                        @foreach ($select_facturas as $index => $selector_factura)
                        <div class="mt-3" style="margin-bottom: 3%; 
                                                        margin-top: 4%; margin-left: 4%">
                            <input type="checkbox" class="form-checkbox"
                                wire:model.defer="ArrayCheckedF.{{ $selector_factura->id }}">
                            {{-- <span class="ml-3 text-sm">ID: {{ $selector_factura->id }}</span> --}}
                            {{-- <span class="ml-3 text-sm">Added: {{ $selector_factura->added }}</span> --}}
                            <span class="ml-3 text-sm">Núm: {{ $selector_factura->num_fac }}</span>
                            <span class="ml-3 text-sm">Monto: {{ number_format($selector_factura->monto, 2) }}</span>
                            <span class="ml-3 text-sm">Fecha: {{ date("d-m-Y", strtotime($selector_factura->fecha_fac))
                                }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <script>
                    $('#inputsearch').on('change', function(e) {
                            @this.editQFSearch();
                            // alert('foo');
                        })
                </script>
            @endif
            <div class="modal-footer">
                @if (session()->has('message1'))
                <div wire:poll.3s class="btn btn-danger" style="margin-top:0px; margin-bottom:0px;"> {{
                    session('message1') }} </div>
                @endif
                @if (session()->has('message2'))
                <div wire:poll.3s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{
                    session('message2') }} </div>
                @endif
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary"
                    data-dismiss="modal">Cancelar</button>
                <span wire:click="$emit('openingReport')">
                    <button type="button" wire:click.prevent="StoreDelete_QF()" class="btn btn-primary"
                        data-dismiss="modal">Guardar</button>
                </span>

            </div>
        </div>
    </div>
</div>