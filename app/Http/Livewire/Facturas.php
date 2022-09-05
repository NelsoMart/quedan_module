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
    public $selected_id, $keyWord, $fecha_fac, $num_fac, $monto, $proveedor_id, $hiden;

    protected $listeners = ['refreshData' => 'cleanData']; //? by me 

    public $updateMode = false;

    public $ottPlatform = '';
    public $prestaciones, $prestacionSelectedId;

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

    public function render()
    {
        // $selectores = Proveedore::all();
        $selectores = Proveedore::select('id','nombre_proveedor')->orderBy('id', 'desc')
        ->whereNull('proveedores.hiden')->orWhere('proveedores.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
        ->get();
        
		$this->dispatchBrowserEvent('contentChanged');

		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.facturas.view', [
            // 'facturas' => Factura::latest()
            'facturas' => Factura::join('proveedores', 'facturas.proveedor_id', '=', 'proveedores.id')
            ->select('facturas.fecha_fac',
                    'facturas.id',
                    'facturas.num_fac',
					'facturas.monto',
					'facturas.proveedor_id',
					'proveedores.id AS my_ProveId','proveedores.nombre_proveedor',
			) ->orderBy('facturas.id', 'DESC')

						// ->orWhere('fecha_fac', 'LIKE', $keyWord)
            // ->orWhere('num_fac', 'LIKE', $keyWord) //! ### descomentar
            // ->orWhere('monto', 'LIKE', $keyWord)
            // ->orWhere('proveedor_id', 'LIKE', $keyWord)
            ->orWhere('proveedores.nombre_proveedor', 'LIKE', $keyWord)
            ->whereNull('facturas.hiden')->orWhere('facturas.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
            ->paginate(10),
        ], compact('selectores'));
    }

    public function hidenstate($id_factura){ //* sirve para ocultar los registros en lugar de destruirlos

		//* ocultamos la factura en cuestión
		$ocultarF = Factura::find($id_factura);
		$ocultarF -> update(['hiden' => 1,]);

		//* ocultamos también el Quedanfactura relacionado con esta factura
		$ocultarQF = Quedanfactura::select('id')->where('factura_id', $id_factura);
		$ocultarQF -> update(['hiden' => 1,]);

      //*? ------ Un proceso más para actualizar el valor numérico en Quedan -------
        //* obtenemos quedan_id  "extrayéndolo" de la tabla Quedanfacturas
        $MyIDQdn = Quedanfactura::select('quedan_id')
        ->where('factura_id', $id_factura)
        ->value('quedan_id');

        //* obtenemos el monto de la factura a ocultar
        $montofact = Factura::select('monto')
        ->where('id', $id_factura)
        ->value('monto');

        //* decrementamos  la cantidad_num del quedan, tras ocultar la factura que había probocado su incremento
        $record2 = Quedan::find($MyIDQdn); //?  id de quedan obtenido de quedanfacturas
        $record2->decrement('cant_num', $montofact); //? resta el monto en el campo específico de quedan igual al selecionado en delete.
    //? --------------------------------------------------------

		session()->flash('message', 'Registro eliminado');
	}
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		// $this->fecha_fac = null; //todo: para que lo obtenga siempre automacico
		$this->num_fac = null;
		$this->monto = null;
		$this->proveedor_id = null;

		$this->mount();

        
    }



    // public function create(){
    //     $factura = new Factura();
    //     return view('factura.create', compact('factura'));
    // }

    public function store()
    {

        $proveedores = Proveedore::pluck('id', 'nombre_proveedor');

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
			'proveedor_id' => $this-> proveedor_id
        ]);


        // request()->validate(Factura::$rules);

        // $factura = Factura::create($request->all());

        // return redirect()->route('facturas.index')
        //     ->with('success', 'Factura created successfully.');
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Factura creada con éxito');
    }

    public function edit($id)
    {
        $record = Factura::findOrFail($id);

        $this->selected_id = $id; 
		$this->fecha_fac = $record-> fecha_fac;
		$this->num_fac = $record-> num_fac;
		$this->monto = $record-> monto;
		$this->proveedor_id = $record-> proveedor_id;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'fecha_fac' => 'required',
		'num_fac' => 'required',
		'monto' => 'required',
		'proveedor_id' => 'required',
        ]);

        if ($this->selected_id) {
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
}
