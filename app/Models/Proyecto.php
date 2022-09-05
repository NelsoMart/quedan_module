<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'proyectos';

    protected $fillable = ['nombre_proyecto', 'hiden'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quedans()
    {
        return $this->hasMany('App\Models\Quedan', 'proyecto_id', 'id');
    }
    
}
