@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="login">
        <div class="login__box">
            <form class="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
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
                    <input class="form-control" id="email" name="email" type="email"  value="{{ old('email') }}" placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="help-block error">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="submit" class="btn-primary btn btn-block btn-md" value="Send Password Reset Link">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
