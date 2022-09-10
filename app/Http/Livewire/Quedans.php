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
	// public $quedan_id, $ArrayCheckedF = ['id'=>0, 'added'=>''], $ArrayUncheckedF = []; // para insertar en Quedanfacturas


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

	public function storeQF(){ //StoreDelete_QF //! ############

		
		$this->validate([
			// 'factura_id' => 'required',
			'quedan_id' => 'required',
			]);
			
			// dd([$this->ArrayCheckedF]);


			foreach ($this->ArrayCheckedF as $MyFactIds => $checkState) {

				//? $checkState get a boolean value
				//? $MyFactIds get id
				    // dd($MyFactIds, $checkState);

		    	// $retVal = (condition) ? a : b ;
		    	// $factura_id = strval($MyFactIds); //* strval convierte a string cualquier valor
			       $factura_id = $MyFactIds;
				// dd([$factura_id]);

				//? Consultando el Id de factura para utilizarlo en la condición que indica si la asocación ya existe
				// $id_Fact = Quedanfactura::select('factura_id',)
				// //->where('quedan_id', $quedan_id) //* esto ya no, porque una factura sólo puede pertenercer a un quedan
				//   ->where('factura_id', $factura_id)
				//   ->whereNull('quedanfacturas.hiden')->orWhere('quedanfacturas.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where' // se ha comentado debido a queahora se consultará también por los registros desasociados, para volverlos a asociar,sin tener que duplicar registros
				//   ->value('factura_id');

				$Myfact = Quedanfactura::join('facturas', 'quedanfacturas.factura_id', '=', 'facturas.id')
				            ->select('quedanfacturas.hiden','quedanfacturas.factura_id','facturas.added', 'facturas.monto')
						  //->where('quedan_id', $quedan_id) //* esto ya no, porque una factura sólo puede pertenecer a un quedan
							->where('quedanfacturas.factura_id', $factura_id) 
							->get();
			// $factId_and_added = $Myfact->pluck('added','factura_id');


			// dd([$Myfact]); // ¿y cuando viene vacío? es porque no existe el registro de la factura en 'quedanfacturas
			// dd([$factId_and_added]); //vacío significa que no existe el registro de la factura

			switch ($checkState) { //todo: SWITCH: '$checkState' puede traer 0||1||true||false

				case 'true': //todo: ## insert ## (con comillas simples, porque si no, se confunde con el estado 1)
					# dd('¿verdadero?', $checkState);
					if ($Myfact == '[]') {
						//? Si la factura no está insertada, será un registro NUEVO en quedanfacturas
						# dd('No hay factura en quedanfacturas para este id', $MyFactIds);
						//? creando el registro en quedanfactura
							Quedanfactura::create([ 
								'factura_id' => $factura_id,
								'quedan_id' => $this->quedan_id
							]);
						//? Actualizamos el estado added de la factura a 1 para indicar que ya fue asociada
							$updateAddedfactState = Factura::select('id')->where('id', $factura_id);
							$updateAddedfactState -> update(['added' => 1,]);

						//? Obteniendo el monto de la factura igual a la factura que se pretende insertar
							$montofact = Factura::select('monto') 
							->where('id', $factura_id)->value('monto');
							# dd($montofact);
                        //? Sumando el monto de la factura en el campo específico de quedan igual al selecionado en AssocisteModal
							$sumvalue = Quedan::find($this->quedan_id); 
							$sumvalue->increment('cant_num', $montofact);
						    	
					} else {
						foreach ($Myfact as $MyFactura) {
							# dd($MyFactura->factura_id,$MyFactura->hiden,$MyFactura->added,$MyFactura->monto);
							if ($factura_id == $MyFactura->factura_id) {
								# dd('factura ya existe' , $id_Fact);
								//? Si la factura YA está insertada, podría ser que:
								// if ($MyFactura->added == 1 && $MyFactura->hiden !=1) {
								if ($MyFactura->hiden != 1) { #hiden de 'quedanfacturas'. added no va porque es más seguro sólo con hiden 

									//? ** La factura esté visible (hiden= 0||null). Entonces NO se ejecuta ningua acción
									# dd('factura ya existe y está visible.', 'facturas added:', $MyFactura->added, 'quedanfacturas hiden:', $MyFactura->hiden);
									return null;

								} else { // hiden=1, implica registro oculto.

									//? ** La factura esté oculta (fue eliminada, hiden=1). En este caso se actualizarán los estados 'hiden' a 0, 'added' a 1 y 'cant_num' con val de monto.
									    # dd('factura ya existe, pero está oculta.', 'facturas added:', $MyFactura->added, 'quedanfacturas hiden:', $MyFactura->hiden);

									//? Se actualiza el estado de 'hiden' a 0 en quedanfacturas de la factura chequeada
									    $recuperarQF = Quedanfactura::select('id')->where('factura_id', $factura_id);
										$recuperarQF -> update(['hiden' => 0,]);

									//? Se actualiza el estado added de la factura a 1 para indicar que ya fue asociada
										$updateAddedfactState = Factura::select('id')->where('id', $factura_id);
										$updateAddedfactState -> update(['added' => 1,]);

									//? Se obtiene el monto de la factura igual a la factura chequeada
										$montofact = Factura::select('monto') 
										->where('id', $factura_id)->value('monto');
										# dd($montofact);
									//? Se suma el monto de la factura chequeada, en el campo específico de quedan 'cant_num'
										$TotalValue = Quedan::find($this->quedan_id); 
										$TotalValue->increment('cant_num', $montofact);
								}

							} else {
								return null;
							}
						}
				    }
				break;

				case false: //todo: ## delete ## (false, sin comillas simples, de lo contrario not working)
					# code...
					// dd('¿falso?', $checkState);
					if ($Myfact == '[]') {
						//? Si la factura no está insertada, Entones no hay nada que eliminar 
						# dd('Eliminar es innecesario, pues No hay factura en quedanfacturas para este id', $MyFactIds);
						return null;
					} else {
						foreach ($Myfact as $MyFactura) {
							if ($factura_id == $MyFactura->factura_id) {
								//? Si la factura YA está insertada, podría ser que:
								if ($MyFactura->hiden != 1) { #hiden de 'quedanfacturas'.

								 //? ** La factura esté visible (hiden= 0||null). En este caso se actualizarán los estados: 'hiden' a 1 (invisible), 'added' a 0 (Sin añadir) y 'cant_num' con decrement (restar).
								   # dd('Eliminar factura que existe y está visible.', 'facturas added:', $MyFactura->added, 'quedanfacturas hiden:', $MyFactura->hiden);
								 //! Entonces, y sólo entonces, delete (ocultar)...

									//? Se actualiza el estado de 'hiden' a 1 en quedanfacturas de la factura chequeada
									$ocultarQF = Quedanfactura::select('id')->where('factura_id', $factura_id);
									$ocultarQF -> update(['hiden' => 1,]);

								//? Se actualiza el estado added de la factura a 0, para indicar que ya NO está asociada
									$updateAddedfactState = Factura::select('id')->where('id', $factura_id);
									$updateAddedfactState -> update(['added' => 0,
									]);

								//? Se obtiene el monto de la factura igual a la factura chequeada
									$montofact = Factura::select('monto') 
									->where('id', $factura_id)->value('monto');
									// dd($montofact);

								//? Se resta el monto de la factura chequeada, en el campo específico de quedan 'cant_num'
									$TotalValue = Quedan::find($this->quedan_id); 
									$TotalValue->decrement('cant_num', $montofact);
									 
								} else { // hiden=1, implica ocultar.
									//? ** La factura esté oculta (hiden=1 y added=0||null). Entonces no se ejecuta ningua acción de elimiación
									// dd('No eliminar, porque aunque factura existe, ya está oculta.', 'facturas added:', $MyFactura->added, 'quedanfacturas hiden:', $MyFactura->hiden);
									return null;
								  }
							} else { return null;}
						}
					}
				break;

				case 1: // Es como el default, pero lo dejamos para efectos de prueba
					# code...
					//  dd('trae 1?', $checkState);  // ;)
					break;

				default:
					# code...
					break;
			}
		}
		session()->flash('message4', 'Proceso realizado');

	}

	public function storeQF2()
	{
		// dd([$this->ArrayCheckedF]);
		// dd([$this->ArrayUncheckedF]);

		foreach ($this->ArrayCheckedF as $MyFactIds => $checkState) {

		$factura_id = $MyFactIds;

		// dd($MyFactIds, $checkState);

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
			if($checkState == false) { //*delete

				// dd($checkState);

				//? ocultando todos los quedanfacturas relacionados con este quedan
				// $ocultarQF = Quedanfactura::select('id')->where('quedan_id', $this->quedan_id);
				// $ocultarQF -> update(['hiden' => 1,]);

				//? Obteniendo el monto de la factura igual a la factura que se pretende asociar o desasociar
				$montofact = Factura::select('monto') 
				->where('id', $factura_id)
				->value('monto');

				// dd($montofact);

				//? Restando el monto al valor total del quedan igual  al monto selecionado desde AssociateModal
				$record2 = Quedan::find($this->quedan_id);
				$record2->decrement('cant_num', $montofact);

				//? Actualizamos el estado added de la Factura, a 0, para indicar que fue desasociada
				$updateAddedfactState = Factura::select('id')->where('id', $factura_id);
				$updateAddedfactState -> update(['added' => 0,]);

				// session()->flash('message3', 'Facturas Desasociadas');
				
			}

		    session()->flash('message3', 'Asociación ya existente');

		} 
		
		if ($factura_id != $id_Fact) {

		if($checkState == true){

		// dd($checkState);

		//? creando el quedanfactura
		Quedanfactura::create([ 
		'factura_id' => $factura_id,
		'quedan_id' => $this->quedan_id
		]);

		// dd($factura_id, $id_Fact);
		// DB::table('quedans')->increment('hiden', 1);
		// DB::table('users')->increment('votes', 1, ['name' => 'John']); //Laravel.com ejemplo 

		//? Obteniendo el monto de la factura igual al que se marque en el AssocisteModal, que servirá para poder pasar el valor posteriormente en la suma del valor total del quedan
		$montofact = Factura::select('monto') 
				->where('id', $factura_id)
				->value('monto');
		// dd($montofact);

		//? Sumando el monto de la factura en el campo específico de quedan igual al selecionado en AssocisteModal
		$sumvalue = Quedan::find($this->quedan_id); 
		$sumvalue->increment('cant_num', $montofact);

		//? Actualizamos el estado added de la factura a 1 para indicar que ya fue asociada
		$updateAddedfactState = Factura::select('id')->where('id', $factura_id);
		$updateAddedfactState -> update(['added' => 1,]);
         
		session()->flash('message4', 'Facturas asociadas correctamente');

		} 

		// $this->resetInput();
		// $this->emit('closeModal');
		// session()->flash('message', 'Factura asociada a Quedan correctamente');
	  }
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
				->select('facturas.id','fecha_fac','num_fac','monto','nombre_proveedor','proveedor_id AS my_provId', 'added')
				->where('proveedor_id', '=', $proveedor_id)
				//? mejor que muestre todas las facturas, no solo las que no han sido añadidas.
				// ->whereNull('facturas.added')->orWhere('facturas.added', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
				->orderBy('num_fac', 'desc')->get();

			//* --------------------------- Precargando ArrayCheckedF --------------------
				//? Bajo esta forma se recorre el array recuperando TODOS los ids con sus respectivos addeds, y no se tiene que hacer otra consulta; pero el array se vuelve gigantesco;
				// $this->ArrayCheckedF = $this->select_facturas->pluck('added','id');

				//? Bajo esta forma se crea un array que obtiene SÓLO los ids con added=1 reduciendo considerablemente el tamaño del array; pero esto implica hacer otra consulta a la base de datos.
				$Misfacturas = Factura::select('id','added')
				->where('added', '=', 1)->get();
				$this->ArrayCheckedF = $Misfacturas->pluck('added','id');
			//* --------------------------------------------------------------------------


				// foreach ($this->ArrayCheckedF as $item){
				// 	$this->selectedUsers[$item->id] = $item->id . '';
	            //  }    

				// $this->ArrayCheckedF = Factura::select('id','added')
				// 	->where('added', '=', 1)->get();
				
					// dd([$this->ArrayCheckedF]);

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