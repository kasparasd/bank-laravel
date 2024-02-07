<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Client;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Return form to add money to account
     */
    public function processFunds()
    {
        return view('accounts.processFunds');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function action(Request $request)
    {
        $content = $request->all();
        $client =  $content['client'];
        $account =  $content['account'];

        if ($content['type'] == 'addFunds') {

            return redirect(route('accounts-addFunds', [$client, $account]));
        }
        if ($content['type'] == 'withdrawFunds') {

            return redirect(route('accounts-withdraw', [$client, $account]));
        }
    }

    public function addFunds(Request $request)
    {
        $clientNum = $request->client;
        $accountNum = $request->account;

        $client =  Client::where('id', $clientNum)->first();
        $accountNumber = $client->accounts->where('id', $accountNum)->first()->accountNumber;
        $accountBalance = $client->accounts->where('id', $accountNum)->first()->balance;


        return view('accounts.addFunds', [
            'client' => $client,
            'accountNumber' => $accountNumber,
            'accountNum' => $accountNum,
            'accountBalance'=>$accountBalance
        ]);
    }
    public function withdraw(Request $request)
    {
        $clientNum = $request->client;
        $accountNum = $request->account;
        $accounts = Account::all()->sortBy('client.name');

        $client =  Client::where('id', $clientNum)->first();
        $accountNumber = $client->accounts->where('id', $accountNum)->first()->accountNumber;
        $accountBalance = $client->accounts->where('id', $accountNum)->first()->balance;


        return view('accounts.withdrawFunds', [
            'client' => $client,
            'accountNumber' => $accountNumber,
            'accountNum' => $accountNum,
            'accountBalance'=>$accountBalance,
            'accounts'=>$accounts
        ]);
    }

    public function addFundsPost(Request $request)
    {
        $amount = $request->amount;
        $clientNum = $request->client;
        $accountNum = $request->accountNum;

        $client =  Client::where('id', $clientNum)->first();
        $accountBalance = $client->accounts->where('id', $accountNum)->first()->balance;
        $newBalance = $accountBalance + $amount;

        Client::where('id', $clientNum)->first()->accounts->where('id', $accountNum)->first()->update(['balance' => $newBalance]);
        return redirect(route('accounts-addFunds', [$client, $accountNum]));
        // dump($clientNum);
        // dump($amount);
        // dump($accountNum);
        // // dd($request->all());
        // dd($accountBalance);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        function generateAccountNumber()
        {
            $newBankAccountNumber = ['L', 'T'];
            $formatBankAccountNumber = '';

            for ($i = 0; $i < 18; $i++) {
                $newBankAccountNumber[] = rand(0, 9);
            }
            unset($i);

            for ($i = 0; $i < count($newBankAccountNumber); $i++) {
                if ($i % 4 === 0 && $i !== 0) {
                    $formatBankAccountNumber = $formatBankAccountNumber . ' ';
                }
                $formatBankAccountNumber = $formatBankAccountNumber . $newBankAccountNumber[$i];
            }
            unset($i);

            if (Account::where('accountNumber', '=', $formatBankAccountNumber)->first()) {
                return generateAccountNumber();
            } else {
                return $formatBankAccountNumber;
            }
        }

        $accountNumber = generateAccountNumber();

        $clients = Client::all();
        // dd($accountNumber);
        return view('accounts.create', [
            'clients' => $clients,
            'accountNumber' => $accountNumber
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request)
    {
        Account::create($request->all());
        return redirect()->route('accounts-create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
