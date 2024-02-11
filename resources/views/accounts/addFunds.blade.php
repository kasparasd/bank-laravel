@extends('layouts.app')
@section('content')
    <div class="col-7" style="margin: auto;  padding: 2rem; border: 1px solid grey;">
        <h2 class="mb-4" style="color: darkgreen;"><b>ADD FUNDS</b></h2>
        <h4>Bank account number: {{ $accountNumber }} <b> </b></h4>
        <h5>Owner: {{ $client->name }} {{ $client->lastname }}, Current Balance: {{ $accountBalance }}</h5>
        <hr class="mb-5">
        <form action="{{ route('accounts-addFundsPost', [$client, $accountNum]) }}" method="post">
            <div class="form-group mt-3">
                <label for="amount">Add Funds to account: <b>{{ $accountNumber }}</b></label>
                <input style="border-color: grey;" class="form-control funds-input" type="number" step="0.01"
                    name="amount">
            </div>
            <button type="submit" class="btn btn-primary mt-4">Add funds</button>
            @csrf
        </form>
    </div>
@endsection
