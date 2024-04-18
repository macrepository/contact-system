@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <div class="w-75">
        <div class="text-center mb-4">
            <h3>Registration</h3>
        </div>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="name" class="col-sm-3 col-form-label text-end">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" id="name" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label text-end">Email Address</label>
                <div class="col-sm-9">
                    <input type="email" name="email" id="email" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-sm-3 col-form-label text-end">Password</label>
                <div class="col-sm-9">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="password_confirmation" class="col-sm-3 col-form-label text-end">Confirm Password</label>
                <div class="col-sm-9">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9 d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection