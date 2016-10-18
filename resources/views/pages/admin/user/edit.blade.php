@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('user-form'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    {!! Form::model($user, ['method' => 'PUT','action' => ['Admin\UserController@update', $user->id], 'class'=> 'form-horizontal']) !!}

                    <div class="box-header">
                        <h3 class="box-title">{{trans('general.edit')}} {{$user->username}}</h3>
                    </div>

                    <div class="box-body">

                        @include('errors.list')

                        <div class="row">
                            <div class="col-md-8 col-sm-offset-2 form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        {!! Form::label('preferred_username', trans('users.username-field')) !!}
                                        {!! Form::text('preferred_username', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        {!! Form::label('email', trans('users.email-field')) !!}
                                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-6">
                                        {!! Form::label('given_name', trans('users.firstname-field')) !!}
                                        {!! Form::text('given_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::label('family_name', trans('users.lastname-field')) !!}
                                        {!! Form::text('family_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        {!! Form::label('role_id', trans('users.role-field')) !!}
                                        {!! Form::select('role_id', $roles, $user->role_id,['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                @if($user->organization)
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            {!! Form::label('orga_id', trans('users.membership')) !!}
                                            <br>
                                            <p class="text-danger animated flash" style="display:inline"><i class="fa fa-warning"></i> {{trans('organization.users-warning')}}</p>
                                            {!! Form::select('orga_id', $organizations, $user->organization->id,['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            {!! Form::label('orga_id', trans('users.membership')) !!}
                                            {!! Form::select('orga_id', $organizations, null,['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="{{action('Admin\UserController@index')}}" class="btn btn-flat btn-sm btn-info" type="button">
                            <i class="fa fa-arrow-left"></i> {{trans('users.back-action')}}
                        </a>
                        <button class="btn btn-flat btn-sm btn-success" type="submit">
                            <i class="fa fa-check push-5-r"></i> {{trans('users.save-action')}}
                        </button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </section>

@endsection