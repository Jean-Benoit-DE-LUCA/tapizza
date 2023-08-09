<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Transaction;

class HomeController extends Controller
{
    public function homeAction(Request $request) {

        if ($request->success == 'true') {

            if (session()->has('newOrder')) {

                $user = new User();
                $getUser = $user->getUser(session()->get('userMail'));

                $arrayPizza = [];
                foreach (session()->get('newOrder') as $key => $value) {

                    if (is_array($value)) {

                        if (array_key_exists('pizza', $value)) {

                            $arrayPizza[] = $value;
                        }
                    }
                }

                $pizzaString = '';
                foreach ($arrayPizza as $key => $value) {

                    $dataString = '';
                    if (!array_key_exists('ingredients', $value)) {

                        $dataString = '(' . $dataString . implode(',', $value) . ')';
                    }

                    $ingredientsString = '';
                    if (array_key_exists('ingredients', $value)) {

                        $ingredientsString = $ingredientsString . '(';
                        
                        foreach ($value as $key => $val) {

                            if ($key !== 'ingredients') {

                                $ingredientsString = $ingredientsString . $val . ',';
                            }

                            if ($key == 'ingredients') {

                                $ingredientsString = $ingredientsString . implode(',', $val) . ')';
                            }
                        }
                    }

                    $pizzaString = $pizzaString . $dataString . $ingredientsString . ',';
                }

                $transaction = new Transaction();

                $insertTransaction = $transaction->insertTransaction(
                    $getUser[0]->id, 
                    $getUser[0]->email, 
                    session()->get('newOrder')['totalPrice'], 
                    session()->get('newOrder')['userData']['userAddress'], 
                    session()->get('newOrder')['userData']['userPhone'], 
                    session()->get('newOrder')['userData']['dateDelivery'], 
                    session()->get('newOrder')['userData']['timeDelivery'], 
                    session()->get('newOrder')['dateTime'], 
                    substr($pizzaString, 0, -1)
                );

                return redirect()->route('home')->with(['success' => 'Paiement effectué avec succès']);
            }

            else {

                return redirect()->route('home');
            }
        }

        else if ($request->success == 'false') {

            return redirect()->route('home')->with(['error' => 'Erreur lors de la transaction, veuillez réessayer']);
        }

        else {

            return view('home/home');
        }
    }
}
