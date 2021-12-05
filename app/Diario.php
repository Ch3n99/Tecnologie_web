<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Diario extends Model
{
    public $table = 'diari';

    protected $fillable = [
        'data',
		'num_ore',
        'note',
        'id_asseg'
	];

    public function assegnazioni() {
		return $this->belongsTo('App\Assegnazione');
	}
}
