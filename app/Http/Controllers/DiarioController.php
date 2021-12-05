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
    public function index(Request $request)
    {
        // Imposto due date di default: Primo e ultimo gg del mese
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

        $diari = DB::table('diari')
            ->select('diari.id','diari.data','projects.name','diari.num_ore','diari.note')
            ->join('assegnazioni','assegnazioni.id','=','diari.id_asseg')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->where('assegnazioni.id_user','=',Auth::user()->id)
            ->whereMonth('diari.data','=',$month)
            ->whereYear('diari.data','=',$year)
            ->orderBy('diari.data','desc')
            ->get();

        $user = User::find(Auth::user()->id);
        $tot = $this->getTot($diari);
        return view('diario.index',compact('user','diari','month','year','tot'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asseg=DB::table('assegnazioni')
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
        $id = $input['id_asseg'];
        $asseg=DB::table('assegnazioni')
            ->select('assegnazioni.id','assegnazioni.id_progetto','projects.date_start','projects.date_end_eff')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->where('assegnazioni.id','=', $id)
            ->get();

        foreach($asseg as $a)
        {
            $start=$a->date_start;
            $end=$a->date_end_eff;
        }

        $ass=Assegnazione::find($id);
        if($ass->id_user==Auth::user()->id && Auth::user()->ruolo=="Semplice" && ($input['data']<=$end || $end==NULL) && $input['data'] >=$start)
        {
		    Diario::create($input);
		    return redirect('diario');
        }
        else
            return redirect('diario/create')->with('error','Errore inserimento scheda ore');
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
        
        $projects = DB::table('projects')
        ->select('projects.id','projects.name','projects.description','projects.note','projects.date_start','projects.date_end_prev','projects.date_end_eff','clienti.ragsoc','projects.hour_cost')
        ->join('clienti','clienti.id','=','projects.id_cliente')
        ->where('projects.date_end_eff','=',null)
        ->orderBy('projects.date_start','desc')
        ->get();
	
        $diari=DB::table('diari')
            ->select('diari.id','assegnazioni.id_user')
            ->join('assegnazioni','assegnazioni.id','=','diari.id_asseg')
            ->where('diari.id','=',$id)
            ->get();

        foreach($diari as $diario)
            $id=$diario->id_user;

		$asseg=DB::table('assegnazioni')
            ->select('assegnazioni.id','assegnazioni.id_progetto','projects.name','assegnazioni.id_user')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->where('assegnazioni.id_user','=', Auth::user()->id)
            ->get();

        if($id==Auth::user()->id)
		    return view('diario.edit', compact('id','diario', 'asseg','d'));
        else
		    return view('project.index', compact('projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Diario  $diario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diario $diario)
    {
        $validatedData = $request->validate([
			'data'          => 'required',
            'num_ore'       => 'required',
            'note',
            'id_asseg'      => 'required'
		]);
		
		$input = $request->all();
        $id = $input['id_asseg'];
        $asseg=DB::table('assegnazioni')
            ->select('assegnazioni.id','assegnazioni.id_progetto','projects.date_start','projects.date_end_eff')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->where('assegnazioni.id','=', $id)
            ->get();

        foreach($asseg as $a)
        {
            $start=$a->date_start;
            $end=$a->date_end_eff;
        }

        $ass=Assegnazione::find($id);
        if($ass->id_user==Auth::user()->id && Auth::user()->ruolo=="Semplice" && ($input['data']<=$end || $end==NULL) && $input['data'] >=$start)
        {
		    $diario->update($input);
		    return redirect('diario');
        }
        else
            return back();
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
        $ass = Assegnazione::find($diario->id_asseg);
        if($ass->id_user==Auth::user()->id)
		    $diario->delete();
		
		return back();
    }

    private function getTot($diari)
    {
        $tot_ore = 0;
        foreach($diari as $d)
            $tot_ore += $d->num_ore;	                	
		return $tot_ore;
    }
}
