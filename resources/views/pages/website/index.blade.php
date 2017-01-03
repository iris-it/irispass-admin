@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('organization'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('website.index') }}</h3>
                    </div>
                    <div class="box-body">
                        @if($website && $website->is_active)
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="avatar">
                                                <i class="fa fa-globe fa-5x"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="personal">
                                                <h3 class="name">{{$website->identifier}}</h3>

                                                <table class="table table-hover">
                                                    <tbody>
                                                    <tr>
                                                        <td><b>{{ trans('website.url') }} :</b></td>
                                                        <td><a target="_blank" href="http://{{str_slug($organization->name, "-").'.irispass.fr'}}">{{str_slug($organization->name, "-").'.irispass.fr'}}</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>{{ trans('website.email-field') }} :</b></td>
                                                        <td>{{$website->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>{{ trans('website.username-field') }} :</b></td>
                                                        <td>{{$website->username}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#websiteactiontab">{{ trans('website.actions-label') }}</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="websiteactiontab" class="tab-pane active cont">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <td><b>{{ trans('website.websiteactiontab-identifier') }}</b></td>
                                                        <td><b>{{ trans('website.websiteactiontab-destroy') }}</b></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$website->identifier}}</td>
                                                        <td>
                                                            <a class="btn btn-danger btn-flat"
                                                               href="{{action('WebsiteController@destroy',['id' => $website->id])}}"
                                                               data-method="DELETE"
                                                               data-token="{{csrf_token()}}"
                                                               data-confirm="{{trans('website.destroy-confirmation')}}">
                                                                {{trans('website.destroy-button')}}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="isp-label"> {{trans('website.info-no-cms')}}
                                <a class="btn btn-success pull-right" href="{{action('WebsiteController@create')}}">{{ trans('website.create')}}</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection