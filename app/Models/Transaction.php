<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'email',
        'price',
        'currency',
        'address_delivery',
        'phone_delivery',
        'date_delivery',
        'time_delivery',
        'transaction_date',
        'order_item'
    ];

    public function insertTransaction($user_id, $email, $price, /* $currency, */ $address_delivery, $phone_delivery, $date_delivery, $time_delivery, $transaction_date, $order_item) {

        $insertTransactionData = DB::insert('INSERT INTO `transactions` (user_id, email, price, /* currency, */ address_delivery, phone_delivery, date_delivery, time_delivery, transaction_date, order_item) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$user_id, $email, $price, $address_delivery, $phone_delivery, $date_delivery, $time_delivery, $transaction_date, $order_item]);
    }
}
