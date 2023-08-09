<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    public function insertResetToken($email, $token, $created_at) {

        $insertResetToken = DB::insert('INSERT INTO `password_reset_tokens` (email, token, created_at) VALUES (?, ?, ?)', [htmlspecialchars($email), $token, $created_at]);
    }

    public function selectResetToken($email, $token) {

        $selectResetToken = DB::select('SELECT * FROM `password_reset_tokens` WHERE `password_reset_tokens`.`email` = ? AND `password_reset_tokens`.`token` = ?', [$email, $token]);

        return $selectResetToken;
    }

    public function deleteResetToken($email) {

        $deleteResetToken = DB::delete('DELETE FROM `password_reset_tokens` WHERE `password_reset_tokens`.`email` = ?', [$email]);
    }
}
