<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventoController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdministrator()){
            $controller = new EventoController(); 
            return View('welcome', [
                'eventos' => $controller->all()
            ]);  
        }else{
            return redirect('/user/' . Auth::user()->id . '/cartoes');
        }
    }
}
