<?php

namespace App\Http\Controllers;

use App\Project;
use App\Assegnazione;
use App\Diario;
use App\User;
use App\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;   
use DB;
use Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clienti = Cliente::all();
				
		return view('cliente.index', compact('clienti'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.create');
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
            'ragsoc' 				=> 'required|min:3',
			'name' 					=> 'required|min:3',
			'surname' 				=> 'required|min:3',
			'email' 				=> 'required|unique:users|email',
		]);

		$input = $request->all();
        if(Auth::user()->ruolo=="Admin")
		    $newCliente = Cliente::create($input);

		return redirect('cliente'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Int $id)
    {
        $cliente = Cliente::find($id);

		return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validatedData = $request->validate([
            'ragsoc' 				=> 'required|min:3',
			'name' 					=> 'required|min:3',
			'surname' 				=> 'required|min:3',
			'email' 				=> 'required|email',
		]);

		$input = $request->all();
        if(Auth::user()->ruolo=="Admin")
		    $cliente->update($input);

		return redirect('cliente'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $cliente = Cliente::find($id);
        if(Auth::user()->ruolo=="Admin")
		    $cliente->delete();
		
		return redirect("cliente");
    }

    public function query2(Request $request, Int $id)
    {
        $projects=DB::table('projects')
            ->select('projects.id','projects.id_cliente','projects.name','projects.description','projects.date_start','projects.date_end_prev','projects.date_end_eff','projects.hour_cost')
            ->join('clienti','clienti.id','=','projects.id_cliente')
            ->where('clienti.id','=',$id)
            ->orderBy('projects.date_end_eff','asc')
            ->get();

        $cliente = Cliente::find($id);
        $users=User::all();

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
		$ore_cl = $this->oreCl($users,$projects,$d);
        $ore_tot = $this->oreTot($users,$projects,$d);

        return view('assegnazione.index2',compact('projects','cliente','id','ore_cl','ore_tot','begin','end'));
                            
    }

    private function oreCl($users,$projects,$d) 
	{
		$tot_ore = [];
        foreach($users as $user){
            $prog_ore = 0;
            foreach($projects as $project)  {
	            foreach ($d as $diario) {
                    if($diario->id_progetto==$project->id && $diario->id_user == $user->id)
                        $prog_ore += $diario->tot_ore;
                }  
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

    private function oreTot($users,$projects,$d) 
	{
        $prog_ore=0;
        foreach($users as $user){
            foreach($projects as $project)  {
	            foreach ($d as $diario) {
                    if($diario->id_progetto==$project->id && $diario->id_user == $user->id)
                        $prog_ore += $diario->tot_ore;
                }  
            }
        }				                	
		return $prog_ore;
	}
}
