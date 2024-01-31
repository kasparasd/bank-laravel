@extends('layouts.app')
@section('content')
    <div class="col-6" style="margin: auto;  padding: 2rem; border-radius: 15px; border: 1px solid black;">
        <h2 class="mb-4">Create new bank account</h2>
        <form action="{{ route('accounts-store') }}" method="post">
            <div class="form-group">
                <label for="accountNumber">Bank account number</label>
                <input readonly class="form-control" type="text" name="accountNumber" value="{{ $accountNumber }}">
                <input type="balance" name="balance" value="0" hidden>
            </div>
            <div class="form-group">
                <select name="client_id">
                    <option value="0">Select client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}
                            {{ $client->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
            @csrf
        </form>


    </div>
@endsection
