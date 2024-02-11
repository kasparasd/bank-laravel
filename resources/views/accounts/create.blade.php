@extends('layouts.app')
@section('content')
    <div class="col-6" style="margin: auto;  padding: 2rem; border: 1px solid grey;">
        <h2 class="mb-4">Create new bank account</h2>
        <form action="{{ route('accounts-store') }}" method="post">
            <div class="form-group">
                <label for="accountNumber">Bank account number</label>
                <input readonly class="form-control" type="text" name="accountNumber" value="{{ $accountNumber }}">
                <input type="balance" name="balance" value="0" hidden>
            </div>
            <div class="form-group">
                <select class="form-select mt-3" name="client_id" style="width: 300px; display: inline-block; border: 1px solid rgba(128, 128, 128, 0.567)">
                    <option value="0">Select client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}
                            {{ $client->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create</button>
            @csrf
        </form>


    </div>
@endsection
