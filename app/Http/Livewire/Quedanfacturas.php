<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quedanfactura;
use App\Models\Quedan;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;


class Quedanfacturas extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $factura_id, $quedan_id, $hiden;
    public $updateMode = false;

    public $paramFilter = 'quedans.num_quedan';

    public $filter = "Buscar num Quedan";
	public $searchByDateQ = "Buscar Fecha Qdn";
	public $searchByDateF = "Buscar Fecha Fac";
	public $searchByFuent = "Buscar Fuente";
	public $searchByNumF = "Buscar Num Fact";
	public $searchByProject = "Buscar Proyecto";
	public $searchByProve = "Buscar Proveedor";

	

    public $MyId;

    // public function SearchByNoQdn(){
    //     $this->filter = $this->searchByDate;
    //     $this->paramFilter = 'fecha_emi';
    //  }
    // public function SearchByDateFc(){
    //     $this->filter = $this->searchByDate;
    //     $this->filter = $this->searchByDate;
    //     $this->paramFilter = 'facturas.fecha_fac';
    //  }
    
    public function SearchByDateQd(){
        $this->filter = $this->searchByDateQ;
        $this->paramFilter = 'fecha_emi';
     }
     public function SearchByDateFc(){
        $this->filter = $this->searchByDateF;
        $this->paramFilter = 'facturas.fecha_fac';
     }
     public function SearchByFuent(){
        $this->filter = $this->searchByFuent;
        $this->paramFilter = 'fuentes.nombre_fuente';
     }
     public function SearchByNumF(){
        $this->filter = $this->searchByNumF;
        $this->paramFilter = 'facturas.num_fac';
     }
    //  public function SearchByProject(){
    //     $this->filter = $this->searchByProject;
    //     $this->paramFilter = 'proyectos.nombre_proyecto';
    //  }

     public function SearchByProve(){
        $this->filter = $this->searchByProve;
        $this->paramFilter = 'proveedores.nombre_proveedor';
     }

    public function render() //todo: Render
    {

        $select_quedans = Quedan::join('fuentes', 'quedans.fuente_id', '=', 'fuentes.id')
        ->select('quedans.id','num_quedan','nombre_fuente','fuente_id AS my_fuenteId')
        ->whereNull('quedans.hiden')->orWhere('quedans.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
        ->orderBy('quedans.id', 'desc')->get();
        
        $select_facturas = Factura::join('proveedores', 'facturas.proveedor_id', '=', 'proveedores.id')
				->select('facturas.id','fecha_fac','num_fac','monto','nombre_proveedor','proveedor_id AS my_provId')
                ->whereNull('facturas.hiden')->orWhere('facturas.hiden', '=', 0) //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
				->orderBy('facturas.id', 'desc')->get();

		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.quedanfacturas.view', [
            // 'quedanfacturas' => Quedan::latest()
            'quedanfacturas' => Quedan::join('quedanfacturas', 'quedans.id', '=', 'quedanfacturas.quedan_id')
            ->join('fuentes', 'quedans.fuente_id', '=', 'fuentes.id')
            ->join('facturas', 'quedanfacturas.factura_id', '=', 'facturas.id')
            ->join('proveedores', 'facturas.proveedor_id', '=', 'proveedores.id')
            ->select('quedans.num_quedan',
                'quedanfacturas.id',
                'quedans.id AS my_quedanId',
                'quedans.fecha_emi',
                'quedans.cant_num',
                'quedans.cant_letra',
                'quedans.fuente_id',
                'quedans.proyecto_id',
                'fuentes.nombre_fuente',
                'facturas.id AS my_factId',
                'facturas.num_fac',
                'facturas.fecha_fac',
                'facturas.monto',
                'facturas.proveedor_id',
                // 'proveedores.nombre_proveedor',
                // 'proyectos.id AS my_projtId','proyectos.nombre_proyecto',
                // 'fuentes.id AS my_fuenttId','fuentes.nombre_fuente',
                'proveedores.id AS my_provtId','proveedores.nombre_proveedor',
            ) ->orderBy('quedanfacturas.id', 'DESC')
            // ->orWhere('factura_id', 'LIKE', $keyWord)
            // ->orWhere('quedan_id', 'LIKE', $keyWord)
            ->orWhere($this->paramFilter, 'LIKE', $keyWord)
            ->whereNull('quedanfacturas.hiden')->orWhere('quedanfacturas.hiden', '=', 0) 
            //? debe ir después del orWhere de búsqueda... Esta línea es un 'where or where'
            ->paginate(10),
        ], compact('select_quedans', 'select_facturas'));
    }

    public function hidenstate($id_qdnfac, $quedan_id, $factura_id){ //* sirve para ocultar los registros en lugar de destruirlos

		$ocultar = Quedanfactura::find($id_qdnfac);
		$ocultar -> update(['hiden' => 1,]);

        $montofact = Factura::select('monto') //? obtiene el monto de la factura igual al que se selecciona en el CreateModal
                                ->where('id', $factura_id)
                                ->value('monto');
                // dd($montofact, $quedan_id);

        $record2 = Quedan::find($quedan_id); //?  $quedan_id se obtiene diferente que para el increment porque este método, hedestate, se llama desde un lugar diferente
        $record2->decrement('cant_num', $montofact); //? resta el monto en el campo específico de quedan igual al selecionado en CreateModal.
        
		session()->flash('message', 'Registro eliminado');
	}
    
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->factura_id = null;
		$this->quedan_id = null;
    }

    // public function store($id)
    public function store($quedan_id, $factura_id)
    {


          $id_Fact = Quedanfactura::select('factura_id')//? se obtiene para utilizarlo en la condición que indica si la asocación ya existe o no
                              // ->where('quedan_id', $quedan_id) // esto ya no, porque una factura sólo puede pertenercer a un quedan
                                 ->where('factura_id', $factura_id)
                                 ->value('factura_id');

        // dd('ok');
        // dd($factura_id, $id_Fact);

        $this->validate([
            'factura_id' => 'required',
            'quedan_id' => 'required',
        ]);

        // if ($factura_id == $id_Fact) {
        if ($id_Fact != 0) {
            session()->flash('message1', 'Asociación ya existente');
        } else {
             // foreach($this->MyId as $row){
            // for ($i=0; $i < $id ; $i++) { 
                # code...
                Quedanfactura::create([ //? creando el quedanfactura
                    'factura_id' => $this-> factura_id,
                    'quedan_id' => $this-> quedan_id
                ]);

                // dd($factura_id, $id_Fact);
                // DB::table('quedans')->increment('hiden', 1);
                // DB::table('users')->increment('votes', 1, ['name' => 'John']); //Laravel.com ejemplo 

                $montofact = Factura::select('monto') //? obtiene el monto de la factura igual al que se selecciona en el CreateModal
                                ->where('id', $factura_id)
                                ->value('monto');
                // dd($montofact);

              $record2 = Quedan::find($this->quedan_id); //? sumamos el monto en el campo específico de quedan igual al selecionado en CreateModal
                $record2->increment('cant_num', $montofact);

                session()->flash('message2', 'Factura asociada a Quedan correctamente');
            // }
        // }

        }
        
        // $this->resetInput();
		// $this->emit('closeModal');
		// session()->flash('message', 'Factura asociada a Quedan correctamente');
    }

    public function edit($id)
    {
       
        $record = Quedanfactura::findOrFail($id);

        $this->selected_id = $id; 
		$this->factura_id = $record-> factura_id;
		$this->quedan_id = $record-> quedan_id;
		
        $this->updateMode = true;
        
    }

    public function update($quedan_id, $factura_id)
    { //! no se está usando
        $id_Fact = Quedanfactura::select('factura_id')
        ->where('quedan_id', $quedan_id)
            ->where('factura_id', $factura_id)
            ->value('factura_id');

        $this->validate([
            'factura_id' => 'required',
            'quedan_id' => 'required',
        ]);

        if ($this->selected_id) {

            if ($factura_id == $id_Fact) {
                session()->flash('message1', 'Asociación ya existente');
            } else {

                $record = Quedanfactura::find($this->selected_id);
                $record->update([
                    'factura_id' => $this->factura_id,
                    'quedan_id' => $this->quedan_id
                ]);

                // $record2 = Quedan::find($this->quedan_id);
                // $record2->increment('hiden', 5);

                $this->resetInput();
                $this->updateMode = false;
                session()->flash('message2', 'Asociación actualizada');
            }
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Quedanfactura::where('id', $id);
            $record->delete();
        }
    }
}
