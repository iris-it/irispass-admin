@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('user-form'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    {!! Form::open(['method' => 'POST','action' => ['Admin\UserController@store']]) !!}

                    <div class="box-header">
                        <h3 class="box-title">{{trans('users.new-title')}}</h3>
                    </div>

                    <div class="box-body">

                        <label class="text-danger font-w500 header-title animated flash"> (*) {{trans('general.needed-fields')}}</label>

                        <div class="row">
                            <div class="col-md-12 form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="preferred_username">{{trans('users.username-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('preferred_username', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">{{trans('users.email-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="given_name">{{trans('users.firstname-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('given_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="family_name">{{trans('users.lastname-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('family_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label for="role_id">{{ trans('users.role-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::select('role_id', $roles, null,['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        {!! Form::label('orga_id', trans('users.membership')) !!}
                                        {!! Form::select('orga_id', $organizations, null,['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <a href="{{action('Admin\UserController@index')}}" class="btn btn-flat btn-sm btn-info" type="button">
                            <i class="fa fa-arrow-left"></i> {{trans('users.back-action')}}
                        </a>
                        <button class="btn btn-flat btn-sm btn-primary" type="submit">
                            <i class="fa fa-check push-5-r"></i> {{trans('users.create-action')}}
                        </button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <h1 class="block-title big-title animated fadeIn">{{trans('users.create-action')}}</h1>
        @include('errors.list')

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="block">

                    <div class="block-header bg-gray text-white">
                        <h3 class="block-title header-title"></h3>
                        <label class="text-danger font-w500 header-title animated flash"> (*) {{trans('general.needed-fields')}}</label>
                    </div>
                    <div class="block-content animated fadeIn">
                        <div class="row items-push">
                            <div class="col-md-12 form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="username">{{trans('users.username-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('username', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">{{trans('users.email-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="firstname">{{trans('users.firstname-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastname">{{trans('users.lastname-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-xs-6">
                                        <label for="password">{{trans('users.password-field')}}<span class="text-danger animated flash"> *</span></label>
                                        <input class="form-control" name="password" type="password" id="password">
                                    </div>

                                    <div class="col-md-6 col-xs-6">
                                        <label for="password_confirmation">{{trans('users.password-confirmation-field')}}<span class="text-danger animated flash"> *</span></label>
                                        <input class="form-control" name="password_confirmation" type="password"
                                               id="password_confirmation">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label for="role_id">{{ trans('users.role-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::select('role_id', $roles, null,['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        {!! Form::label('orga_id', trans('users.membership')) !!}
                                        {!! Form::select('orga_id', $organizations, null,['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter text-center animated fadeIn">

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection