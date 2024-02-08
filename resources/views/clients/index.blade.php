@extends('layouts.app')

@section('content')
    <div style="width: 90%; margin: auto;">


        <form action="" method="get">
            <div class="container">
                <div class="row ">
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label>Sorting </label>
                            <select class="form-select" name="sort">
                                @foreach ($sorts as $sortKey => $sortValue)
                                    <option @if ($sortBy == $sortKey) selected @endif value="{{ $sortKey }}">
                                        {{ $sortValue }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label>Filter </label>
                            <select class="form-select" name="filter">
                                @foreach ($filters as $filterKey => $filterValue)
                                    <option @if ($filterBy == $filterKey) selected @endif value="{{ $filterKey }}">
                                        {{ $filterValue }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label>Per page </label>
                            <input class="form-control"
                                @if ($perPageSelect) value="{{ $perPageSelect }}" @endif name="pages"
                                type="number">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label>Search client </label>
                            <input class="form-control" @if ($s) value="{{ $s }}" @endif
                                name="s" type="text">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <button class="btn btn-primary mt-4" type="submit">Show</button>
                            <a href="{{ route('clients-index') }}" class="btn btn-secondary ms-1 mt-4">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Personal code number</th>
                    <th scope="col">Total Balance</th>
                    <th scope="col">Client accounts</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr onMouseOver="style.borderBottom='1px solid crimson'"
                        onMouseOut="style.borderBottom='1px solid rgb(222, 226, 230)'">
                        <td>
                            {{ $client->name }}
                        </td>
                        <td>{{ $client->lastname }} </td>
                        <td>{{ $client->personalCodeNumber }} </td>
                        <td>€ {{ $client->accounts->sum('balance') }}</td>
                        <td>
                            <form action="{{ route('accounts-action', ['client' => $client->id]) }}" method="post">
                                @if (count($client->accounts) > 0)
                                    <select required name="account" style="width: 300px">
                                        @if (count($client->accounts) > 1)
                                            <option value hidden>Select account</option>
                                        @endif
                                        @foreach ($client->accounts as $account)
                                            <option value="{{ $account->id }}">€ {{ $account->balance }}
                                                {{ $account->accountNumber }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <div style="width: 300px; display: inline-block">No accounts</div>
                                @endif
                                @csrf
                                <a class="btn btn-secondary btn-sm ms-3"
                                    href="{{ route('clients-edit', $client->id) }}">Edit</a>
                                @if (count($client->accounts) > 0)
                                    <button type="submit" class="btn btn-success btn-sm ms-3" name="type"
                                        value="addFunds">Add
                                        Funds</button>
                                    <button type="submit" class="btn btn-warning sbtn-sm ms-3" name="type"
                                        value="withdrawFunds">Withdraw
                                        Funds</button>
                                    <a href="{{ route('clients-delete', $client->id) }}"
                                        class="btn btn-danger btn-sm ms-3">Delete</a>
                                @else
                                    <a class="btn btn-success btn-sm ms-3" name="type" value="addFunds">Add
                                        Funds</a>
                                    <a class="btn btn-warning btn-sm ms-3" name="type" value="withdrawFunds">Withdraw
                                        Funds</a>
                                    <a href="{{ route('clients-delete', $client->id) }}"
                                        class="btn btn-danger btn-sm ms-3">Delete</a>
                                @endif

                            </form>
                        </td>
                    </tr>
                    @csrf
                @empty
                    <tr>
                        <td colspan="5">No clients</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        @if ($perPageSelect > 0)
            <div>
                {{ $clients->links() }}
            </div>
        @endif
    </div>
@endsection
