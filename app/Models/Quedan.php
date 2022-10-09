<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quedan extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'quedans';

    protected $fillable = ['num_quedan','fecha_emi','cant_num','fuente_id','proyecto_id', 'proveedor_id', 'hiden'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fuente()
    {
        return $this->hasOne('App\Models\Fuente', 'id', 'fuente_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function proyecto()
    {
        return $this->hasOne('App\Models\Proyecto', 'id', 'proyecto_id');
    }
    
   /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * todo: fue añadido después, porque se necesitaba el proveedor para crear un quedan
     */
    public function proveedore()
    { 
        return $this->hasOne('App\Models\Proveedore', 'id', 'proveedor_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quedanfacturas()
    {
        return $this->hasMany('App\Models\Quedanfactura', 'quedan_id', 'id');
    }
    
}
