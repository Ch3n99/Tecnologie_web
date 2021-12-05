<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $table = 'clienti';
	
	protected $fillable = [
		'ragsoc',
        'name',
		'surname',
		'email'	
	];

    public function projects() {	
		return $this->hasMany('App\Project');
	}
}
