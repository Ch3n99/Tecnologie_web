<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//descrive la struttura della tabella presente nel db
class Cliente extends Model
{
    public $table = 'clienti';
	//elenco campi
	protected $fillable = [
		'ragsoc',
        'name',
		'surname',
		'email'	
	];
//qui vengono riportati i collegamenti con le altre tabelle, sia lato 1 che lato N
    public function projects() {	
		return $this->hasMany('App\Project');
	}
}
