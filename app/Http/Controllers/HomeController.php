<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(User $user, Transaction $transaction)
    {
        $user_transaction = $transaction::where('user_id', Auth::user()->id)->get();
        return view('home')->with('check_transaction', count($user_transaction));
    }
}
