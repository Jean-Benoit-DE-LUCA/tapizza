<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Sauce;
use App\Models\Cheese;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PizzaController extends Controller
{
    public function proposalsAction() {

        $proposalObj = new Proposal();
        $getProposals = $proposalObj->getProposals();

        return view('pizza/propositions', ['getProposals' => $getProposals]);
    }

    public function yourPizzaAction() {

        $sauceObj = new Sauce();
        $getSauces = $sauceObj->getSauces();

        $cheeseObj = new Cheese();
        $getCheeses = $cheeseObj->getCheeses();

        return view('pizza/tapizza', [
            'sauces' => $getSauces,
            'cheeses' => $getCheeses
        ]);
    }
}
