<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quedanfactura extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'quedanfacturas';

    protected $fillable = ['factura_id','quedan_id','hiden'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function factura()
    {
        return $this->hasOne('App\Models\Factura', 'id', 'factura_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function quedan()
    {
        return $this->hasOne('App\Models\Quedan', 'id', 'quedan_id');
    }
    
}
