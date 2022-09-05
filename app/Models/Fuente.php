<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuente extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'fuentes';

    protected $fillable = ['nombre_fuente', 'hiden'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quedans()
    {
        return $this->hasMany('App\Models\Quedan', 'fuente_id', 'id');
    }
    
}
