<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function setCartAction(Request $request) {

        if (session()->has('userId')) {

            if ($request->has('objListCartLength')) {

                if ($request->input('objListCartLength') == 0) {

                    session()->forget(['objListCart']);
                }
            }

            session(['objListCart' => $request->input('objListCart')]);
            
        }

    }

    public function setCartYourPizzaAction(Request $request) {

        if (session()->has('userId')) {

            session(['objListCartYourPizza' => $request->input('objListCartYourPizza')]);
        }
    }
}
