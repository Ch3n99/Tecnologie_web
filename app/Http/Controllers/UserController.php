<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utenti=User::all();
        return view("user.index",compact('utenti'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
			'name' 					=> 'required|min:3',
			'surname' 				=> 'required|min:3',
			'email' 				=> 'required|unique:users|email',
			'ruolo'					=> 'required',	
			'password' 				=> 'required|confirmed|min:8',
			'password_confirmation' => 'required',
		]);

		$input = $request->all();
		$input['password'] = bcrypt($input['password']); //critto la password

		$newUser = User::create($input);
		

		return redirect('user'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $utente=User::find($id);
        return view("user.edit",compact('utente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Int $id)
    {
        $validatedData = $request->validate([
			'name' 					=> 'required|min:3',
			'surname' 				=> 'required|min:3',
			'ruolo'					=> 'required',
			'email' 				=> 'required|email',
			'password' 				=> 'nullable|confirmed|min:8',
			'password_confirmation' => 'sometimes|required_with:password',
		]);
	
		$input = $request->all();
		
		// Se il campo password non viene configurato, allora non cambio 
		// la password ed elimino i campi vuoti dai dati altrimenti si 
		// sovrascriverebbe la password
		
		if (!empty($input['password'])) {
			$input['password'] = bcrypt($input['password']);
		
		} else {
			unset($input['password']);
		}
		
		$user = User::find($id);
				
		$user->update($input);
		
		return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {			 	
		try { //l'utente di base (Mario Rossi) non può essere eliminato
			$user = User::find($id);
			$user->delete();
		
		} catch (\Illuminate\Database\QueryException $e) {
			return redirect('user')->withErrors(['L\'utente non può essere cancellato']);
		}
		
		return redirect('user');
    }
}
