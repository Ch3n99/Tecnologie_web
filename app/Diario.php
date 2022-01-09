<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
//descrive la struttura della tabella presente nel db
class Diario extends Model
{
    public $table = 'diari';
//elenco campi
    protected $fillable = [
        'data',
		'num_ore',
        'note',
        'id_asseg'
	];
//qui vengono riportati i collegamenti con le altre tabelle, sia lato 1 che lato N
    public function assegnazioni() {
		return $this->belongsTo('App\Assegnazione');
	}
}
