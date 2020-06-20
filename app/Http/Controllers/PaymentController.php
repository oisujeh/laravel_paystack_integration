<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transaction;
use Paystack;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        // SELECT `id`, `user_id`, `reference`, `email`, `amount`, `status`, `payment_date`, `created_at`, `updated_at` FROM `transactions` WHERE 1
        // dd($paymentDetails);
        // var_dump($paymentDetails['data']['status']);
        if($paymentDetails['data']['status'] == 'success')
        {
            flash('Transaction Done Successfully');
        }else{
            flash('Transaction not Successful');
        }
        $transaction= new Transaction;
        $transaction->user_id = Auth::user()->id;
        $transaction->reference= $paymentDetails['data']['reference'];
        $transaction->email= Auth::user()->email;
        $transaction->amount= $paymentDetails['data']['amount'];
        $transaction->status= $paymentDetails['data']['status'];
        $transaction->payment_date=$paymentDetails['data']['transaction_date'];
        $transaction->save();
        return redirect()
        ->route('home');
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
