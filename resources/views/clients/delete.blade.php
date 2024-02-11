@extends('layouts.app')
@section('content')
    <div class="delete">
        <div class="delete-container">
            <h2 style="margin-top: 1.5rem">Are you sure you want to delete this client: {{ $client->name }} {{ $client->lastname }}?</h2>
            <div>
                <form action="{{ route('clients-destroy', $client) }}" method="post">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    @csrf
                    @method('delete')
                </form>
                <a href="{{ route('clients-edit', $client->id) }}" class="btn btn-secondary">No</a>
            </div>
        </div>
    </div>
@endsection
