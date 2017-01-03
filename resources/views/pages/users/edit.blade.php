@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('edit_user', $user->id))

@section('content')

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('users.edit') }}</h3>
            </div>
            <div class="box-body">
                @include('errors.list')

                {!! Form::model($user, ['method' => 'PATCH','action' => ['UsersController@update', $user->id]]) !!}

                @include('pages.users.partials.form')

                {!! Form::close() !!}
            </div>
        </div>
    </section>

@endsection