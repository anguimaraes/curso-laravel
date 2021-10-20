<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        $nome = "André";
        $idade = "31";
        $arr = [1,2,3,4,5];
        $nomes = ["André", "Manolo", "Derpina"];
    
        return view('welcome', 
            [
                'nome' => $nome, 
                'idade' => $idade,
                'profissao' => "Programador",
                'arr' => $arr,
                'nomes' => $nomes
            ]);
    }

    public function create(){
        return view('events.create');
    }

    public function contact(){
        return view('events.contact');
    }

    public function products(){
        return view('events.products');
    }
}
