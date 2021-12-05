<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Cliente;
use App\Project;
use App\Assegnazione;
use App\Diario;
use Carbon\Carbon;
use DB;

class UserController extends Controller
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
		$users = User::all();
				
		return view('user.index', compact('users'));
    }
    
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
	{
		return view('user.create');
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
		$input['password'] = bcrypt($input['password']);
		if(Auth::user()->ruolo=="Admin")
			$newUser = User::create($input);
		

		return redirect('user'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function edit($id) 
	{
		$user = User::find($id);

		return view('user.edit', compact('user'));
	}
	
	/**
     * Update the specified resource in storage.
     *
     * @param  int  $id
	 * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function update($id, Request $request) 
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
		if(Auth::user()->ruolo=="Admin")				
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
		try {
			$user = User::find($id);
			if(Auth::user()->ruolo=="Admin" && $user->ruolo=="Semplice")
				$user->delete();
		
		} catch (\Illuminate\Database\QueryException $e) {
			return redirect('user')->withErrors(['L\'utente non può essere cancellato']);
		}
		
		return redirect('user');
    }
	public function query3(Request $request, Int $id)
    {
		$projects=DB::table('projects')
            ->select('assegnazioni.id as id_asseg','projects.id','projects.id_cliente','projects.name','projects.description','projects.date_start','projects.date_end_prev','projects.date_end_eff','projects.hour_cost','clienti.ragsoc','clienti.email')
            ->join('clienti','clienti.id','=','projects.id_cliente')
			->join('assegnazioni','assegnazioni.id_progetto','=','projects.id')
			->join('users','assegnazioni.id_user','=','users.id')
            ->where('users.id','=',$id)
            ->orderBy('projects.date_end_eff','asc')
            ->get();
			
		$clienti=Cliente::all();
		$user=User::find($id);

        // Imposto due date di default: Primo e ultimo gg del mese
		$begin 	= new Carbon('first day of this month');
		$end 	= new Carbon('last day of this month');

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
		$ore_prog = $this->oreProg($clienti,$projects,$id,$d);
        $ore_tot = $this->oreTot($clienti,$projects,$id,$d);

        return view('user.index2',compact('projects','user','id','ore_prog','ore_tot','begin','end'));
                            
    }

    private function oreProg($clienti,$projects,$id,$d) 
	{
		$tot_ore = [];
        foreach($projects as $project) {
			foreach ($clienti as $cliente) {
				if($project->id_cliente==$cliente->id) {
            		$prog_ore = 0;
	        		foreach ($d as $diario) {
                		if($diario->id_progetto==$project->id && $diario->id_user == $id){
                    		$prog_ore += $diario->tot_ore;
							$rag_soc = $cliente->ragsoc;
							$id_asseg = $diario->id_asseg;
						}
            		}
				}
			}
            if($prog_ore!=0) {
                $new = ["progetto_name" => $project->name,
				"rag_soc" => $rag_soc,
				"tot" => $prog_ore,
				"id_asseg" => $id_asseg];
			    array_push($tot_ore, $new);
            }
        }				                	
		return $tot_ore;
	}

    private function oreTot($clienti,$projects,$id,$d) 
	{
        $prog_ore = 0;
        foreach($projects as $project) {
			foreach ($clienti as $cliente) {
				if($project->id_cliente==$cliente->id) {
	        		foreach ($d as $diario) {
                		if($diario->id_progetto==$project->id && $diario->id_user == $id)
                    		$prog_ore += $diario->tot_ore;
            		}
				}
			}
        }					                			                	
		return $prog_ore;
	}
}
