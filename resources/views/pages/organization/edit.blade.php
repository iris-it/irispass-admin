@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('organization_edit'))

@section('content')

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('organization.edit') }}</h3>
            </div>
            <div class="box-body">
                @include('errors.list')

                {!! Form::model($organization, ['method' => 'PATCH','action' => 'OrganizationController@update']) !!}

                @include('pages.organization.partials.form')

                {!! Form::close() !!}
            </div>
        </div>
    </section>

@endsection