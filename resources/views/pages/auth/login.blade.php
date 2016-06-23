@extends('layouts.auth')

@section('content')

    <p class="text-center" style="font-size:2em;">{{ trans('app.login:welcome') }}</p>
    <br><br>
    <div class="col-md-8 col-md-offset-2">
        <login action="{{action('App\AuthController@authorizeUser')}}"></login>
    </div>

    <div class="margin-bottom"></div>

@endsection
