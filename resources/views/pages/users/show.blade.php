@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('show_user', $user->id))

@section('content')

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('users.show') }}</h3>
            </div>
            <div class="box-body">
                <h1>{{$user->username}}</h1>

                <a class="btn btn-primary" id="users-edit" href="{{action('UsersController@edit', ['id' => $user->id])}}">{{trans('users.edit')}}</a>
            </div>
        </div>
    </section>

@stop