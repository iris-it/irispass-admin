@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('create_group'))

@section('content')

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('groups.create') }}</h3>
            </div>
            <div class="box-body">
                @include('errors.list')

                {!! Form::open(['method' => 'POST','action' => 'GroupsController@store']) !!}

                @include('pages.groups.partials.form')

                {!! Form::close() !!}

            </div>
        </div>
    </section>

@endsection