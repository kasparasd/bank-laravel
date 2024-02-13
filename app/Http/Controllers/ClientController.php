<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Account;
use App\Models\Client;
use Database\Seeders\ClientSeeder;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteGroup;
use App\Services\PersonalCodeValidationService;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use App\Services\PersonalCodeService;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortBy = $request->query('sort', '');
        $perPageSelect = (int) $request->query('pages', 0);
        $s = $request->query('s', '');
        $sorts = Client::getSorts();
        $filters = Client::getFIlters();
        $sortBy = $request->query('sort', '');
        $filterBy = $request->query('filter', '');

        $clients = Client::query();

        $negativeFilter = function ($clients) {
            return $clients->whereHas('accounts', function ($query) {
                $query->select($query->raw('SUM(balance) as total'))
                    ->havingRaw('total < 0');
            });
        };
        $positiveFilter = function ($clients) {
            return $clients->whereHas('accounts', function ($query) {
                $query->select($query->raw('SUM(balance) as total'))
                    ->havingRaw('total > 0');
            });
        };
        $zeroFilter = function ($clients) {
            return $clients->whereHas('accounts', function ($query) {
                $query->select($query->raw('SUM(balance) as total'))
                    ->havingRaw('total = 0');
            });
        };
        $noneFilter = function ($clients) {
            return $clients->whereDoesntHave('accounts');
        };


        $clients = match ($filterBy) {
            'no_filter' => $clients,
            'negative' => $negativeFilter($clients),
            'zero' => $zeroFilter($clients),
            'positive' => $positiveFilter($clients),
            'none' => $noneFilter($clients),
            default => $clients,
        };

        $clients = match ($sortBy) {
            'name_asc' => $clients->orderBy('name'),
            'name_desc' => $clients->orderByDesc('name'),
            'lastname_asc' => $clients->orderBy('lastname'),
            'lastname_desc' => $clients->orderByDesc('lastname'),
            'balance_asc' => $clients->withSum('accounts', 'balance')->orderBy('accounts_sum_balance'),
            'balance_desc' => $clients->withSum('accounts', 'balance')->orderByDesc('accounts_sum_balance'),
            'accounts_asc' => $clients->withCount('accounts')->orderBy('accounts_count'),
            'accounts_desc' => $clients->withCount('accounts')->orderByDesc('accounts_count'),
            default => $clients->orderBy('lastname'),
        };

        if ($s) {
            $keywords = explode(' ', $s);
            if (count($keywords) > 1) {
                $clients = $clients->where(function ($query) use ($keywords) {
                    foreach (range(0, 1) as $index) {
                        $query->orWhere('name', 'like', '%' . $keywords[$index] . '%')
                            ->where('lastname', 'like', '%' . $keywords[1 - $index] . '%');
                    }
                });
            } else {
                $clients = $clients
                    ->where(function ($query) use ($keywords) {
                        $query->where('name', 'like', "%{$keywords[0]}%")
                            ->orWhere('lastname', 'like', "%{$keywords[0]}%");
                    });
            }
        }

        if ($perPageSelect > 0) {
            $clients = $clients->paginate($perPageSelect)->WithQueryString();
        } else {
            $clients = $clients->get();
        }

        Session::put('clients_url', request()->fullUrl());

        return view('clients.index', [
            'clients' => $clients,
            'sorts' => $sorts,
            'sortBy' => $sortBy,
            'perPageSelect' => $perPageSelect,
            'filters' => $filters,
            'filterBy' => $filterBy,
            's' => $s,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $isCodeValid = (new PersonalCodeService($request->personalCodeNumber))->validCode();

        if (!$isCodeValid) {
            return redirect()->back()->withInput()->withErrors(['personalCode' => 'Personal code is not correct']);
        } else if (Client::where('personalCodeNumber', '=', $request->personalCodeNumber)->exists()) {
            return redirect()->back()->withInput()->withErrors(['personalCode' => 'Please check your personal code number. It\'s already registered in our system.']);
        }
        Client::create($request->all());
        return redirect()->route('clients-index')->with('ok', 'New client created.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $accounts = $client->accounts()->get();
        return view('clients.edit', [
            'client' => $client,
            'accounts' => $accounts
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->all());
        if (session(key: 'clients_url')) {
            return redirect(session(key: 'clients_url'))->with('ok', 'Client has been successfully updated.');
        }

        return redirect(route('clients-index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $clientId = $request->client;
        $client = Client::where('id', $clientId)->first();

        return view('clients.delete', [
            'client' => $client
        ]);
    }
    public function destroy(Request $request)
    {
        $clientId = $request->client;
        $client = Client::where('id', $clientId)->first();

        if ($client->accounts->max('balance') != 0 && $client->accounts->min('balance') != 0) {
            return redirect(route('clients-edit', $clientId))->withErrors(['delete' => 'To delete a customer, the balance of the customer\'s accounts must be zero.']);
        } else {
            $client->accounts()->delete();
            $client->where('id', $clientId)->delete();
            return redirect(session(key: 'clients_url'))->with('ok', 'Client successfully deleted.');
        }
    }
}
