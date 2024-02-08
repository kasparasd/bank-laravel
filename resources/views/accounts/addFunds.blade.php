@extends('layouts.app')
@section('content')
    
<a style="color: navy; text-decoration: none; margin-left: 70px; display:inline-block"
href="{{old('previous_url', url()->previous())}}">

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
    <h2 class="mb-4" style="color: darkgreen;"><b>ADD FUNDS</b></h2>
    <h4>Bank account number: {{$accountNumber}} <b> </b></h4>
    <h5>Owner: {{$client->name}} {{$client->lastname}}, Current Balance: {{$accountBalance}}</h5>
    <hr class="mb-5">
    <form action="{{route('accounts-addFundsPost', [$client, $accountNum])}}" method="post">
        <div class="form-group mt-3">
            <label for="amount">Add Funds to account: <b>{{$accountNumber}}</b></label>
            <input style="border-color: grey;" class="form-control funds-input" type="number" step="0.01"
            name="amount">
        </div>
        <button type="submit" class="btn btn-primary mt-4">Add funds</button>
        @csrf
    </form>
</div>
@endsection

