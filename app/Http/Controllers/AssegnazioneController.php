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
        $users = DB::table('users')
            ->where('users.ruolo','=','Semplice')
            ->get();
        $projects = DB::table('projects')
            ->where('projects.date_end_eff','=',null)
            ->get();
        return view('assegnazione.create', compact('users','projects'));
    }

    public function createv1(Int $id)
    {
        $user=User::find($id);
        $projects = DB::table('projects')
            ->where('projects.date_end_eff','=',null)
            ->get();
        return view('assegnazione.createv1', compact('user','projects'));
    }

    public function createv2(Int $id)
    {
        $users = DB::table('users')
            ->where('users.ruolo','=','Semplice')
            ->get();
        $project = Project::find($id);
        return view('assegnazione.createv2', compact('users','project'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $projects = DB::table('projects')
        ->select('projects.id','projects.name','projects.description','projects.note','projects.date_start','projects.date_end_prev','projects.date_end_eff','clienti.ragsoc','projects.hour_cost')
        ->join('clienti','clienti.id','=','projects.id_cliente')
        ->where('projects.date_end_eff','=',null)
        ->orderBy('projects.date_start','desc')
        ->get();

        $validatedData = $request->validate([
            'id_user' 				=> 'required',
            'id_progetto' 			=> 'required'
		]);

		$input = $request->all();
        $user = User::find($input['id_user']);
        $project = Project::find($input['id_progetto']);
        $assegnazioni = Assegnazione::all();
        $test = 1;
        foreach($assegnazioni as $a){
            if($input['id_user']==$a->id_user && $input['id_progetto']==$a->id_progetto)
            {
                $test = 0;
                break;
            }              
        }
        
        if(Auth::user()->ruolo=="Admin" && $user->ruolo=="Semplice" && $project->date_end_eff==NULL && $test==1)
        {
		    $newAsseg = Assegnazione::create($input);
            return back()->with('success', 'Nuova assegnazione aggiunta con successo!');
        }
        else
            return back()->with('error','Errore assegnazione');
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
        $assegnazione = Assegnazione::find($id);
        if(Auth::user()->ruolo=="Admin")
		    $assegnazione->delete();
		
		return back();
    }

    

}
