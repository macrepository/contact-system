@extends('layouts.app')

@section('content')
<div>
    <div class="text-center">
        <h3>{{ ucfirst($options['action']) }} Contact</h3>
    </div>
    <form action="{{ $options['url'] }}" method="POST">
        @csrf
        @if(isset($options['action']) && $options['action'] == 'edit')
            @method('PATCH')
        @endif

        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label text-end">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" value="{{ $options['contacts']['name'] ?? '' }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="company" class="col-sm-2 col-form-label text-end">Company</label>
            <div class="col-sm-10">
                <input type="text" name="company" id="company" class="form-control" value="{{ $options['contacts']['company'] ?? '' }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="phone" class="col-sm-2 col-form-label text-end">Phone</label>
            <div class="col-sm-10">
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $options['contacts']['phone'] ?? '' }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label text-end">Email</label>
            <div class="col-sm-10">
                <input type="email" name="email" id="email" class="form-control" value="{{ $options['contacts']['email'] ?? '' }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection