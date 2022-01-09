<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//descrive la struttura della tabella presente nel db
class Assegnazione extends Model
{
    public $table = 'assegnazioni';
	//elenco campi
	protected $fillable = [
        'id_user',
		'id_progetto'	
	];
//qui vengono riportati i collegamenti con le altre tabelle, sia lato 1 che lato N
	public function projects() {
		return $this->belongsTo('App\Project');
	}

	public function users() {
		return $this->belongsTo('App\User');
	}

	public function diari() {
		return $this->hasMany('App\Diario');
	}
}
