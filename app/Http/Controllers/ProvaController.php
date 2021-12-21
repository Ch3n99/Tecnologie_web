<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProvaController extends Controller
{
    public function prova(){
        $a="ciao";
        return view('prova.index', compact('a'));
    }
    public function try(int $id){
        $ciao=DB::table("users")
        ->select("users.surname")
        ->join("assegnazioni","assegnazioni.id_user","=","users.id")
        ->where("assegnazioni.id_progetto","=",$id)
        ->get();

        return view('prova.index', compact('ciao'));
    }
}

