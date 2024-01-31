@extends('layouts.app')
@section('content')
    
<div class="col-6" style="margin: auto;  padding: 2rem; border-radius: 15px; border: 1px solid black;">
    <h2 class="mb-4">Create new client</h2>
    <form action="{{route('clients-store')}}" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input value="" class="form-control" type="text" name="name" value="">
        </div>
        <div class="form-group">
            <label for="lastName">Last name</label>
            <input value="" class="form-control" type="text" name="lastname" value="">
        </div>
        
        <div class="form-group">
            <label for="personalCodeNumber">Personal code number</label>
            <input value="" class=" form-control" type="text" name="personalCodeNumber" value="">
        </div>
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
        @csrf
    </form>
    
    
</div>
@endsection

