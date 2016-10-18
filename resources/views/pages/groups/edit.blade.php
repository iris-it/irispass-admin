@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('edit_group', $group->id))

@section('content')

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('groups.edit') }}</h3>
            </div>
            <div class="box-body">

                @include('errors.list')

                {!! Form::model($group, ['method' => 'PATCH','action' => ['GroupsController@update', $group->id]]) !!}

                @include('pages.groups.partials.form')

                {!! Form::close() !!}

            </div>
        </div>
    </section>

@endsection

