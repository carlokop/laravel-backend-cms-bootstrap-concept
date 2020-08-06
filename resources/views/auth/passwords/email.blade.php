@extends('layouts.auth')

@section('content')
<div class="splash-container">
    <div class="card ">
        <div class="card-header text-center"><a href="../index.html">{{ __('Reset') }}</a><span class="splash-description">Set new password</span></div>
        <div class="card-body">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">

                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mailadres" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
               
                <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Send password reset link') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection