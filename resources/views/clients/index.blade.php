@extends('layouts.app')

@section('content')
    <div style="width: 90%; margin: auto;">

        <form action="" method="get">
            <select name="sort" onchange="this.form.submit()">
                <option value="" selected hidden disabled>
                    {{-- <?php
                    if (isset($_GET['sort'])) {
                        echo $_GET['sort'];
                    } else {
                        echo 'Sort here';
                    } ?> --}}
                </option>
                <option value="name a-z">name a-z</option>
                <option value="name z-a">name z-a</option>
                <option value="last name a-z">last name a-z</option>
                <option value="last name z-a">last name z-a</option>
                <option value="balance 0-9">balance 0-9</option>
                <option value="balance 9-0">balance 9-0</option>
            </select>
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
                            <select name="id">
                                <option selected hidden disabled value="0">Choose account</option>
                                @foreach ($client->accounts as $account)
                                    <option value="{{ $account->client_id }}">€ {{$account->balance}} {{ $account->accountNumber }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><a href="{{ route('clients-edit', $client) }}" class="btn btn-secondary btn-sm"> Edit </a></td>
                        <td><a href="" class="btn btn-success btn-sm"> Add funds </a></td>
                        <td><a href="" class="btn btn-warning btn-sm"> Withdraw funds </a></td>
                        <td><a href="" class="btn btn-danger btn-sm"> Delete </a></td>
                    </tr>
                @empty
                    <tr>
                        <td>No clients</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
