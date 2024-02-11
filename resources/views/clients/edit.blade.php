@extends('layouts.app')
@section('content')
    <div class="col-6" style="margin: auto;  padding: 2rem; border: 1px solid grey;">
        <h2 class="mb-4">Update client</h2>
        <form action="{{ route('clients-update', $client) }}" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input value="{{ $client->name }}" class="form-control" type="text" name="name" value="">
            </div>
            <div class="form-group">
                <label for="lastName">Last name</label>
                <input value="{{ $client->lastname }}" class="form-control" type="text" name="lastname" value="">
            </div>
            <button type="submit" class="btn btn-primary btn-sm mt-4">Update</button>
            @csrf
            @method('put')
        </form>

        <h2 class="mt-4">Delete clients account</h2>
        <form action="{{ route('accounts-destroy') }}" method="post">
            <div class="form-group">
                <select required class="form-select" name="account_id">
                    <option value hidden >Account to delete</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">€ {{ $account->balance }} {{ $account->accountNumber }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-danger btn-sm mt-2">Delete account</button>
            @csrf
            @method('delete')
        </form>

        <h2 class="mt-4">Delete client</h2>
        <a href="{{ route('clients-delete', $client->id) }}" class="btn btn-danger btn-sm">Delete client</a>

    </div>
@endsection
