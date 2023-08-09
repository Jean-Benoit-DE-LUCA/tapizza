<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ProfileController extends Controller
{
    public function profileAction() {

        $userObj = new User();
        $getUser = $userObj->getUser(session()->get('userMail'));

        return view('profile/profile', [
            'getUser' => $getUser
        ]);
    }

    public function profilePostAction(Request $request) {

        $validated = Validator::make(
            [
                'inputAddress' => $request->input('inputAddress'),
                'inputPhone' => $request->input('inputPhone'),
                'inputPassword' => $request->input('inputPassword'),
                'inputPassword_confirmation' => $request->input('inputPassword_confirmation')
            ],
            [
                'inputAddress' => 'required',
                'inputPhone' => 'required',
                'inputPassword' => 'required|min:6',
                'inputPassword_confirmation' => 'required|same:inputPassword'
            ]
        );

        if ($validated->fails()) {

            return redirect()->route('profile')->with(['error' => 'Erreur lors de la modification']);
        }

        $userObj = new User();
        $updateUser = $userObj->updateUser(
            Hash::make($request->input('inputPassword')), 
            $request->input('inputAddress'), 
            $request->input('inputPhone'), 
            session()->get('userMail')
        );

        return redirect()->route('profile')->with(['success' => 'Modifications effectués']);
    }
}
