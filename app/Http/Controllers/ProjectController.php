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
        $progetti=DB::table('projects') //ho preso i progetti ancora attivi (campo di data fine effettiva è nullo) con la ragione sociale del cliente associato al progetto
                  ->select('projects.id','projects.name','projects.description','projects.note','projects.date_start','projects.date_end_prev','projects.date_end_eff','clienti.ragsoc','projects.hour_cost')
                  ->join('clienti','projects.id_cliente','=','clienti.id')
                  ->where('projects.date_end_eff','=',null)
                  ->get();
        return view('project.index' , compact('progetti'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //rimanda al form di creazione di un progetto
    {
        $clienti=Cliente::all(); //serve per menù a tendina nella view dove mostro tutti i clienti
        return view('project.create',compact('clienti'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //funzione per salvare i dati nel DB
	{
		$validatedData = $request->validate([ //validazione dati
			'name'          => 'required|min:3',
            'description'   => 'required|min:3',
            'note',
            'date_start'    => 'required',
            'date_end_prev',
            'date_end_eff',
			'id_cliente'    => 'required',
            'hour_cost'	    => 'required|min:1.00'
		]);
		

		$input = $request->all();

		Project::create($input); //creazione nuovo progetto
        return redirect('project/create')->with('success', 'Nuovo progetto aggiunto con successo!');
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Int $id) //rimanda al form per la modifica di un progetto
    {
        $project = Project::find($id); //progetto che voglio modificare
		$clienti = Cliente::all();
        return view('project.edit', compact('project','clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Int $id, Request $request)
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

		$input = $request->all();
		$project=Project::find($id);
        $project->update($input);
        return redirect('project');

    }

    public function show()
    {

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id) //eliminazione di un progetto
    {
        $project = Project::find($id);
        $project->delete();
		
		return redirect('project');
    }
    
    public function viewprog(Request $request, Int $id){ //funzione per vedere dettagli aggiuntivi di un singolo progetto

        $users=User::all();
        $project = Project::find($id);

        // Imposto due date di default: Primo e ultimo gg del mese
        $begin 	= new Carbon('first day of this month');
		$end 	= new Carbon('last day of this month');

        // Controllo se sono state passate delle date e le prelevo se sono presenti (altrimenti uso quelle di default)
		$input = $request->all();

		if (isset($input['date-period-begin'])) {
			$begin = Carbon::createFromFormat('Y-m-d', $input['date-period-begin']);
		}

		if (isset($input['date-period-end'])) {
			$end = Carbon::createFromFormat('Y-m-d', $input['date-period-end']);
		}

        $ass=DB::table('assegnazioni') //elenco assegnazioni per il progetto in questione
            ->select('assegnazioni.id','users.surname','users.name')
            ->join('projects','projects.id','=','assegnazioni.id_progetto')
            ->join('users','users.id','=','assegnazioni.id_user')
            ->where('projects.id','=',$id)
            ->get();
        
        $d=DB::table('diari') //ore di lavoro nel periodo selezionato per ciascuna assegnazione (usata nelle funzioni in basso)
            ->select(DB::raw('SUM(num_ore) as tot_ore'),'data','id_asseg','assegnazioni.id_user','assegnazioni.id_progetto')
            ->join('assegnazioni','assegnazioni.id','=','diari.id_asseg')
            ->whereBetween('data', [$begin, $end])
            ->groupBy('id_asseg')
            ->get();
        
        // ore_prog è array che contiene le ore di lavoro sul progetto di ogni utente (vedere funzione oreProg in basso)
		$ore_prog = $this->oreProg($users,$id,$d);
        // ore_tot contiene il totale delle ore di lavoro (vedere funzione oreTot in basso)
        $ore_tot = $this->oreTot($users,$id,$d);
        
        return view('project.details',compact('project','ass','ore_prog','ore_tot','begin','end'));

    }

    private function oreProg($users,$id,$d) //funzione per creare array contenente ore di lavoro del progetto in questione 
	{
		$tot_ore = []; //dichiaro array vuoto
        foreach($users as $user)  {
            $prog_ore = 0;
	        foreach ($d as $diario) {
                if($diario->id_progetto==$id && $diario->id_user == $user->id) //controllo se progetto è quello giusto e se utente è quello che stiamo esaminando
                    $prog_ore += $diario->tot_ore; //aggiorno somma ore
            }
            if($prog_ore>0)
            {
                $new = ["cognome_utente" => $user->surname,
                "nome_utente" => $user->name,
			    "tot" => $prog_ore];
                array_push($tot_ore, $new); //inserisco elemento appena trovato nell'array
            }      			
        }				                	
		return $tot_ore; //restituisco l'array
	}

    private function oreTot($users,$id,$d) //restituisce totale ore di lavoro del progetto in questione
	{
        $prog_ore = 0;
        foreach($users as $user)  {
	        foreach ($d as $diario) {
                if($diario->id_progetto==$id && $diario->id_user == $user->id)
                    $prog_ore += $diario->tot_ore; //aggiorno somma ore
            }
        }			                	
		return $prog_ore; //restituisco il totale
	}
}
