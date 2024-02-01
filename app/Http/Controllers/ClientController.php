<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Account;
use App\Models\Client;
use Database\Seeders\ClientSeeder;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $clients = Client::orderBy('lastname', 'desc')->get();
        // $clients = Client::all();
        $sortBy = $request->query('sort', '');
        $clients = Client::query();

        $clients = match ($sortBy) {
            'name_asc' => $clients->orderBy('name'),
            'name_desc' => $clients->orderByDesc('name'),
            'lastname_asc' => $clients->orderBy('lastname'),
            'lastname_desc' => $clients->orderByDesc('lastname'),
            'balance_asc' => $clients->orderBy('balance'),
            'balance_desc' => $clients->orderByDesc('balance'),
            'accounts_asc' => $clients->withCount('accounts')->orderBy('accounts_count'),
            'accounts_desc' => $clients->withCount('accounts')->orderByDesc('accounts_count'),
            default => $clients->orderBy('lastname'),
        };

        $clients = $clients->get();

        $sorts = Client::getSorts();
        $sortBy = $request->query('sort', '');

        return view('clients.index', [
            'clients' => $clients,
            'sorts' => $sorts,
            'sortBy' => $sortBy
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
        Client::create($request->all());
        return redirect()->route('clients-index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', [
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->all());
        return redirect()->route('clients-index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
    public function add(Client $client)
    {
    }
}
