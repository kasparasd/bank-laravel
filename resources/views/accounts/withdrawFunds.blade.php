@extends('layouts.app')
@section('content')
    <a style="color: navy; text-decoration: none; margin-left: 70px; display:inline-block"
        href="{{ route('clients-index') }}">

        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
            </svg>
            <span>Back to all accounts</span>
        </div>
    </a>

    <div class="col-7" style="margin: auto;  padding: 2rem; border-radius: 15px; border: 1px solid black;">
        <h2 class="mb-4" style="color: crimson;"><b>WITHDRAW FUNDS</b></h2>
        <h4>Bank account number: {{ $accountNumber }} <b> </b></h4>
        <h5>Owner: {{ $client->name }} {{ $client->lastname }}, Current Balance: {{ $accountBalance }}</h5>
        <hr>
        <h2 class="mt-2">Withdraw funds</h2>
        <form action="{{ route('accounts-withdraw', [$client, $accountNum]) }}" method="post">
            <div class="form-group mt-3">
                <label for="amount">Amount</label>
                <input style="border-color: grey;" class="form-control funds-input" type="number" step="0.01"
                    name="amount">
            </div>
            <button type="submit" class="btn btn-primary mt-4">Withdraw</button>
            @csrf
        </form>
        <h2 class="mt-2">Transfer funds to other client</h2>
        <form action="{{ route('accounts-withdraw', [$client, $accountNum]) }}" method="post">
            <div class="form-group mt-3">
                <label for="amount">Amount</label>
                <input style="border-color: grey;" class="form-control funds-input" type="number" step="0.01"
                    name="amount">
            </div>
            <div>
                <label for="client">Make transfer to</label>
                <select required style="border-color: grey;" class="form-select" name="client">
                    <option value hidden>Select client</option>
                    @foreach ($accounts as $account)
                        @if ($account->id != $accountNum)
                            <option value="">{{ $account->client->name }} {{ $account->client->lastname }}
                                {{ $account->accountNumber }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Make transfer</button>
            @csrf
        </form>
    </div>
@endsection
