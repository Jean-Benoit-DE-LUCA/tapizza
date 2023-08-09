<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cheese extends Model
{
    use HasFactory;

    protected $table = 'cheeses';

    public function getCheeses() {

        $getCheeses = DB::select('SELECT * FROM `cheeses`');
        return $getCheeses;
    }
}
