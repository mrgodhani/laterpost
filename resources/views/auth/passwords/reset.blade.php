@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="login">
            <div class="login__box">
                <form class="form" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <h3 class="text-center">
                            Reset Password
                        </h3>
                        <br/>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="sr-only" for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ $email or old('email') }}" placeholder="Email" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" placeholder="Confirm password" name="password_confirmation"
                               required>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn-primary btn btn-block btn-md" value="Reset Password">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
