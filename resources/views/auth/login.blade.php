@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                    <div class="form-group row mb-0 mt-3">
                        <div class="col-md-8 offset-md-4">
                            <a href="{{ url('/login/passport') }}" class="btn btn-warning">
                                {{ __('Login (Passport)') }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
