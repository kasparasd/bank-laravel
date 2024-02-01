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
                                    <option @if ($sortBy == $sortKey) selected @endif value="{{ $sortKey }}">{{ $sortValue }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <button class="btn btn-primary mt-4" type="submit">Show</button>
                            <a href="{{route('clients-index')}}" class="btn btn-secondary ms-1 mt-4">Reset</a>
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
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->lastname }} </td>
                        <td>{{ $client->personalCodeNumber }} </td>
                        <td>€ {{ $client->accounts->sum('balance') }}</td>
                        <td>
                            <form action="" method="get" id='form1'>
                                <select name="account">
                                    <option selected hidden disabled value="0">Choose account</option>
                                    @foreach ($client->accounts as $account)
                                        <option value="{{ $account->client_id }}">€ {{ $account->balance }}
                                            {{ $account->accountNumber }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td><a href="{{ route('clients-edit', $client) }}" class="btn btn-secondary btn-sm"> Edit </a>
                        </td>
                        <td><button type="submit" form="form1" class="btn btn-success btn-sm"> Add funds </button>
                        </td>
                        <td><button type="submit" form="form1" id="withdraw" class="btn btn-warning btn-sm"> Withdraw
                                funds
                            </button></td>
                        <td><a href="" class="btn btn-danger btn-sm"> Delete </a></td>
                    </tr>
                    @csrf
                @empty
                    <tr>
                        <td>No clients</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
