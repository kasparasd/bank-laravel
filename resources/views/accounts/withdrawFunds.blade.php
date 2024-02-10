@extends('layouts.app')
@section('content')
    <div class="col-7" style="margin: auto;  padding: 2rem; border-radius: 15px; border: 1px solid black;">
        <h2 class="mb-4" style="color: crimson;"><b>WITHDRAW FUNDS</b></h2>
        <h4>Bank account number: {{ $accountNumber }} <b> </b></h4>
        <h5>Owner: {{ $client->name }} {{ $client->lastname }}, Current Balance: {{ $accountBalance }}</h5>
        <hr>
        <h2 class="mt-2">Withdraw funds</h2>
        <form action="{{ route('accounts-withdrawPost', [$client, $accountNum]) }}" method="post">
            <div class="form-group mt-3">
                <label for="amount">Amount</label>
                <input style="border-color: grey;" class="form-control funds-input" type="number" step="0.01"
                    name="amount">
            </div>
            @csrf
            <button type="submit" class="btn btn-primary mt-4">Withdraw</button>
        </form>
        <h2 class="mt-2">Transfer funds to other client</h2>
        <form action="{{ route('accounts-transferPost', [$client, $accountNum]) }}" method="post">
            <div class="form-group mt-3">
                <label for="amount">Amount</label>
                <input style="border-color: grey;" class="form-control funds-input" type="number" step="0.01"
                    name="amount">
            </div>
            <div>
                <label for="receivingAccountId">Make transfer to</label>
                <select required style="border-color: grey;" class="form-select" name="receivingAccountId">
                    <option value hidden>Select client</option>
                    @foreach ($accounts as $account)
                        @if ($account->id != $accountNum)
                            <option value="{{ $account->id }}">{{ $account->client->name }}
                                {{ $account->client->lastname }}
                                {{ $account->accountNumber }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @csrf
            <button type="submit" class="btn btn-primary mt-4">Make transfer</button>
        </form>
    </div>
@endsection
