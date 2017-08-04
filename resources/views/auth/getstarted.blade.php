@extends('layouts.auth')

@section('content')
    <div class="login">
        <div class="container-fluid">
            <div class="login__box bigger--box">
                <h3>Connect to Twitter <br/><br/><small>To get started link your user account with Twitter. You can also later on add multiple Twitter accounts from your settings page.</small></h3>
                <br/>
                <a href="/auth/twitter" class="btn btn-block btn-twitter">Connect Twitter Account</a>
            </div>
        </div>
    </div>
@endsection
