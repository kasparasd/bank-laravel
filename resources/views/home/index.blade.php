@extends('layouts.app')
@section('content')
    @if (Auth::check())
        <section class="py-3 py-md-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8 col-xxl-7">
                        <div class="row gy-4">

                            @foreach ($data as $stat)
                                <div class="col-12 col-sm-6">
                                    <div class="card widget-card shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h5 class="card-title widget-card-title mb-3">{{ $stat['name'] }}</h5>
                                                </div>
                                                <div class="col-5">
                                                    <h4 class="card-subtitle text-body-secondary m-0">{{ $stat['stat'] }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="container text-center py-5 mb-4 ">
            <div class="p-5 mb-4 lc-block">
                <div class="lc-block mb-4">
                    <div editable="rich">
                        <h1 class="fw-bold">Please <a href="{{ route('login') }}">Log in</a> to continue</h1>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
