<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\User;
class Transaction extends Model
{
    public function getCheckPaymentAttribute()
    {
        $transact = Transaction::where('user_id', Auth::user()->id)->first();
         if(!$transact){
            return $transact;
        }else{
            return true;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
