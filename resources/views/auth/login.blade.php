@extends('layouts.auth')

@section('content')
{{--<div class="container">--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-8 col-md-offset-2">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">Login</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<form class="form-horizontal" method="POST" action="{{ route('login') }}">--}}
                        {{--{{ csrf_field() }}--}}

                        {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                            {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>--}}

                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                            {{--<label for="password" class="col-md-4 control-label">Password</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password" type="password" class="form-control" name="password" required>--}}

                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-8 col-md-offset-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--Login--}}
                                {{--</button>--}}

                                {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                    {{--Forgot Your Password?--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
    <div class="container">
        <div class="login">
            <div class="login__box">
                <form class="form" action="{{ route('login') }}">
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
                        <input class="form-control" id="email" type="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input class="form-control" id="password" type="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <p class="text-center forgot"><a href="/password/reset">Forgot your password ?</a></p>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn-primary btn btn-block btn-md" value="Login">
                    </div>
                    <hr/>
                    <p class="text-center have-account">Don't have an account ? <a href="/register"><strong> Sign up</strong></a></p>
                </form>
            </div>
        </div>
    </div>
@endsection
