<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
//descrive la struttura della tabella presente nel db
class Project extends Model
{
	//elenco campi
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
//qui vengono riportati i collegamenti con le altre tabelle, sia lato 1 che lato N
	public function clienti() {
		return $this->belongsTo('App\Cliente');
	}

	public function assegnazioni() {	
		return $this->hasMany('App\Assegnazione');
	}
    
}


