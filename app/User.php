<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//descrive la struttura della tabella presente nel db
class User extends Authenticatable
{    
    use Notifiable;
 
    //elenco campi
    protected $fillable = [
        'name', 
        'surname', 
        'ruolo', 
        'email', 
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
    //qui vengono riportati i collegamenti con le altre tabelle, sia lato 1 che lato N
	public function assegnazioni() {	
		return $this->hasMany('App\Assegnazione');
	}

}
