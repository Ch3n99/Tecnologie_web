<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assegnazione extends Model
{
    public $table = 'assegnazioni';
	
	protected $fillable = [
        'id_user',
		'id_progetto'	
	];

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
