<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Proposal extends Model
{
    use HasFactory;

    protected $table = 'proposals';

    public function getProposals() {

        $result = DB::select('SELECT * FROM `proposals`');
        return $result;
    }
}
