<?php

namespace App\Http\Controllers;
use App\Progetto;
use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProgettoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progetti=DB::table('progetti') //ho preso i progetti ancora attivi con la ragione sociale del cliente associato al progetto
                  ->select('progetti.id','progetti.name','progetti.description','progetti.note','progetti.date_start','progetti.date_end_prev','progetti.date_end_eff','clienti.ragsoc','progetti.hour_cost')
                  ->join('clienti','progetti.id_cliente','=','clienti.id')
                  ->where('progetti.date_end_eff','=',null)
                  ->get();
        return view('progetto.index' , compact('progetti')); //restituisco la view e passo variabile alla view tramite funzione compact
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti=Cliente::all();
        return view('progetto.create',compact('clienti'));
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
			'name'		    => 'required',
			'description'	=> 'required|min:3',
            'note',
            'date_start'    => 'required',
            'date_end_prev',
            'date_end_eff',
            'id_cliente'    => 'required',
			'hour_cost'		=> 'required',
		]);
		
		$input = $request->all();
		Progetto::create($input);
		
		return redirect('progetto/create')->with('success', 'Nuovo progetto aggiunto con successo!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
