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

	public function convertData($date_start,$date_end_prev,$date_end_eff) {
		// Converto la data che viene inserita nel formato gg/mm/aaaa ed interpretata come mm/gg/aaaa
		$this->attributes['date_start'] = Carbon::createFromFormat('d/m/Y', $date_start);
		$this->attributes['date_end_prev'] = Carbon::createFromFormat('d/m/Y', $date_end_prev);
		$this->attributes['date_end_eff'] = Carbon::createFromFormat('d/m/Y', $date_end_eff);
	}

	public function clienti() {
		return $this->belongsTo('App\Cliente');
	}

	public function assegnazioni() {	
		return $this->hasMany('App\Assegnazione');
	}
    
}


