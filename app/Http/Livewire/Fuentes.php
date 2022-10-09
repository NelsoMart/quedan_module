<?php

namespace App\Http\Livewire;

use App\Models\Factura;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Fuente;
use App\Models\Quedan;
use App\Models\Quedanfactura;

class Fuentes extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre_fuente, $hiden;
    public $old_nomFuente;

    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.fuentes.view', [
            'fuentes' => Fuente::latest()
						->orWhere('nombre_fuente', 'LIKE', $keyWord)
                        ->whereNull('fuentes.hiden')->orWhere('fuentes.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'

						->paginate(10),
        ]);
    }


    public function hidenstate($id_fuente)
    { //* sirve para ocultar los registros en lugar de destruirlos

        //* ocultamos la fuente 
        $ocultarP = Fuente::find($id_fuente);
        $ocultarP->update(['hiden' => 1,]);

        //* también ocultamos el o los quedans relacionadas con esta fuente
        // $ocultarF = Quedan::select('id')->where('fuente_id', $id_fuente);
        // $ocultarF->update(['hiden' => 1,]);

        //! ################
        //! un nuevo enfoque:  OCULTAR LA O LAS FACTURAS RELACIONADAS; PRESERVANDO SU ESTADO ADDED

        //? Se hace una búsqueda que retornará uno o VARIOS quedans relacionados con la misma fuente
        // $gettingIdsQdns = Quedan::select('id')->where('fuente_id', $id_fuente)->get();

        //? Se recorre $gettingIdsQdns por si no trae uno sino varios registros relacionados
        // foreach ($gettingIdsQdns as $MyQdnIds) {

            //? Se oculta también el o los Quedanfacturas relacionados al o a los quedans
            // $ocultarQF = Quedanfactura::select('id')->where('quedan_id', $MyQdnIds->id);
            // $ocultarQF->update(['hiden' => 1,]);


            //*? ------ Un proceso más para ocultar facturas  ------
              //! tras "eliminar" una fuente, cada quedan donde la fuente
              //! haya sido añadida deberá ocultarse, juntamente con TODAS las facturas
              //! que se hayan "relacionado" con el quedan.

            //? Obteniendo factura_id  "extrayéndolo" de la tabla Quedanfacturas
                // $MyIDFact = Quedanfactura::select('factura_id')
                // ->where('quedan_id', $MyQdnIds->id)->value('factura_id');

            //? Ocultando la o las Facturas que tienen que ver con (los quedans de) la fuente a ocultar
              //! es posible no ocultar las facturas sin que haya conflictos, debido a que
              //! las facturas no se muestran una vez son "relacionadas" con un quedan.
                // $hidingFact = Factura::select('id')->where('id', $MyIDFact);
                // $hidingFact->update(['hiden' => 1,]);

              //! # algo más preciso para ocultar facturas es por medio del added ya que guarda el id de quedan
              //! al que fue "añadida" la factura.
                //   $hidingFact = Factura::select('id')->where('added', $MyQdnIds->id);
                //   $hidingFact->update(['hiden' => 1,]);
            //? --------------------------------------------------------

        // }

        session()->flash('message', 'Registro eliminado');
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
        // $this->emit('closeModal');
    }
	
    private function resetInput()
    {		
		$this->nombre_fuente = null;
        $this->emit('closeModal');
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate([
		'nombre_fuente' => ['required', 'unique:fuentes']
          ], ['unique'=>'Esta Fuente ya está registrada']);

        Fuente::create([ 
			'nombre_fuente' => $this-> nombre_fuente
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Fuente creada exitosamente.');
    }

    public function edit($id)
    {
        $record = Fuente::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre_fuente = $record-> nombre_fuente;
		$this->old_nomFuente = $record-> nombre_fuente;
		
        $this->updateMode = true;
    }

    public function update()
    {

        if ($this->old_nomFuente == $this->nombre_fuente) { //* si se intenta guardar sin hacer cambios en el nombre de origen
            $this->emit('closeModal');
        }

        if ($this->old_nomFuente != $this->nombre_fuente) {

            $this->validate([
                'nombre_fuente' => ['required', 'unique:fuentes']
            ], ['unique' => 'Esta Fuente ya está registrada']);

            if ($this->selected_id) {
                $record = Fuente::find($this->selected_id);
                $record->update([
                    'nombre_fuente' => $this->nombre_fuente
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
            $record = Fuente::where('id', $id);
            $record->delete();
        }
    }
}
