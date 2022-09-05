<?php

namespace App\Http\Livewire;

use App\Models\Fuente;
use App\Models\Proyecto;
use App\Models\Proveedore;
use App\Models\Quedanfactura; // para poder ocultar los registros que tengan que ver con quedan
use App\Models\Factura;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quedan;
use PhpParser\Node\Expr\Cast\Double;
use Illuminate\Support\Carbon;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\PDF;
use GuzzleHttp\Promise\Is;
use GuzzleHttp\Psr7\Request;
use Hamcrest\Core\IsNull;
use Mockery\Undefined;

class Quedans extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';
	public $selected_id, $keyWord, $num_quedan, $fecha_emi, $cant_num=0, $cant_letra='*SIN ASIGNAR*', $fuente_id, $proyecto_id, $proveedor_id, $hiden;
	public $updateMode = false;


	public $quedan_id, $ArrayCheckedF = [], $ArrayUncheckedF = []; // para insertar en Quedanfacturas


	public $select_facturas;

	// public $vendor_permissions = [1,2,3,4], $assigned_vendor_permissions = [1,3];

	public $selected_date;
	public $monto_fact = "monto";
	protected $listeners = ["selectDate" => 'getSelectedDate'];

	public $selected_monto;
	public $getNumQuedan;
	public $filter = "Buscar num Quedan";
	public $searchByDate = "Buscar Fecha";
	public $searchByFuent = "Buscar Fuente";
	public $searchByProject = "Buscar Proyecto";
	public $searchByProve = "Buscar Proveedor";
	//
	public $paramFilter = 'num_quedan';

	// public $endsOnDate;
	public $reminder;

	// public $pdf;

	protected $casts = [
		// 'endsOnDate' => 'date:Y-m-d',
		'reminder' => 'date:Y-m-d',
		'fecha_emi' => 'date:Y-m-d',
	];

	public function SearchByDate(){
       $this->filter = $this->searchByDate;
	   $this->paramFilter = 'fecha_emi';
	}
	public function SearchByFuent(){
       $this->filter = $this->searchByFuent;
	   $this->paramFilter = 'fuentes.nombre_fuente';
	}
	public function SearchByProject(){
       $this->filter = $this->searchByProject;
	   $this->paramFilter = 'proyectos.nombre_proyecto';
	}
	public function SearchByProve(){
       $this->filter = $this->searchByProve;
	   $this->paramFilter = 'proveedores.nombre_proveedor';
	}


	public function mount()
	{
		// $this->reminder = now();
		$this->fecha_emi = now()->format('Y-m-d');
		// $this->fecha_emi = Carbon::createFromFormat('d-m-Y', $this->reminder)->addYear()->toDateString();

		// dd($this->fecha_emi);
		// $this->endsOnDate = now()->addYear();
	}

	public function updatedReminder(){
      $this->fecha_emi = $this->reminder->addYear();
    }

	// variables para Conversor de Números a Letras
	public $desc_moneda = "DÓLARES", $sep = "CON", $desc_decimal = "CENTAVOS";
	public $Word_ofNumber;



	public function render() //todo Render
	{
		//!para los selectores
			// $select_facturas = Factura::all();
		    // // $select_facturas = Factura::select('id','fecha_fac','num_fac','monto','proveedor_id')->orderBy('id', 'desc')->get();

		    // $select_facturas = Factura::select('id','fecha_fac','num_fac','monto','proveedor_id')
			// // ->where('proveedor_id', '=', $this->proveedor_id)
			// ->orderBy('id', 'desc')->get();

			// $select_facturas = Factura::join('proveedores', 'facturas.proveedor_id', '=', 'proveedores.id')
			// 	->select('facturas.id','fecha_fac','num_fac','monto','nombre_proveedor','proveedor_id AS my_provId')
			// 	->orderBy('num_fac', 'desc')->get();

			// $select_fuentes = Fuente::all();
			$select_fuentes = Fuente::select('id','nombre_fuente')->orderBy('id', 'desc')->get();

			// $select_proyectos = Proyecto::all();
			$select_proyectos = Proyecto::select('id','nombre_proyecto')->orderBy('id', 'desc')->get();

			// $select_proyectos = Proyecto::all();
			$select_proveedores = Proveedore::select('id','nombre_proveedor')->orderBy('id', 'desc')->get();

		$this->dispatchBrowserEvent('contentChanged');

		$keyWord = '%' . $this->keyWord . '%';

			// dd($keyWord);

		// if($keyWord != "%%")
		// 	{
		// 		return view('livewire.quedans.view', [
		// 			'quedans' => Quedan::latest()
		// 			->orWhere($this->paramFilter, 'LIKE', $keyWord)
		// 			->where('quedans.hiden', '=', 1)
		// 				->paginate(15),
		// 		],compact('select_fuentes', 'select_proyectos'));
		// 	} else {
				return view('livewire.quedans.view', [
					// 'quedans' => Quedan::latest()
					// 'quedans' => Quedan::join('proyectos', 'quedans.proyecto_id', '=', 'proyectos.id')->orderBy('quedans.fecha_emi', 'desc')
					'quedans' => Quedan::join('proyectos', 'quedans.proyecto_id', '=', 'proyectos.id')
						->join('fuentes', 'quedans.fuente_id', '=', 'fuentes.id')
						->join('proveedores', 'quedans.proveedor_id', '=', 'proveedores.id')
						->select('quedans.num_quedan',
							'quedans.id',
							'quedans.fecha_emi',
							'quedans.cant_num',
							'quedans.cant_letra',
							'quedans.fuente_id',
							'quedans.proyecto_id', // ####
							'proyectos.id AS my_projtId','proyectos.nombre_proyecto',
							'fuentes.id AS my_fuenttId','fuentes.nombre_fuente',
							'proveedores.id AS my_proveeId','proveedores.nombre_proveedor',)
						->orderBy('quedans.id', 'DESC')
						->orWhere($this->paramFilter, 'LIKE', $keyWord)
						->whereNull('quedans.hiden')->orWhere('quedans.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
						// // ->orWhere('fecha_emi', 'LIKE', $keyWord)
					->paginate(15),
				], compact('select_fuentes', 'select_proyectos', 'select_proveedores'));
			// }
		
	} //todo: fin render


	public function hidenstate($id_quedan){ //* sirve para ocultar los registros en lugar de destruirlos

		//* ocultamos el quedan
		$ocultarQ = Quedan::find($id_quedan);
		$ocultarQ -> update(['hiden' => 1,]);

		//* ocultamos todos los quedanfacturas relacionados con este quedan
		$ocultarQF = Quedanfactura::select('id')->where('quedan_id', $id_quedan);
		$ocultarQF -> update(['hiden' => 1,]);

		session()->flash('message', 'Registro eliminado');
	}


	public function getSelectedMonto($miId_monto)
	{ //* función para obtener el monto de la factura

		// $this->cant_num = Factura::select('monto')
		// ->where('id', $miId_monto)
		// ->value('monto');
		// return $this->cant_num;
	}

	public function functionNumQd()
	{ //* función para obtener el número de quedan
		$this->num_quedan = Quedan::select('num_quedan')->orderBy('id', 'desc')->value('num_quedan');
		return $this->num_quedan += 1;
	}

	public function Get_numberWords()
	{ //* función para convertir números en letras
		$arr = explode(".", $this->cant_num);
		$entero = $arr[0];
		if (isset($arr[1])) {
			$decimos  = strlen($arr[1]) == 1 ? $arr[1] . '0' : $arr[1];
		}
		$fmt = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
		if (is_array($arr)) {
			$this->Word_ofNumber = ($arr[0] >= 1000000) ? "{$fmt->format($entero)} de $this->desc_moneda" : "{$fmt->format($entero)} $this->desc_moneda";
			if (isset($decimos) && $decimos > 0) {
				$this->Word_ofNumber .= " $this->sep  {$fmt->format($decimos)} $this->desc_decimal";
			}
		}
		// return $this->cant_letra;
		$this->cant_letra = strtoupper($this->Word_ofNumber);
		return $this->cant_letra;
	}



	public function hydrate() //byme
	{
		$this->emit('select2');
	}


	public function cancel()
	{
		$this->resetInput();
		$this->updateMode = false;
	}

	private function resetInput()
	{
		$this->num_quedan = null;
		$this->fecha_emi = null;
		$this->cant_num = null;
		$this->cant_letra = null;
		$this->fuente_id = null;
		$this->proyecto_id = null;
		$this->select_facturas = null;

	}

	public function storeQF2(){ //! ############

		
		$this->validate([
			// 'factura_id' => 'required',
			'quedan_id' => 'required',
			]);
			
			// dd([$this->ArrayCheckedF]);


			foreach ($this->ArrayCheckedF as $MyFactIds => $idF) {

				//? $idF get a boolean value
				//? $MyFactIds get id

				// $retVal = (condition) ? a : b ;

				// $factura_id = strval($MyFactIds);
				$factura_id = $MyFactIds;

			// dd([$factura_id]);

				if($idF == true){
					// conjunto de acciones
				    // dd($factura_id, 'es verdadero');
					//*insert
				Quedanfactura::create([ //? creando el quedanfactura
					'factura_id' => $factura_id,
					'quedan_id' => $this->quedan_id
		      	]);
				}else if($idF == false)  {
					// conjunto de acciones
					// dd($factura_id, 'es falso');

					//*delete
				  //* ocultamos todos los quedanfacturas relacionados con este quedan
				 	$ocultarQF = Quedanfactura::select('id')->where('quedan_id', $this->quedan_id);
					$ocultarQF -> update(['hiden' => 1,]);

					session()->flash('message', 'Registro eliminado');
				}
				

			// $factura_id = $MyFactIds;

		// Quedanfactura::create([ //? creando el quedanfactura
		// 	'factura_id' => $factura_id,
		// 	'quedan_id' => $this-> quedan_id
		// 	]);

		}
	}

	public function storeQF()
	{
		foreach ($this->ArrayCheckedF as $MyFactIds => $idF) {

		$factura_id = $MyFactIds;

		//? Consultando el Id de factura para utilizarlo en la condición que indica si la asocación ya existe
		$id_Fact = Quedanfactura::select('factura_id')
		// ->where('quedan_id', $quedan_id) // esto ya no, porque una factura sólo puede pertenercer a un quedan
		   ->where('factura_id', $factura_id)
		   ->whereNull('quedanfacturas.hiden')->orWhere('quedanfacturas.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
		   ->value('factura_id');

		// dd('ok');
		// dd($factura_id, $id_Fact);

		

		$this->validate([
		// 'factura_id' => 'required',
		'quedan_id' => 'required',
		]);

		

		if ($factura_id == $id_Fact) { // porque si marca y a la vez desmarca una factura, si no se comprueba la existencia del registro, podría decrementar incluso a partir de $0

		// if ($id_Fact != 0) {
			if($idF == false) { //*delete
				//* ocultamos todos los quedanfacturas relacionados con este quedan
				$ocultarQF = Quedanfactura::select('id')->where('quedan_id', $this->quedan_id);
				$ocultarQF -> update(['hiden' => 1,]);

				//? Obteniendo el monto de la factura igual al que se selecciona en el AssocisteModal, independientemente de si es marcado o desmarcado
				$montofact = Factura::select('monto') 
				->where('id', $factura_id)
				->value('monto');
				// dd($montofact);

				//? Restando el monto en el campo específico de quedan igual al selecionado en AssocisteModal
				$record2 = Quedan::find($this->quedan_id); 
				$record2->decrement('cant_num', $montofact);

				//? Actualizamos el estado added de la factura a 1 para indicar que ya fue añadida
				$updateAddedfactState = Factura::select('id')->where('id', $factura_id);
				$updateAddedfactState -> update(['added' => 1,]);

				// session()->flash('message3', 'Facturas Desasociadas');
				
			}

		    session()->flash('message3', 'Asociación ya existente');

		} else if($idF == true){

			// dd($idF);

		Quedanfactura::create([ //? creando el quedanfactura
		'factura_id' => $factura_id,
		'quedan_id' => $this->quedan_id
		]);



		// dd($factura_id, $id_Fact);
		// DB::table('quedans')->increment('hiden', 1);
		// DB::table('users')->increment('votes', 1, ['name' => 'John']); //Laravel.com ejemplo 

		//? Obteniendo el monto de la factura igual al que se selecciona en el AssocisteModal, independientemente de si es marcado o desmarcado
		$montofact = Factura::select('monto') 
				->where('id', $factura_id)
				->value('monto');
		// dd($montofact);

		//? Sumando el monto en el campo específico de quedan igual al selecionado en AssocisteModal
		$record2 = Quedan::find($this->quedan_id); 
		$record2->increment('cant_num', $montofact);

		//? Actualizamos el estado added de la factura a 1 para indicar que ya fue añadida
		$updateAddedfactState = Factura::select('id')->where('id', $factura_id);
		$updateAddedfactState -> update(['added' => 1,]);
         
		session()->flash('message4', 'Facturas asociadas correctamente');

		} 

		// $this->resetInput();
		// $this->emit('closeModal');
		// session()->flash('message', 'Factura asociada a Quedan correctamente');
	  }
	}

	public function store()
	{
		$this->validate([
			'num_quedan' => 'required',
			'fecha_emi' => 'required',
			'cant_num' => 'required',
			'cant_letra' => 'required',
			'fuente_id' => 'required|min:1|',
			'proyecto_id' => 'required|min:1|',
			'proveedor_id' => 'required|min:1|',
		]);

		Quedan::create([
			'num_quedan' => $this->num_quedan,
			'fecha_emi' => $this->fecha_emi,
			'cant_num' => $this->cant_num,
			'cant_letra' => $this->cant_letra,
			'fuente_id' => $this->fuente_id,
			'proyecto_id' => $this->proyecto_id,
			'proveedor_id' => $this->proveedor_id
		]);

		$this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Quedan creado satisfactoriamente.');
	}

	 //! ########
	public function editQF($quedan_id, $proveedor_id) 
	{

		// $this->dispatchBrowserEvent('contentChanged');
		
		// $this->select_facturas = Factura::all();

		// $this->select_facturas = Factura::select('id','fecha_fac','num_fac','monto','proveedor_id')
		// 	->where('proveedor_id', '=', $proveedor_id)
		// 	->orderBy('id', 'desc')->get();

		// return view('livewire.quedans.view', [
			$this->select_facturas = Factura::join('proveedores', 'facturas.proveedor_id', '=', 'proveedores.id')
				->select('facturas.id','fecha_fac','num_fac','monto','nombre_proveedor','proveedor_id AS my_provId')
				->where('proveedor_id', '=', $proveedor_id)
				//? mejor que muestre todas las facturas, no solo las que no han sido añadidas.
				// ->whereNull('facturas.added')->orWhere('facturas.added', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
				->orderBy('num_fac', 'desc')->get();
		// ]);

		// dd($this->select_facturas);



		$this->quedan_id = $quedan_id;
		$this->proveedor_id = $proveedor_id;
	}

	public function edit($id, $proveedor_id)
	{ //? se llamda al presionar el botón Editar, en el action del View 
	  //? cargará los campos de updateModal con los valores que se obtengan 
		//? de la búsqueda por id seleccionado

		//? Hará una consulta para obtener la lista de proveedores asociadas con el quedan
		$this->select_facturas = Factura::join('quedanfacturas', 'facturas.id', '=', 'quedanfacturas.factura_id')
				->select('facturas.id AS MyidF','facturas.fecha_fac','facturas.num_fac','facturas.monto')
				->where('quedanfacturas.quedan_id', '=', $id)
				->where('facturas.proveedor_id', '=', $proveedor_id)
				->orderBy('num_fac', 'desc')->get();

		$record = Quedan::findOrFail($id); //? guardará en $record el array devuelto tras la búsqueda

		$this->selected_id = $id;
		$this->num_quedan = $record->num_quedan; // aquí como en los demás, recorrerá el array $record hasta la posición num_quedan para asignarlo
		$this->fecha_emi = $record->fecha_emi;
		$this->cant_num = $record->cant_num;
		$this->cant_letra = $record->cant_letra;
		$this->fuente_id = $record->fuente_id;
		$this->proyecto_id = $record->proyecto_id;
		$this->proveedor_id = $record->proveedor_id;

		$this->updateMode = true;
	}

	public function update()
	{ // Es llamado al presionar el botón guardar en updateModal

		//? validará que haya valor asignado por campo
		$this->validate([
			'num_quedan' => 'required',
			'fecha_emi' => 'required',
			'cant_num' => 'required',
			'cant_letra' => 'required',
			'fuente_id' => 'required',
			'proyecto_id' => 'required',
			'proveedor_id' => 'required',
		]);

		//? selected_id será igual al id de quedan porque se asignará al utilizar al método edit($id)
		if ($this->selected_id) {
			$record = Quedan::find($this->selected_id);
			$record->update([ //? actualizará la tabla quedan con los valores asignados desde UpdateModal
				'num_quedan' => $this->num_quedan,
				'fecha_emi' => $this->fecha_emi,
				'cant_num' => $this->cant_num,
				'cant_letra' => $this->cant_letra,
				'fuente_id' => $this->fuente_id,
				'proyecto_id' => $this->proyecto_id,
				'proveedor_id' => $this->proveedor_id
			]);

			$this->resetInput();
			$this->updateMode = false;
			session()->flash('message', 'Quedan actualizado con éxito');
		}
	}

	public function destroy($id)
	{
		if ($id) {
			$record = Quedan::where('id', $id);
			$record->delete();
		}
	}
}
