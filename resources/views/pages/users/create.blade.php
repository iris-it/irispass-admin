@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('create_user'))

@section('content')

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('users.create') }}</h3>
            </div>
            <div class="box-body">
                @include('errors.list')

                {!! Form::open(['method' => 'POST','action' => 'UsersController@store']) !!}

                @include('pages.users.partials.form')

                {!! Form::close() !!}
            </div>
        </div>
    </section>

@endsection