@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('user-show', $user))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{$user->username}}</h3>
                    </div>
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 form-horizontal">

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('users.username-field')}}</label>
                                        {!! Form::text('preferred_username', $user->preferred_username, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('users.email-field')}}</label>
                                        {!! Form::email('email', $user->email, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label>{{trans('users.firstname-field')}}</label>
                                        {!! Form::text('given_name', $user->given_name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                    <div class="col-xs-6">
                                        <label>{{trans('users.lastname-field')}}</label>
                                        {!! Form::text('family_name', $user->family_name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('users.role-field')}}</label>
                                        @if($user->role)
                                            {!! Form::text('role', $user->role->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                        @else
                                            <input class="form-control" readonly value="{{trans('role.no-role')}}"/>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        @if($user->organization)
                                            <label>{{trans('users.membership')}}</label>
                                            {!! Form::text('organization', $user->organization->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                        @else
                                            <h3 class="block-title"> {{trans('users.no-membership-detail')}}</h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{action('Admin\UserController@index')}}" class="btn btn-flat btn-sm btn-info" type="button">
                            <i class="fa fa-arrow-left"></i> {{trans('users.back-action')}}
                        </a>
                        <a href="{{action('Admin\UserController@edit', $user->id)}}" class="btn btn-flat btn-sm btn-success" type="button">
                            <i class="fa fa-pencil"></i> {{trans('users.edit-action')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection