@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('licence-form'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">

                    {!! Form::open(['method' => 'POST','action' => ['Admin\LicenceController@store'], 'class'=> 'form-horizontal']) !!}

                    <div class="box-header">
                        <h3 class="box-title">{{trans('licence.new-title')}}</h3>
                    </div>

                    <div class="box-body">

                        @include('errors.list')

                        <label class="text-danger font-w500 header-title animated flash"> (*) {{trans('general.needed-fields')}}</label>

                        <div class="row">
                            <div class="col-sm-6 form-horizontal">

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="name">{{trans('licence.table-name')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="identifier">{{trans('licence.table-identifier')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::text('identifier', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        {!! Form::label('description', trans('licence.table-desc')) !!}
                                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="outlet_number">{{trans('licence.users-number-field')}}<span class="text-danger animated flash"> *</span></label>
                                        {!! Form::number('users_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-lg-12">

                                        <h3 class="block-title">{{trans('licence.organizations-list')}}</h3>

                                        <div class="block-content animated fadeIn">
                                            {!! Form::select('organizations[]', $organizations, null, ['multiple', 'id'=> 'organizations_list'] ) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <a href="{{action('Admin\LicenceController@index')}}" class="btn btn-flat btn-sm btn-info" type="button">
                            <i class="fa fa-arrow-left"></i> {{trans('licence.back-action')}}
                        </a>
                        <button class="btn btn-flat btn-sm btn-success" type="submit">
                            <i class="fa fa-check push-5-r"></i> {{trans('licence.create-action')}}
                        </button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </section>

@endsection
