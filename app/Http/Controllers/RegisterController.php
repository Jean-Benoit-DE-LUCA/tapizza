<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function registerAction() {

        return view('register/register');
    }

    public function registerPostAction(Request $request) {

        $userObj = new User();
        $checkUser = $userObj->getUser($request->input('inputEmail'));

        if ($request->input('inputPassword') !== $request->input('inputPassword_confirmation')) {

            return redirect()->route('register')->with(['error' => 'Votre mot de passe ne correspond pas']);
        }
        
        if ($checkUser == null) {

            $request->validate([
                'input-username' => 'required',
                'inputEmail' => 'required',
                'inputAddress' => 'required',
                'inputPhone' => 'required',
                'inputPassword' => 'required|confirmed|min:6'
            ]);

            $createUser = User::create([
                'username' => $request->input('input-username'),
                'email' => $request->input('inputEmail'),
                'address' => $request->input('inputAddress'),
                'phone' => $request->input('inputPhone'),
                'password' => $request->input('inputPassword')
            ]);

            $userObjSelect = new User();
            $selectUser = $userObjSelect->getUser($request->input('inputEmail'));
            
            session(['userId' => $selectUser[0]->id]);
            session(['userName' => $selectUser[0]->username]);
            session(['userMail' => $selectUser[0]->email]);
            session(['role' => $selectUser[0]->role]);

            return redirect()->route('home');
        }

        else {

            return redirect()->route('register')->with(['error' => 'Email déjà enregistré']);
        }
    }
}
