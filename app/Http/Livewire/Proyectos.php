<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Proyecto;
use App\Models\Quedan;
use App\Models\Factura;
use App\Models\Quedanfactura;

class Proyectos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre_proyecto, $hiden;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.proyectos.view', [
            'proyectos' => Proyecto::latest()
						->orWhere('nombre_proyecto', 'LIKE', $keyWord)
                        ->whereNull('proyectos.hiden')->orWhere('proyectos.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
						->paginate(10),
        ]);
    }
	
    public function hidenstate($id_proyecto)
    { //* sirve para ocultar los registros en lugar de destruirlos

        //* ocultamos el proyecto
        $ocultarP = Proyecto::find($id_proyecto);
        $ocultarP->update(['hiden' => 1,]);

        //* también ocultamos el o los quedans relacionadas con este proyecto
        // $ocultarF = Quedan::select('id')->where('proyecto_id', $id_proyecto);
        // $ocultarF->update(['hiden' => 1,]);

        //? Se hace una búsqueda que retornará uno o VARIOS quedans relacionados con el mismo proyecto
        // $gettingIdsQdns = Quedan::select('id')->where('proyecto_id', $id_proyecto)->get();

        //? Se recorre $gettingIdsQdns por si no trae uno sino varios registros relacionados
        // foreach ($gettingIdsQdns as $MyQdnIds) {

            //? Se oculta también el o los Quedanfacturas relacionados con cada quedan
            // $ocultarQF = Quedanfactura::select('id')->where('quedan_id', $MyQdnIds->id);
            // $ocultarQF->update(['hiden' => 1,]);


            //*? ------ Un proceso más para ocultar facturas  ------
            //! tras "eliminar" un proyecto y un quedan (donde el proyecto
            //! haya sido añadido), TODAS las facturas
            //! que se hayan "relacionado" con el quedan también se ocultarán.

            //* Obteniendo factura_id  "extrayéndolo" de la tabla Quedanfacturas
                // $MyIDFact = Quedanfactura::select('factura_id')
                // ->where('quedan_id', $MyQdnIds->id)->value('factura_id');

            //? Ocultando la o las Facturas que tienen que ver con (los quedans de) el proyecto a ocultar
            //! es posible no ocultar las facturas sin que haya conflictos, debido a que
            //! las facturas no se muestran una vez son "relacionadas" con un quedan
            //! Auque siempre aparecerían en el view de Facturas
                // $hidingFact = Factura::select('id')->where('id', $MyIDFact);
                // $hidingFact->update(['hiden' => 1,]); // #falla: no elimina las del mismo idquedan, solo una.

            //! # algo más preciso para ocultar, es por medio del added ya que guarda el id de quedan
            //! al que fue "añadida" la factura.
                // $hidingFact = Factura::select('id')->where('added', $MyQdnIds->id);
                // $hidingFact->update(['hiden' => 1,]);
            //? --------------------------------------------------------

        // }

        session()->flash('message', 'Registro eliminado');
    }

    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombre_proyecto = null;
    }

    public function store()
    {
        $this->validate([
		'nombre_proyecto' => 'required',
        ]);

        Proyecto::create([ 
			'nombre_proyecto' => $this-> nombre_proyecto
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Proyecto creado exitosamente');
    }

    public function edit($id)
    {
        $record = Proyecto::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre_proyecto = $record-> nombre_proyecto;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre_proyecto' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Proyecto::find($this->selected_id);
            $record->update([ 
			'nombre_proyecto' => $this-> nombre_proyecto
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Proyecto actualizado exitosamente');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Proyecto::where('id', $id);
            $record->delete();
        }
    }
}
