@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('licence-show', $licence))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{$licence->name}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row items-push">
                            <div class="col-sm-6 col-md-6 form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('licence.table-name')}}</label>
                                        {!! Form::text('name', $licence->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('licence.table-identifier')}}</label>
                                        {!! Form::text('identifier', $licence->identifier, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('licence.table-desc')}}</label>
                                        {!! Form::text('description', $licence->description, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        <label>{{trans('licence.outlets-number-field')}}</label>
                                        {!! Form::number('outlet_number', $licence->outlet_number, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 form-horizontal">

                                <div class="form-group">
                                    <div class="col-md-12 col-xs-12">
                                        @if($licence->organizations()->count() > 0)
                                            <div class="block">
                                                <div class="block-header">
                                                    <h3 class="block-title">{{trans('licence.organizations-list')}}</h3>
                                                </div>
                                                <div class="block-content animated fadeIn">
                                                    <ul class="fa-ul">
                                                        @foreach($licence->organizations as $organization)
                                                            <li><i class="fa fa-check fa-li"></i>{{$organization->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                                <br/>
                                            </div>
                                        @else
                                            <div class="block">
                                                <div class="block-header">
                                                    <h3 class="block-title">{{trans('licence.no-organizations')}}</h3>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{action('Admin\LicenceController@index')}}" class="btn btn-flat btn-sm btn-info" type="button">
                            <i class="fa fa-arrow-left"></i> {{trans('licence.back-action')}}
                        </a>
                        <a href="{{action('Admin\LicenceController@edit', $licence->id)}}" class="btn btn-flat btn-sm btn-success" type="button">
                            <i class="fa fa-pencil"></i> {{trans('licence.edit-action')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection