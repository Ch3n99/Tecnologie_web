<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use App\Project;
use App\Assegnazione;
use App\Diario;
use App\User;
use App\Cliente;
use Carbon\Carbon;
use DB;

class ProjectController extends Controller
{
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
        $projects = DB::table('projects')
        ->select('projects.id','projects.name','projects.description','projects.note','projects.date_start','projects.date_end_prev','projects.date_end_eff','clienti.ragsoc','projects.hour_cost')
        ->join('clienti','clienti.id','=','projects.id_cliente')
        ->where('projects.date_end_eff','=',null)
        ->orderBy('projects.date_start','desc')
        ->get();
	
		return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti = Cliente::all();
        return view('project.create', compact('clienti'));
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
			'name'          => 'required|min:3',
            'description'   => 'required|min:3',
            'note',
            'date_start'    => 'required',
            'date_end_prev',
            'date_end_eff',
			'id_cliente'    => 'required',
            'hour_cost'	    => 'required|min:1.00'
		]);
		
        $date=Carbon::now();

		$input = $request->all();
        if(Auth::user()->ruolo=="Admin" && $input['date_end_eff']<=$date)
        {
		    Project::create($input);
            return redirect('project');
        }
		else
            return back();
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Int $id)
    {
        $project = Project::find($id);
		$clienti = Cliente::all();

		return view('project.edit', compact('project', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, Request $request)
    {
        $validatedData = $request->validate([
			'name'          => 'required|min:3',
            'description'   => 'required|min:3',
            'note',
            'date_start'    => 'required',
            'date_end_prev',
            'date_end_eff',
			'id_cliente'    => 'required',
            'hour_cost'	    => 'required|min:1.00'
		]);
		
        $date=Carbon::now();

		$input = $request->all();
        if(Auth::user()->ruolo=="Admin" && $input['date_end_eff']<=$date)
        {
		    $project->update($input);
            return redirect('project');
        }
		else
            return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $project = Project::find($id);
		if(Auth::user()->ruolo=="Admin")
            $project->delete();
		
		return redirect('project');
    }
    
    public function query1(Request $request, Int $id)
    {
        $project = Project::find($id);
        $projects = Project::all();
        $users=User::all();

        $ass=DB::table('assegnazioni')
            ->select('assegnazioni.id','users.surname','users.name')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->join('users','users.id','=','assegnazioni.id_user')
            ->where('projects.id','=',$id)
            ->get();

        // Imposto due date di default: Primo e ultimo gg del mese
        if($project->date_end_eff==NULL)
        {
            $begin 	= new Carbon('first day of this month');
		    $end 	= new Carbon('last day of this month');
        }
		else
        {
            $begin 	= new Carbon($project->date_start);
		    $end 	= new Carbon($project->date_end_eff);
        }

		// Controllo se sono state passate delle date e le prelevo se sono presenti
		$input = $request->all();

		if (isset($input['date-period-begin'])) {
			$begin = Carbon::createFromFormat('Y-m-d', $input['date-period-begin']);
		}

		if (isset($input['date-period-end'])) {
			$end = Carbon::createFromFormat('Y-m-d', $input['date-period-end']);
		}

        $d=DB::table('diari')
            ->select(DB::raw('SUM(num_ore) as tot_ore'),'data','id_asseg','assegnazioni.id_user','assegnazioni.id_progetto')
            ->join('assegnazioni','assegnazioni.id','=','diari.id_asseg')
            ->whereBetween('data', [$begin, $end])
            ->groupBy('id_asseg')
            ->get();
        
        // Array che contiene la spesa per ogni utente + altre informazioni
		$ore_prog = $this->oreProg($users,$id,$d);
        $ore_tot = $this->oreTot($users,$id,$d);
        $costo_tot = $ore_tot * $project->hour_cost;

        return view('assegnazione.index',compact('ass','projects','project','id','ore_prog','ore_tot','begin','end','costo_tot'));
                            
    }

    private function oreProg($users,$id,$d) 
	{
		$tot_ore = [];
        foreach($users as $user)  {
            $prog_ore = 0;
	        foreach ($d as $diario) {
                if($diario->id_progetto==$id && $diario->id_user == $user->id)
                    $prog_ore += $diario->tot_ore;
            }
            if($prog_ore!=0) {
                $new = ["cognome_utente" => $user->surname,
                "nome_utente" => $user->name,
				"tot" => $prog_ore];
			    array_push($tot_ore, $new);
            }
        }				                	
		return $tot_ore;
	}

    private function oreTot($users,$id,$d) 
	{
        $prog_ore = 0;
        foreach($users as $user)  {
	        foreach ($d as $diario) {
                if($diario->id_progetto==$id && $diario->id_user == $user->id)
                    $prog_ore += $diario->tot_ore;
            }
        }			                	
		return $prog_ore;
	}
}
