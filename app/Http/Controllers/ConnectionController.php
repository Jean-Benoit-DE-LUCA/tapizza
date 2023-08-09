<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\Models\User;

class ConnectionController extends Controller
{
    public function connectionAction() {

        return view('connection/connection');
    }

    public function connectionPostAction(Request $request) {

        $credentials = $request->validate([
            'inputEmail' => 'required',
            'inputPassword' => 'required'
        ]);

        $user = new User();
        $checkUser = $user->getUser($credentials["inputEmail"]);
        
        if (empty($checkUser)) {

            return redirect()->route('connection')->with(['error' => 'Utilisateur non enregistré']);
        }

        else {

            if (Hash::check($credentials['inputPassword'], $checkUser[0]->password)) {

                session(['userId' => $checkUser[0]->id]);
                session(['userName' => $checkUser[0]->username]);
                session(['userMail' => $checkUser[0]->email]);
                session(['role' => $checkUser[0]->role]);
    
                return redirect()->route('home');
            }
    
            else {
    
                return redirect()->route('connection')->with(['error' => 'Mot de passe non valide']);
            }
        }
        
    }

    public function disconnectionAction(Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->flush();

        return redirect()->route('home');
    }
}
