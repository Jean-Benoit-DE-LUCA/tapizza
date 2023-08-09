<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class OrderController extends Controller
{
    public function orderAction() {

        $userObj = new User();
        $getUser = $userObj->getUser(session()->get('userMail'));

        $date = getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'];

        return view('order/new-order', [
            'objListCart' => session()->get('objListCart'),
            'objListCartYourPizza' => session()->get('objListCartYourPizza'),
            'getUser' => $getUser,
            'date' => $date
        ]);

    }

    public function orderPostAction(Request $request) {

        require_once '../vendor/autoload.php';

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        header('Content-Type: application/json');

        $url = 'http://localhost:8000';

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $product = $stripe->products->create([
            'name' => 'COMMANDE "TAPIZZA"'
        ]);

        $price = $stripe->prices->create([
            'product' => $product->id,
            'unit_amount' => $request->input('input-hidden-total-price') * 100,
            'currency' => 'eur'
        ]);

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
              'price' => $price->id,
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $url . '/?success=true',
            'cancel_url' => $url . '/?success=false',
        ]);

        return redirect()->to($checkout_session->url);

    }

    public function setOrderAction(Request $request) {

        if (session()->has('userId')) {

            session(['newOrder' => $request->input('objOrder')]);
        }
    }
}
