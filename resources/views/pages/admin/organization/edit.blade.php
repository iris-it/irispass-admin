@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('organization-form'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    {!! Form::model($organization, ['method' => 'PUT','action' => ['Admin\OrganizationController@update', $organization->id], 'class'=> 'form-horizontal']) !!}

                    <div class="box-header">
                        <h3 class="box-title">{{trans('general.edit')}} {{$organization->name}}</h3>
                    </div>

                    <div class="box-body">

                        @include('errors.list')

                        <div class="row">
                            <div class="col-sm-6 col-md-6 form-horizontal">

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('name', trans('organization.table-name')) !!}
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('phone', trans('organization.table-phone')) !!}
                                        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('email', trans('organization.table-email')) !!}
                                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('website', trans('organization.table-website')) !!}
                                        {!! Form::text('website', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('owner_id', trans('organization.owner-field')) !!}
                                        {!! Form::select('owner_id', $users, null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('status', trans('organization.status-field')) !!}
                                        {!! Form::text('status', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 form-horizontal">

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('address', trans('organization.address-field')) !!}
                                        {!! Form::text('address', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('siren_number', trans('organization.siren-field')) !!}
                                        {!! Form::text('siren_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('siret_number', trans('organization.siret-field')) !!}
                                        {!! Form::text('siret_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('ape_number', trans('organization.ape-field')) !!}
                                        {!! Form::text('ape_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('tva_number', trans('organization.table-tva')) !!}
                                        {!! Form::text('tva_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('licence_id', trans('organization.licence-field')) !!}
                                        {!! Form::select('licence_id', $licences, $organization->licence_id,['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="{{action('Admin\OrganizationController@index')}}" class="btn btn-flat btn-sm btn-info" type="button">
                            <i class="fa fa-arrow-left"></i> {{trans('organization.back-action')}}
                        </a>
                        <button class="btn btn-flat btn-sm btn-success" type="submit">
                            <i class="fa fa-check push-5-r"></i> {{trans('organization.save-action')}}
                        </button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </section>
@endsection