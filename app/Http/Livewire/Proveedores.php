<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Proveedore;
use App\Models\Factura;
use App\Models\Quedan;
use App\Models\Quedanfactura;

class Proveedores extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre_proveedor, $hiden;
    public $old_nomProv;
    public $updateMode = false;

    public $id_prov;

    protected $listeners = ['remove', 'hidingfact'];

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.proveedores.view', [
            'proveedores' => Proveedore::latest()
						->orWhere('nombre_proveedor', 'LIKE', $keyWord)
                        ->whereNull('proveedores.hiden')->orWhere('proveedores.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
						->paginate(10),
        ]);
    }

    public function hidenstate($id_proveedor)
    { //* sirve para ocultar los registros en lugar de destruirlos


        $this->id_prov = $id_proveedor;
     
        //* ocultamos el proveedor en cuestión
            $ocultarP = Proveedore::find($id_proveedor);
            $ocultarP->update(['hiden' => 1,]);

        $this->dispatchBrowserEvent('confirm', [
            'type' => 'success',

            'message' => '¡Ha sido eliminado el proveedor!', 
            'text' => 'Pero es posible que aún queden facturas sin asociar de este proveedor, ¿Desea eliminarlas?',
            // 'buttons' => true,
            // 'dangerMode' => true,
        ]);

        // session()->flash('message', 'Registro eliminado');
    }
	
    public function hidingfact(){
       //* ocultamos la o las facturas que no están asociadas a ningún Quedan

        //! descomentar ##############
        $ocultarF = Factura::select('id')
        ->where('proveedor_id', $this->id_prov)
        ->where('added', '=', 0);
        $ocultarF->update(['hiden' => 1,]);

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',  
            // 'message' => '¡facturas eliminadas!', 
            'message' => '¡Proceso finalizado!', 
            'text' => 'Ha finalizado el proceso de eliminación exitosamente',
            'icon'=>'success',
            'timer'=> 4000,
            'toast'=>true,
            // 'position'=>'top-right'
        ]);

    }

    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
        // $this->emit('closeModal');
    }
	
    private function resetInput()
    {		
		$this->nombre_proveedor = null;
        $this->resetErrorBag();
        $this->emit('closeModal');
    }

    public function store()
    {
        $this->validate([
		'nombre_proveedor' => ['required', 'unique:proveedores']
        ], ['unique'=>'Este proveedor ya está registrado']);

        // session()->flash('message', 'Este proveedor ya está registrado');

        Proveedore::create([ 
			'nombre_proveedor' => $this-> nombre_proveedor
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Proveedor creado exitosamente.');
    }

    public function edit($id)
    {
        $record = Proveedore::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre_proveedor = $record->nombre_proveedor;
		$this->old_nomProv = $record->nombre_proveedor;
		
        $this->updateMode = true;
    }

    public function update()
    {
        if ($this->old_nomProv == $this->nombre_proveedor) { //* si se intenta guardar sin hacer cambios en el nombre de origen
            $this->emit('closeModal');
        }
        // if ($this->nombre_proveedor == null) {
        //     $this->validate([
        //         'nombre_proveedor' => ['required', 'unique:proveedores', 'unique']
        //     ], ['unique' => 'Este proveedor ya está registrado']);
        // }
        // if ($this->old_nomProv != $this->nombre_proveedor) { //* Si el nombre de origen es distinto al que se quiere guardar:
        //     if ($this->selected_id) {
        //         $MyNombProv = Proveedore::select('nombre_proveedor')->Where('nombre_proveedor', '=', $this->nombre_proveedor)->value('nombre_proveedor');
        //         if ($MyNombProv == $this->nombre_proveedor) { //* si el proveedor que se quiere guardar es igual a uno que ya existe:
        //             $this->validate([
        //                 'nombre_proveedor' => ['required', 'unique:proveedores', 'unique']
        //                 ], ['unique' => 'Este proveedor ya está registrado']
        //             );
        //         } else { //* el nombre es nuevo, proceder a actualizar:
        //             $record = Proveedore::find($this->selected_id);
        //             $record->update([
        //                 'nombre_proveedor' => $this->nombre_proveedor
        //             ]);
        //             $this->resetInput();
        //             $this->emit('closeModal');
        //             session()->flash('message', 'Proveedor actualizado exitosamente.');
        //         }
        //     }
        // }

        if ($this->old_nomProv != $this->nombre_proveedor) {

            $this->validate([
                'nombre_proveedor' => ['required', 'unique:proveedores']
            ], ['unique' => 'Este proveedor ya está registrado']);

            if ($this->selected_id) {
                $record = Proveedore::find($this->selected_id);
                $record->update([
                    'nombre_proveedor' => $this->nombre_proveedor
                ]);
                $this->resetInput();
                $this->emit('closeModal');
                session()->flash('message', 'Registro actualizado exitosamente.');
            }
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Proveedore::where('id', $id);
            $record->delete();
        }
    }
}
