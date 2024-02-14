<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = Client::all()->count();
        $accounts = Account::all()->count();
        $totalBalance = Account::all()->sum('balance');
        $biggestBalanceInAccount = Account::all()->max('balance');
        $averageBalance = round(Account::all()->average('balance'), 2);
        $zeroBalance = Account::where('balance', 0)->count();
        $negativeBalance = Account::where('balance', '<', 0)->count();
        $clientsWithNoAccounts = Client::whereDoesntHave('accounts')->count();

        $data = [
            [
                "name" => "Clients",
                "stat" => $clients
            ],
            [
                "name" => "Accounts",
                "stat" => $accounts
            ],
            [
                "name" => "Total balance",
                "stat" => $totalBalance
            ],
            [
                "name" => "Largest account",
                "stat" => $biggestBalanceInAccount
            ],
            [
                "name" => "Average account balance",
                "stat" => $averageBalance
            ],
            [
                "name" => "Zero balance accounts",
                "stat" => $zeroBalance
            ],
            [
                "name" => "Negative accounts",
                "stat" => $negativeBalance
            ],
            [
                "name" => "Clients without accounts",
                "stat" => $clientsWithNoAccounts
            ],
        ];
        return view('home.index', ["data" => $data]);
    }
}
