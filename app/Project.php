<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
	
	protected $fillable = [
		'name',
		'description',
		'note',
		'date_start',
		'date_end_prev',
		'date_end_eff',
		'id_cliente',
		'hour_cost'		
	];

	public function clienti() {
		return $this->belongsTo('App\Cliente');
	}

	public function assegnazioni() {	
		return $this->hasMany('App\Assegnazione');
	}
    
}


