@extends('layouts.auth')

@section('content')
{{--<div class="container">--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-8 col-md-offset-2">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">Register</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<form class="form-horizontal" method="POST" action="{{ route('register') }}">--}}
                        {{--{{ csrf_field() }}--}}

                        {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                            {{--<label for="name" class="col-md-4 control-label">Name</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>--}}

                                {{--@if ($errors->has('name'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                            {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>--}}

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
                            {{--<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--Register--}}
                                {{--</button>--}}
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
                    <input class="form-control" id="name" type="text" placeholder="Name">
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
                    <label class="sr-only" for="password">Password</label>
                    <input class="form-control" id="password" type="password" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn-primary btn btn-block btn-md" value="Register">
                </div>
                <hr/>
                <p class="text-center have-account">Already have an account ? <a href="/register"><strong> Sign in</strong></a></p>
            </form>
        </div>
    </div>
</div>
@endsection
