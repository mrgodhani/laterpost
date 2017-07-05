@extends('layouts.auth')

@section('content')
    <div class="login">
        <div class="container-fluid">
            <div class="login__box">
                <form class="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <h3>Welcome! <br/><small>Almost done with account setup</small></h3>
                        <br/>
                        <p> In order to make your account easily accessible and safer, please fill out following below details.</p>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="name">Name</label>
                        <input class="form-control" name="name" id="name" type="text" placeholder="Name">
                        @if ($errors->has('name'))
                            <span class="help-block error">
                    <strong>{{ $errors->first('name') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="email">Email</label>
                        <input class="form-control" name="email" id="email" type="email" placeholder="Email">
                        @if ($errors->has('email'))
                            <span class="help-block error">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password"
                               placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block error">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input class="form-control" id="password" name="password_confirmation" type="password"
                               placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn-primary btn btn-block btn-md" value="Sign up">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
