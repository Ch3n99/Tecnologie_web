<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();
		
		DB::table('users')->insert([[
	        'name' 			=> 'Mario',
	        'surname' 		=> 'Rossi',
            'ruolo'         => 'Admin',
	        'email' 		=> 'mariorossi@gmail.com',
	        'password' 		=> bcrypt('password'),
	        'updated_at' 	=> date('Y-m-d h:i:s'),
			'created_at' 	=> date('Y-m-d h:i:s')		        
		]]);
		        
        //Model::reguard();
    }
}
