<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MongoDB\Driver\Session;
use mysql_xdevapi\Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function index()
    {
        /*User::create([
            'name' => 'Flerys',
        'email' => 'flerys@gmail.com',
        'password' => Hash::make('flerys')
        ]);*/
        //return  view('auth.login');
        return  view('auth.login');
    }

    public function client(){
        return  view('auth.loginClient');
    }


    public function accueil()
    {
        //dd(Auth::user());
        return  view('auth.accueil');
        //dd(Auth::user()->getAuthIdentifier());
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('log.client');
    }

    public function pageRegistre()
    {
        return view('auth.registre');
    }

    public function registre(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:4|confirmed:password_confirmation',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => 'admin'
            ]);
            Auth::login($user);
            return redirect()->intended('tableau.bord');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function login(LoginRequest $request){

        $credentials = $request->validated();
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            //dd('eto');
            return redirect()->intended('tableau');

        }
    return to_route('auth.login')->withErrors([
        'email' => 'Adresse mail ou mot de passe incorrect',
    ])->onlyInput('email');
    }

    public function login_client(Request $request){
        $client = Client::all();
        $numero = $request->get('contact');

        foreach ($client as $clients){
            if($clients->contact == $numero){
                session()->put('id_client', $clients->id);
                return redirect()->route('home.client');
            }
        }

        return redirect()->route('log.client')->withErrors([
            'numero' => 'Numero incorrect',
        ]);
    }


    public function logout_client()
       {
           session_destroy();
           return to_route('log.client');
       }

        //if();
//        if$client->con
//        session('idclient' , );
//        return to_route('.login')->withErrors([
//            'email' => 'Adresse mail ou mot de passe incorrect',
//        ])->onlyInput('email');

}
