<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sauce extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getSauces() {

        $getSauces = DB::select('SELECT * FROM `sauces`');
        return $getSauces;
    }
}
