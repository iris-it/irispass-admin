@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('organization-form'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    {!! Form::open(['method' => 'POST','action' => ['Admin\OrganizationController@store'], 'class'=> 'form-horizontal']) !!}

                    <div class="box-header">
                        <h3 class="box-title">{{trans('organization.new-title')}}</h3>
                    </div>

                    <div class="box-body">

                        @include('errors.list')

                        <label class="text-danger font-w500 header-title animated flash"> (*) {{trans('general.needed-fields')}}</label>

                        <div class="row">
                            <div class="col-sm-6 col-md-6 form-horizontal">

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="name">{{trans('organization.table-name')}}<span class="text-danger animated flash"> *</span></label>
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
                                        <label for="email">{{trans('organization.table-email')}}<span class="text-danger animated flash"> *</span></label>
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
                                        <label for="owner_id">{{trans('organization.owner-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::select('owner_id', $users, null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="status">{{trans('organization.status-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('status', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 form-horizontal">

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="address">{{trans('organization.address-field')}}<span class="text-danger animated flash"> *</span></label>
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
                                        <label for="siret_number">{{trans('organization.siret-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('siret_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="ape_number">{{trans('organization.ape-field')}}<span class="text-danger animated flash"> *</span></label>
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
                                        <label for="licence_id">{{trans('organization.licence-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::select('licence_id', $licences, null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <a href="{{action('Admin\OrganizationController@index')}}" class="btn btn-flat btn-sm btn-info" type="button">
                            <i class="fa fa-arrow-left"></i> {{trans('organization.back-action')}}
                        </a>
                        <button class="btn btn-flat btn-sm btn-primary" type="submit">
                            <i class="fa fa-check push-5-r"></i> {{trans('organization.create-action')}}
                        </button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </section>



@endsection