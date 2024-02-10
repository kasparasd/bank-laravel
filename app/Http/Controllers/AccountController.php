<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\addFundsRequest;
use App\Http\Requests\withdrawFundsRequest;
use App\Models\Account;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
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

        if ($content['type'] && $content['type'] == 'addFunds') {
            return redirect(route('accounts-addFunds', [$client, $account]));
        }
        if ($content['type'] && $content['type'] == 'withdrawFunds') {
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
            'accountBalance' => $accountBalance
        ]);
    }

    public function addFundsPost(addFundsRequest $request)
    {
        $amount = $request->amount;
        $clientNum = $request->client;
        $accountNum = $request->accountNum;

        $client =  Client::where('id', $clientNum)->first();
        $accountBalance = $client->accounts->where('id', $accountNum)->first()->balance;
        $newBalance = $accountBalance + $amount;

        Client::where('id', $clientNum)->first()->accounts->where('id', $accountNum)->first()->update(['balance' => $newBalance]);
        if (session(key: 'clients_url')) {
            return redirect(session(key: 'clients_url'))->with('ok', 'Money successfully added.');;
        }
        return redirect(route('clients-index'));
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
            'accountBalance' => $accountBalance,
            'accounts' => $accounts
        ]);
    }

    public function withdrawPost(withdrawFundsRequest $request)
    {
        $amount = $request->amount;
        $clientNum = $request->client;
        $accountNum = $request->accountNum;

        $client =  Client::where('id', $clientNum)->first();
        $accountBalance = $client->accounts->where('id', $accountNum)->first()->balance;

        $newBalance = $accountBalance - $amount;

        if ($newBalance < 0) {
            return redirect()->back()->withErrors(['accountBalance' => 'There is not enough money in the account.']);
        }

        Client::where('id', $clientNum)->first()->accounts->where('id', $accountNum)->first()->update(['balance' => $newBalance]);

        if (session(key: 'clients_url')) {
            return redirect(session(key: 'clients_url'))->with('ok', 'The funds have been successfully withdrawn.');
        }

        return redirect(route('clients-index'));
    }



    public function transferPost(withdrawFundsRequest $request)
    {
        // send
        $amount = $request->amount;
        $sendingClientId = $request->client;
        $sendingAccountId = $request->accountNum;

        //receive
        $receivingAccountId = $request->receivingAccountId;

        $sendingClient =  Client::where('id', $sendingClientId)->first();
        $sendingAccountBalance = $sendingClient->accounts->where('id', $sendingAccountId)->first()->balance;
        $newSendingBalance = $sendingAccountBalance - $amount;

        if ($newSendingBalance < 0) {
            return redirect()->back()->withErrors(['accountBalance' => 'There is not enough money in the account.']);
        }

        $receivingAccountBalance = Account::where('id', $receivingAccountId)->first()->balance;
        $newReceivingAccountBalance = $receivingAccountBalance + $amount;

        Client::where('id', $sendingClientId)->first()->accounts->where('id', $sendingAccountId)->first()->update(['balance' => $newSendingBalance]);
        Account::where('id', $receivingAccountId)->first()->update(['balance' => $newReceivingAccountBalance]);

        if (session(key: 'clients_url')) {
            return redirect(session(key: 'clients_url'))->with('ok', 'The money has been successfully transferred.');
        }

        return redirect(route('clients-index'));
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
        return redirect()->route('accounts-create')->with('ok', 'Account successfully created.');
    }
}
