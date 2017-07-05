@extends('layouts.auth')

@section('content')
    <div class="login">
    <div class="container-fluid">
            <div class="login__box">
                <form class="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <a class="btn btn-block btn-twitter">
                            Sign in with Twitter
                        </a>
                    </div>
                    <div class="form-group">
                        <h5 class="or"><span>OR</span></h5>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" placeholder="Email">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn-primary btn btn-block btn-md" value="Login">
                    </div>
                    <br/>
                    <p class="text-center forgot"><a href="{{ route('password.request') }}">Forgot your password ?</a></p>
                    <hr/>
                    <p class="text-center have-account">Don't have an account ? <a href="/register"><strong> Sign
                                up</strong></a></p>
                </form>
            </div>
        </div>
    </div>
@endsection
