@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('organization-show', $organization))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{$organization->name}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4 col-md-4 form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('organization.name-field')}}</label>
                                        {!! Form::text('name', $organization->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('organization.email-field')}}</label>
                                        {!! Form::text('email', $organization->email, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('organization.owner-field')}}</label>
                                        {!! Form::text('owner', $organization->owner->firstname ." ". $organization->owner->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('organization.status-field')}}</label>
                                        {!! Form::text('status', $organization->status, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 form-horizontal">

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('organization.address-field')}}</label>
                                        {!! Form::text('address', $organization->address, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('organization.siret-field')}}</label>
                                        {!! Form::text('siret_number', $organization->siret_number, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('organization.ape-field')}}</label>
                                        {!! Form::text('ape_number', $organization->ape_number, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('organization.licence-field')}}</label>
                                        @if($organization->licence)
                                            {!! Form::text('licence', $organization->licence->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                        @else
                                            <input class="form-control" readonly value="{{trans('licence.no-licence')}}"/>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4 form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                        @if($organization->users()->count() > 0)
                                            <h3 class="block-title">{{trans('organization.users-linked')}}</h3>

                                            <div class="block-content animated fadeIn">
                                                <ul class="fa-ul">
                                                    @foreach($organization->users as $user)
                                                        <li><i class="fa fa-check fa-li"></i>{{$user->given_name}} {{$user->family_name}} (<span class="text-amethyst">{{$user->preferred_username}}</span>)</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @else
                                            <h3 class="block-title">{{trans('organization.no-members')}}</h3>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{action('Admin\OrganizationController@index')}}" class="btn btn-flat btn-sm btn-info" type="button">
                            <i class="fa fa-arrow-left"></i> {{trans('organization.back-action')}}
                        </a>
                        <a href="{{action('Admin\OrganizationController@edit', $organization->id)}}" class="btn btn-flat btn-sm btn-success" type="button">
                            <i class="fa fa-pencil"></i> {{trans('organization.edit-action')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
