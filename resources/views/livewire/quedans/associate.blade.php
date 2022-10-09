<!-- Modal -->
<div wire:ignore.self class="modal fade"  id="associateModal"  
data-backdrop="static" role="dialog"
    aria-labelledby="associateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border: rgb(222, 222, 222) 1px solid;">
            <div class="modal-header">
                <style>
                    .myclass{
                      /* display:flex;
                      align-items:center;
                      background-color:grey;
                      color:#fff;
                      height:50px; */
                      width: 100%;
                    }
                  </style>
                  <div class="row" style="margin-top: 2%; width: 95%; margin-left: 2%">
                    {{-- <h5 class="modal-title" >Asociar Facturas del Proveedor {{$NomProvForAssocModal}} al Quedan {{$NumQForAssocModal}}</h5> --}}
                    <h5 class="ml-2 text-sm" style="color: rgb(48, 45, 45)">Asociar Facturas del Proveedor:</h5>
                    <h5 class="ml-2 text-sm" style="color: rgb(110, 116, 119)">{{$NomProvForAssocModal}}</h5>
                    <h5 class="ml-2 text-sm" style="color: rgb(48, 45, 45)">al Quedan:</h5>
                    <h5 class="ml-2 text-sm" style="color: rgb(110, 116, 119)"> Nº {{$NumQForAssocModal}}</h5>

                  </div>
                {{-- <h5 class="modal-title" id="associateModalLabel">Asociar Facturas del Proveedor {{$NomProvForAssocModal}} al Quedan {{$NumQForAssocModal}}</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>

                    @if ($select_facturas != null)

                <div class="row" style="90%">
                    <div style="float:left; margin-top: 3%; width: 70%; margin-left: 10%;
                                 inline: green solid thin; clear:both">
                        <input id="inputsearch"
                              wire:model='keyWordCheck'
                              {{-- wire:change="editQFSearch()" --}}
                              {{-- wire:model.lazy="select_facturas" --}}
                               {{-- wire:model.debounce.500ms='select_facturas'  --}}
                               {{-- wire:model.debounce.50ms='editQFSearch()'  --}}
                                type="number" 
                                class="form-control" name="search2" id="search2"
                            {{-- placeholder="{{$filter}}"  --}}
                            placeholder="Buscar Num Factura"
                            style="width: 100%;height: 5ch">
                    </div>

                    <div style="margin-top: 3.1%">
                        <button type="button" 
                                  wire:click.prevent="editQFSearch()"
                                  style=" background-color: white; padding: 35%;width: 185%; 
                                             border-radius: 15%; 
                                            border-color: rgb(247, 247, 247)">
                            <i style="color: rgb(144, 158, 168)" class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                {{-- <input wire:model="permission_resource.{{$loop->index}}" 
                type="checkbox" class="filled-in chk-col-green form-control" 
                id="{{$permission_type['name']}}" value="{{$permission_type['name']}}" /> --}}


                 <div class="checkbox">
                    {{-- //todo div Input CheckBox --}}
                    {{-- //! ### ojo con .defer --}}
                    {{-- <span class="ml-3 text-sm">Proveedor: Tal</span> --}}
                    @foreach ($select_facturas as $index => $selector_factura)
                    <div class="mt-3" style="margin-bottom: 3%; 
                                margin-top: 4%; margin-left: 4%">
                    <input type="checkbox" class="form-checkbox"
                    {{-- name="ArrayCheckedF[]"  --}}
                    {{-- wire:mouseover='hola' --}}
                    {{-- wire:key="ArrayCheckedF{{$selector_factura->id}}" --}}
                    {{-- @if($select_facturas->contains($selector_factura->added==1)) checked @endif --}}
                           {{-- id="{{$selector_factura['id']}}" --}}
                           {{-- id="ArrayCheckedF.{{ $selector_factura->id }}" --}}
                          {{-- value="{{$selector_factura['id']}}"  --}}
                          {{-- value="ArrayCheckedF.{{ $selector_factura->id }}"  --}}
                           {{-- wire:model="ArrayCheckedF.{{ $loop->index }}"  --}}
                           {{-- wire:model="ArrayCheckedF.{{ $index }}" --}}
                           {{-- wire:model="ArrayUncheckedF.{{ $selector_factura->id }}" --}}
                           wire:model.defer="ArrayCheckedF.{{ $selector_factura->id }}"
                           {{-- wire:model="ArrayCheckedF.{{ $selector_factura->id }}" --}}
                           {{-- wire:model="ArrayCheckedF.{{ $index }}" {{$this->ArrayCheckedF[$index]=$selector_factura->added == 1? 'checked' : ''}} --}}
                           {{-- wire:model="ArrayCheckedF.{{ $selector_factura->id}}" {{$this->ArrayCheckedF[$index]=$selector_factura->added == 1? 'checked' : ''}} --}}
                           {{-- wire:model="ArrayCheckedF.{{ $selector_factura->id }}" --}}
                           {{-- wire:model="ArrayCheckedF.{{ $selector_factura->id }}.checked" --}}
                           
                           {{-- {{ $this->ArrayCheckedF[$selector_factura->id] = $selector_factura->added == 1? 'checked' : '' }} --}}
                           {{-- {{ $this->ArrayCheckedF[$selector_factura->added] == 1? 'checked' : '' }} --}}
                           {{-- {{ $selector_factura->added == 1? 'checked' : '' }} --}}
                           {{-- {{ $this->ArrayCheckedF[$index] = 1 ? 'true' : '' }} --}}
                           {{-- wire:model="ArrayCheckedF"  --}}
                           {{--  class="form-checkbox h-6 w-6 text-green-500" --}}
                           {{-- @if($selector_factura->added == 1) checked = {{true}} @endif --}}
                           {{-- @if(in_array($selector_factura->id == 5, $selector_factura)) checked={{true}} @endif --}}
                       {{-- @if (in_array($select_facturas, $selector_factura->added)) checked @endif --}}
                          {{-- @if(old($selector_factura->id) == $selector_factura->id) checked @endif --}}
                         {{-- @if ($selector_factura->id == '5') checked @endif  --}}
                         {{-- @if($selector_factura->permissions->contains($permission->id)) checked @endif --}}
                         {{-- @if($select_facturas->contains($selector_factura->added==1)) checked @endif --}}
                         {{-- @if($select_facturas->contains($selector_factura->id)) checked @endif --}}
                         {{-- @if(in_array($selector_factura->id,$ArrayCheckedF)) checked @endif --}}
                          >
                          {{-- <span class="ml-3 text-sm">ID: {{ $selector_factura->id }}</span> --}}
                          {{-- <span class="ml-3 text-sm">Added: {{ $selector_factura->added }}</span> --}}
                           <span class="ml-3 text-sm">Núm: {{ $selector_factura->num_fac }}</span>
                          <span class="ml-3 text-sm">Monto: {{ number_format($selector_factura->monto, 2) }}</span>
                          <span class="ml-3 text-sm">Fecha: {{ date("d-m-Y", strtotime($selector_factura->fecha_fac)) }}</span>
                          {{-- <span class="ml-3 text-sm">Prov: {{ $selector_factura->nombre_proveedor }}</span> --}}
                          {{-- //! <span class="ml-2 text-sm">Prov: {{ $selector_factura->nombre_proveedor }}</span> --}}
                          {{-- ID: {{$selector_factura->id }} 
                          • Núm: {{$selector_factura['num_fac'] }} 
                          • Monto: ${{ number_format($selector_factura['monto'], 2) }} 
                          • Fecha: {{  $selector_factura['fecha_fac'] }}
                          • Prov: {{ $selector_factura['nombre_proveedor'] }} --}}
                    </div>
                   @endforeach                  
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
                    <div wire:poll.3s class="btn btn-danger" style="margin-top:0px; margin-bottom:0px;"> {{ session('message1') }} </div>
                @endif
                @if (session()->has('message2'))
                    <div wire:poll.3s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message2') }} </div>
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


