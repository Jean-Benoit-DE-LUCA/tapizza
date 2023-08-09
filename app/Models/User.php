<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'address',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'inputPassword',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function username() {

        return $this->inputEmail;
    }

    public function getAuthPassword() {

        return $this->inputPassword;
    }

    public function getUser($userMail) {

        $getUser = DB::select('SELECT * FROM `users` WHERE `users`.`email` = ?', [$userMail]);
        return $getUser;
    }

    public function updateUser($userPassword, $userAddress, $userPhone, $userMail) {

        $updateUser = DB::update('UPDATE `users` SET `users`.`password` = ?, `users`.`address` = ?, `users`.`phone` = ? WHERE `users`.`email` = ?', [$userPassword, $userAddress, $userPhone, $userMail]);
    }

    public function updatePassword($password, $email) {

        $updatePassword = DB::update('UPDATE `users` SET `users`.`password` = ? WHERE `users`.`email` = ?', [$password, $email]);
    }
}
