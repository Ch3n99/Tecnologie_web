<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Project;
use App\Assegnazione;
use App\Diario;
use App\User;
use App\Cliente;
use Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Http\Request;

class DiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function viewdiario(Request $request, Int $id)
    {
		$month 	= Carbon::now()->month;
		$year 	= Carbon::now()->year;

		// Controllo se sono state passate delle date e le prelevo se sono presenti
		$input = $request->all();

		if (isset($input['mese'])) {
			$month=$input['mese'];
		}

		if (isset($input['anno'])) {
			$year=$input['anno'];
		}
        
        $progetti = DB::table('projects') //stampa progetti a cui sta lavorando l'utente
            ->select('projects.name','projects.description','clienti.ragsoc','projects.hour_cost','assegnazioni.id')
            ->join('assegnazioni', 'assegnazioni.id_progetto','=','projects.id')
            ->join('clienti', 'projects.id_cliente','=','clienti.id')
            ->where('assegnazioni.id_user','=',$id)
            ->get();

        $diari = DB::table('diari') //stampa elenco attività dell'utente con nome progetto di riferimento
            ->select('diari.id','diari.data','projects.name','diari.num_ore','diari.note')
            ->join('assegnazioni','assegnazioni.id','=','diari.id_asseg')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->where('assegnazioni.id_user','=',$id)
            ->whereMonth('diari.data','=',$month)
            ->whereYear('diari.data','=',$year)
            ->orderBy('diari.data','desc')
            ->get();

        $user = User::find($id);
        $tot = $this->getTot($diari);
        return view('diario.index',compact('user','diari','month','year','progetti','tot'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asseg=DB::table('assegnazioni') //questa query elenca solo i progetti ai quali l'utente è stato assegnato
            ->select('assegnazioni.id','assegnazioni.id_progetto','projects.name')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->where('assegnazioni.id_user','=', Auth::user()->id)
            ->get();
        
        return view('diario.create', compact('asseg'));
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
			'data'          => 'required',
            'num_ore'       => 'required',
            'note',
            'id_asseg'      => 'required'
		]);

        $input = $request->all();  
		Diario::create($input);
		return back()->with('success', 'Nuova scheda ore aggiunta con successo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Diario  $diario
     * @return \Illuminate\Http\Response
     */
    public function show(Diario $diario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Diario  $diario
     * @return \Illuminate\Http\Response
     */
    public function edit(Int $id)
    {
        $d=Diario::find($id);

		$asseg=DB::table('assegnazioni')
            ->select('assegnazioni.id','assegnazioni.id_progetto','projects.name','assegnazioni.id_user')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->where('assegnazioni.id_user','=', Auth::user()->id)
            ->get();

		return view('diario.edit', compact('id', 'asseg','d'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Diario  $diario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Int $id)
    {
        $validatedData = $request->validate([
			'data'          => 'required',
            'num_ore'       => 'required',
            'note',
            'id_asseg'      => 'required'
		]);
		
		$input = $request->all();
        $diario = Diario::find($id);
		$diario->update($input);
		return redirect('utente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Diario  $diario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $diario = Diario::find($id);
		$diario->delete();
		return back();
    }

    private function getTot($diari)
    {
        $tot_ore = 0;
        foreach($diari as $i)
            $tot_ore += $i->num_ore;	                	
		return $tot_ore;
    }

}
