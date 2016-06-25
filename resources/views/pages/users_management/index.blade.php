@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('usersmanagement'))

@section('content')

    <section class="content">

        <div class="row">
            <div class="col-lg-6 col-xs-12">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$users->count()}}</h3>
                        <p>{{ trans('usersmanagement.info-user-number') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>


                    <a href="{{action('UsersController@create')}}" class="small-box-footer">
                        {{ trans('users.create') }} <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-xs-12">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$groups->count()}}</h3>
                        <p>{{ trans('usersmanagement.info-group-number') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-folder"></i>
                    </div>
                    <a href="{{action('GroupsController@create')}}" class="small-box-footer">
                        {{ trans('groups.create') }} <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#orgausers">{{ trans('usersmanagement.userstab-label') }}</a></li>
                        <li><a data-toggle="tab" href="#orgagroups">{{ trans('usersmanagement.groupstab-label') }}</a></li>
                        <li><a data-toggle="tab" href="#orgagroupsaccess">{{ trans('usersmanagement.groupsaccesstab-label') }}</a></li>
                    </ul>
                    <div class="tab-content">

                        @include('pages.users_management.partials.orgausers')

                        @include('pages.users_management.partials.orgagroups')

                        @include('pages.users_management.partials.orgagroupsaccess')

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection