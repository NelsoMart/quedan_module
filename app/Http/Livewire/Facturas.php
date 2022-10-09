<?php

    //todo: this is like a controller

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Factura;
use App\Models\Proveedore; //? by me
use App\Models\Quedanfactura; // para poder ocultar los registros que tengan que ver con factura
use App\Models\Quedan; // para poder decrementar el cantidad numérica en quedan, tras "Eliminar" una factura
use Illuminate\Http\Request;
use Illuminate\Queue\Listener;

class Facturas extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $fecha_fac, $num_fac, $monto, $proveedor_id, $hiden, $added=0; //added debe ser 0 por default

    public $old_monto;


    protected $listeners = [
                             'refreshData' => 'cleanData',
                             'brandSelected' => 'updatingBrandName',
                             'refreshSelect2' => 'cleanSelect2',
                              'oui',
                            ]; //? by me 

    public $updateMode = false;

    public $ottPlatform = '';
    public $prestaciones, $prestacionSelectedId;

    public $filter = "Número de factura";

    public $searchFecha = "Fecha";
    public $searchByProve = "Proveedor";
    public $searchByNumFac = "Número de factura";  
   
    public $paramFilter = 'num_fac';
    public $filterMod = 'like'; 


    // public $endsOnDate;
	public $reminder;

	protected $casts = [
		// 'endsOnDate' => 'date:Y-m-d',
		'reminder' => 'date:Y-m-d',
		'fecha_fac' => 'date:Y-m-d',
	];

    public function mount()
	{
		// $this->reminder = now();
		$this->fecha_fac = now()->format('Y-m-d');
	}

	public function updatedReminder()
    {
        $this->fecha_fac = $this->reminder->addYear();
    }


    public function SearchByProve(){
        $this->filter = $this->searchByProve;
        $this->paramFilter = 'proveedores.nombre_proveedor';
    }

    public function SearchByDate(){
        $this->filter = $this->searchFecha;
        $this->paramFilter = 'fecha_fac';
    }

    public function SearchByNumFac(){
        $this->filter = $this->searchByNumFac;
        $this->paramFilter = 'num_fac';
    }

    public function render()
    {
        // $selectores = Proveedore::all();
        $selectores = Proveedore::select('id','nombre_proveedor')->orderBy('id', 'desc')
        ->whereNull('proveedores.hiden')->orWhere('proveedores.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
        ->get();

        $selectorFac = Factura::select('id','num_fac', 'fecha_fac')->orderBy('id', 'desc')
        ->get();
        
		$this->dispatchBrowserEvent('contentChanged');

		$keyWord = '%'.$this->keyWord .'%';

        if($keyWord != "%%" && $this->paramFilter == "num_fac"){
        $keyWord = $this->keyWord;
        $this->filterMod = "=";
        } else {
        $keyWord = '%' . $this->keyWord . '%';
        $this->filterMod = "like";
        }

        return view('livewire.facturas.view', [
            // 'facturas' => Factura::latest()
            'facturas' => Factura::join('proveedores', 'facturas.proveedor_id', '=', 'proveedores.id')
            ->select('facturas.fecha_fac',
                    'facturas.id',
                    'facturas.num_fac',
					'facturas.monto',
					'facturas.proveedor_id',
					'facturas.added',
					'proveedores.id AS my_ProveId','proveedores.nombre_proveedor',
			) ->orderBy('facturas.id', 'DESC')

		    // ->orWhere('fecha_fac', 'LIKE', $keyWord)
            // ->orWhere('num_fac', 'LIKE', $keyWord) //! ### descomentar
            // ->orWhere('monto', 'LIKE', $keyWord)
            // ->orWhere('proveedor_id', 'LIKE', $keyWord)
            ->orWhere($this->paramFilter, $this->filterMod, $keyWord)
            ->where(function ($query) {
                $query->whereNull('facturas.hiden')
                    ->orWhere('facturas.hiden', '=', 0);
            })
            // ->orWhere($this->paramFilter, 'LIKE', $keyWord)
            // ->whereNull('facturas.hiden')->orWhere('facturas.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
            // ->where(function ($query) {
            //     $query->whereNull('facturas.hiden')
            //           ->orWhere('facturas.hiden', '=', 0);
            // })
            ->paginate(10),
        ], compact('selectores','selectorFac'));
    }

    public function hidenstate($id_factura){ //* sirve para ocultar los registros en lugar de destruirlos

        //advertir cuando se va a eliminar una factura asociada a un quedan.
        // utilizar un alert2

		//* ocultamos la factura en cuestión y reseteamos el idquedan añadido
            $ocultarF = Factura::find($id_factura);
            $ocultarF -> update(['hiden' => 1, 'added'=> 0]);

        //? ocultamos el Quedanfactura relacionado con esta factura. Ojo, si se fuera a ELIMINAR, esto debe ser después de actualizar el monto en Quedan 
            $ocultarQF = Quedanfactura::select('id')->where('factura_id', $id_factura);
            $ocultarQF -> update(['hiden' => 1,]);
        // $eliminarQF = Quedanfactura::select('id')->where('factura_id', $id_factura);
        // $eliminarQF->delete();

      //*? ------ Un proceso más para actualizar el valor numérico en Quedan -------
        //* obtenemos quedan_id  "extrayéndolo" de la tabla Quedanfacturas
        $MyIDQdn = Quedanfactura::select('quedan_id')
        ->where('factura_id', $id_factura)
        ->value('quedan_id');

        //* obtenemos el monto de la factura a ocultar
        $montofact = Factura::select('monto')
        ->where('id', $id_factura)
        ->value('monto');

        //* Descontamos el monto a cantidad_num del quedan tras ocultar la factura que había probocado su incremento
        $record2 = Quedan::find($MyIDQdn); //?  id de quedan obtenido de quedanfacturas
        $record2->decrement('cant_num', $montofact); //? resta el monto en el campo específico de quedan igual al selecionado en delete.
      //? -----------------------------------------------------------------------------

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
		// $this->fecha_fac = null; //todo: para que lo obtenga siempre automatico
		$this->num_fac = null;
		$this->monto = null;
		$this->proveedor_id = null;
		$this->added = 0;

        $this->resetErrorBag();
        $this->emit('closeModal');
		$this->mount();

        
    }


    public function store()
    {

        // $proveedores = Proveedore::pluck('id', 'nombre_proveedor');

        $this->validate([
		'fecha_fac' => 'required',
		'num_fac' => 'required',
		'monto' => 'required',
		'proveedor_id' => 'required',
        ]);

        Factura::create([ 
			'fecha_fac' => $this-> fecha_fac,
			'num_fac' => $this-> num_fac,
			'monto' => $this-> monto,
			'proveedor_id' => $this-> proveedor_id,
			'added' => 0 // added debe ser 0 por defecto
        ]);
        
        // $this->emit('select2Send');
        // $this->reset(['proveedor_id']);
        $this->cleanSelect2();

        // $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Factura creada con éxito');
    }

    public function edit($id)
    { // es llamada al presionar el botón para abrir el modal de edit
        // dd('editar');

        $record = Factura::findOrFail($id);

        // $recor2 = Proveedore::findOrFail($)
        // $recor2 = Factura::join('proveedores', 'facturas.proveedor_id', '=', 'proveedores.id')
        //     ->findOrFail($id);


        $this->selected_id = $id; 
		$this->fecha_fac = $record-> fecha_fac;
		$this->num_fac = $record-> num_fac;
		$this->monto = $record-> monto;
		$this->proveedor_id = $record-> proveedor_id;
        //asignando monto a old_monto
		$this->old_monto = $record-> monto;

        $this->updateMode = true;
        
    }

    public function update()
    { // Se llama al precionar el botón para guardar los cambios de una actualización

        // dd("break down");

        $this->validate([
		'fecha_fac' => 'required',
		'num_fac' => 'required',
		'monto' => 'required',
		'proveedor_id' => 'required',
        ]);

       	// dd('pass');


        if ($this->selected_id) {

            // dd('old monto', $this->old_monto,'new monto', $this->monto);

            //*? ---------- Actualizando monto total del Quedan -----------
                if($this->monto != $this->old_monto){

                    // dd('here!');

                    //* obtenemos quedan_id  "extrayéndolo" de la tabla Quedanfacturas
                    $MyIDQdn = Quedanfactura::select('quedan_id')
                    ->where('factura_id', $this->selected_id)
                    ->value('quedan_id');

                    //* decrementamos la cantidad antigua al quedan respectivo, 
                    $decrement = Quedan::find($MyIDQdn); //?  id de quedan obtenido de quedanfacturas
                    $decrement->decrement('cant_num', $this->old_monto); //? resta el monto en el campo específico de quedan igual al selecionado en delete.

                    //* incrementamos la nueva cantidad al quedan respectivo
                    $decrement = Quedan::find($MyIDQdn); //?  id de quedan obtenido de quedanfacturas
                    $decrement->increment('cant_num', $this->monto); //? resta el monto en el campo específico de quedan igual al selecionado en delete.
                }
            //? -----------------------------------------------------------------------------


			$record = Factura::find($this->selected_id);
            $record->update([ 
			'fecha_fac' => $this-> fecha_fac,
			'num_fac' => $this-> num_fac,
			'monto' => $this-> monto,
			'proveedor_id' => $this-> proveedor_id
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Factura Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Factura::where('id', $id);
            $record->delete();
        }
    }

    public function cleanData() //? by me
    {  
       $saludo = " Pero los campos serán limpiados";

        $this->emit('dataSend', 1, $saludo); // enviamos un parametro 1, solo para ver cómo funcionan los parámetros
        $this->reset(['fecha_fac', 'monto', 'num_fac', 'proveedor_id']);
    }

    public function cleanSelect2() //? para limpiar los select2
    {  
        $this->emit('select2Send');
        $this->reset(['proveedor_id']);
        $this->resetInput();
    }
}
