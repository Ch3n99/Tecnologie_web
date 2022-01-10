<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Assegnazione;
use App\Diario;
use App\User;
use App\Project;
use DB;
use Auth;

class AssegnazioneController extends Controller
{
    //l'utente può accedere dopo il login
    public function __construct() 
	{
		$this->middleware('auth');	
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
    }

    /**
     * Show the form for creating a new resource.
     * @param  \App\Assegnazione  $assegnazione
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function createass(Int $id) //per creare assegnazione serve id progetto
    {
        $project=Project::find($id);
        $users=User::all();
        return view('assegnazione.create', compact('project','users'));
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
            'id_user' 				=> 'required',
            'id_progetto' 			=> 'required'
		]);
        $assegnazioni=Assegnazione::all();
		$input = $request->all();
        $test = 1;
        foreach($assegnazioni as $a){ //controllo se l'assegnazione esiste già, in caso apparirà errore in rosso nella view
            if($input['id_user']==$a->id_user && $input['id_progetto']==$a->id_progetto)
            {
                $test = 0;
                break;
            }              
        }
        if($test==1)
        {
            $newAsseg = Assegnazione::create($input);
            return back()->with('success', 'Nuova assegnazione aggiunta con successo!');
        }
        else    
            return back()->with('error', 'Non posso aggiungere questa assegnazione');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assegnazione  $assegnazione
     * @return \Illuminate\Http\Response
     */
    public function show(Assegnazione $assegnazione)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assegnazione  $assegnazione
     * @return \Illuminate\Http\Response
     */
    public function edit(Assegnazione $assegnazione)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assegnazione  $assegnazione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assegnazione $assegnazione)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assegnazione  $assegnazione
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $ass=Assegnazione::find($id);
        $ass->delete();
        return back();
    }

    

}
