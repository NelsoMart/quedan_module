<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Quedan;
use App\Models\Quedanfactura;

// use PDF;
use Barryvdh\DomPDF\Facade\PDF;
// use Barryvdh\DomPDF\PDF;


class PdfController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    //* variables para Conversor de Números a Letras
        public $desc_moneda = "DÓLARES", $sep = "CON", $desc_decimal = "CENTAVOS";
        public $Word_ofNumber;
        // public $cant_letra;

    public function index($id, $cant_num) //todo: INDEX
    {

     //? ---------------------- convert num to word ---------------------
     $arr = explode(".", $cant_num);
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
     // $this->cant_letra = strtoupper($this->Word_ofNumber);
     $NumConverted = strtoupper($this->Word_ofNumber);
  //? ------------------------- --------------------------------------


        // $data1 = Quedan::find($id);
        // $data2 = Factura::find($id);

        $getQuedan = Quedan::join('fuentes', 'quedans.fuente_id', '=', 'fuentes.id')
            ->join('proyectos', 'quedans.proyecto_id', '=', 'proyectos.id')
            ->join('proveedores', 'quedans.proveedor_id', '=', 'proveedores.id')
            ->where('quedans.id', '=', $id)  
            ->orderBy('num_quedan', 'desc')->first(); //? Es first() debido a que sólo retorna un registro.

        $getFactura = QuedanFactura::join('facturas', 'quedanfacturas.factura_id', '=', 'facturas.id')
            ->where('quedanfacturas.quedan_id', '=', $id)
            ->whereNull('quedanfacturas.hiden')->orWhere('quedanfacturas.hiden', '=', 0)
            ->orderBy('quedanfacturas.factura_id', 'asc')
            ->get(); //? Es get() porque vienen varios registros.

        $getFacturados = QuedanFactura::join('facturas', 'quedanfacturas.factura_id', '=', 'facturas.id')
            ->join('proveedores', 'facturas.proveedor_id', '=', 'proveedores.id')
            ->where('quedanfacturas.quedan_id', '=', $id)
            ->whereNull('quedanfacturas.hiden')->orWhere('quedanfacturas.hiden', '=', 0)
            ->orderBy('quedanfacturas.factura_id', 'asc')
            ->offset(6) //skip() se puede usar ese ya que es lo mismo
            ->limit(6) //take() 
            ->get();

        // $data['title'] = "Welcome to codingdriver.com";
        // $data['content'] = "This is content"; 

        $pdf = PDF::loadView('print_quedan', compact('getQuedan','getFactura', 'getFacturados', 'NumConverted'));
        return $pdf->download('MyQuedan.pdf');
    }    
}
