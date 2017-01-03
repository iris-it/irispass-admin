@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('show_group', $group->id))

@section('content')

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('groups.show') }}</h3>
            </div>
            <div class="box-body">

                <h1>{{$group->name}}</h1>

                <a class="btn btn-primary" id="groups-edit" href="{{action('GroupsController@edit', ['id' => $group->id])}}">{{ trans('groups.edit') }}</a>

            </div>
        </div>
    </section>

@stop