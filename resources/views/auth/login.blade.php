@extends('layouts.auth')

@section('content')
<div class="splash-container">
    <div class="card ">
        <div class="card-header text-center"><a href="../index.html">{{ __('Login') }}</a><span class="splash-description">Enter your login details</span></div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span class="custom-control-label">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Login') }}</button>
            </form>
        </div>
        <div class="card-footer bg-white p-0  ">
            <div class="card-footer-item card-footer-item-bordered">
                <a href="{{ route('register') }}" class="footer-link">Register</a></div>
            <div class="card-footer-item card-footer-item-bordered">
                <a href="{{ route('password.request') }}" class="footer-link">Forgot your password</a>
            </div>
        </div>
    </div>
</div>
@endsection