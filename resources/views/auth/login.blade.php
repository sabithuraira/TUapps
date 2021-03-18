@extends('layouts.login')

@section('content')

<div class="card">
    <div class="header">
        <p class="lead">{{ __('Login') }}</p>
    </div>
    <div class="body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="signin-email" class="control-label sr-only">Email</label>
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="signin-password" class="control-label sr-only">Password</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group clearfix">
                <label class="fancy-checkbox element-left">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>{{ __('Remember Me') }}</span>
                </label>								
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Login') }}</button>
            <div class="bottom">
                <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a></span>
            </div>
        </form>
    </div>
</div>

<!-- -->
@endsection