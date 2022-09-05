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
    public $updateMode = false;

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

        //* ocultamos el proveedor en cuestión
        $ocultarP = Proveedore::find($id_proveedor);
        $ocultarP->update(['hiden' => 1,]);

        //* también ocultamos la o las facturas relacionadas con proveedor
        $ocultarF = Factura::select('id')->where('proveedor_id', $id_proveedor);
        $ocultarF->update(['hiden' => 1,]);


        //* Hacemos una búsqueda que retornará una o VARIAS facturas relacionadas con el mismo proveedor
        $getinIdsFacts = Factura::select('id')->where('proveedor_id', $id_proveedor)->get();

        //* recorremos $getinIdsFacts por si no trae uno sino varios registros relacionados
        foreach ($getinIdsFacts as $MyFactIds) {
            //? ocultamos también el o los Quedanfacturas relacionados a la o las  facturas
            $ocultarQF = Quedanfactura::select('id')->where('factura_id', $MyFactIds->id);
            $ocultarQF->update(['hiden' => 1,]);


            //*? ------ Un proceso más para actualizar el valor numérico en Quedan -------
            //* obtenemos quedan_id  "extrayéndolo" de la tabla Quedanfacturas
            $MyIDQdn = Quedanfactura::select('quedan_id')
            ->where('factura_id', $MyFactIds->id)->value('quedan_id');

            //* obtenemos el monto de la factura a ocultar
            $montofact = Factura::select('monto')
            ->where('id', $MyFactIds->id)->value('monto');

            //* decrementamos  la cantidad_num del quedan, tras ocultar la factura que había probocado su incremento
            $record2 = Quedan::find($MyIDQdn); //?  id de quedan obtenido de quedanfacturas
            $record2->decrement('cant_num', $montofact); //? resta el monto en el campo específico de quedan igual al selecionado en delete.

            //! Nota: Eliminar un proveedor implicará que la cantidad en número en un Quedan sea inmediatamente cero
            //? --------------------------------------------------------

        }

        session()->flash('message', 'Registro eliminado');
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombre_proveedor = null;
    }

    public function store()
    {
        $this->validate([
		'nombre_proveedor' => 'required',
        ]);

        Proveedore::create([ 
			'nombre_proveedor' => $this-> nombre_proveedor
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Proveedore Successfully created.');
    }

    public function edit($id)
    {
        $record = Proveedore::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre_proveedor = $record-> nombre_proveedor;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre_proveedor' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Proveedore::find($this->selected_id);
            $record->update([ 
			'nombre_proveedor' => $this-> nombre_proveedor
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Proveedore Successfully updated.');
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
