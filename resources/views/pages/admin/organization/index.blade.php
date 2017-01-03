@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('organizations'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('organization.list')}} ({{$organizations->count()}})</h3>
                        <div class="box-tools">
                            <a href="{{action('Admin\OrganizationController@create')}}" class="btn btn-flat btn-default pull-right">
                                <i class="fa fa-building"></i> {{trans('organization.create-action')}}
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{trans('organization.table-name')}}</th>
                                <th>{{trans('organization.table-email')}}</th>
                                <th>{{trans('organization.table-owner')}}</th>
                                <th>{{trans('organization.table-status')}}</th>
                                <th>{{trans('organization.table-licence')}}</th>
                                <th>{{trans('organization.users-count')}}</th>
                                <th>{{trans('user.table-actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($organizations as $organization)
                                <tr>
                                    <td>{{$organization->name}}</td>
                                    <td>{{$organization->email}}</td>
                                    @if($organization->owner)
                                        <td>{{$organization->owner->username}}</td>
                                    @else
                                        <td>{{trans('organization.no-owner')}}</td>
                                    @endif
                                    <td>{{$organization->status}}</td>
                                    @if($organization->licence)
                                        <td>{{$organization->licence->name}}</td>
                                    @else
                                        <td>{{trans('licence.no-licence')}}</td>
                                    @endif
                                    <td>{{$organization->users()->count()}}</td>
                                    <td>
                                        <a href="{{action('Admin\OrganizationController@show', $organization->id)}}" class="btn btn-flat btn-default" type="button" data-toggle="tooltip" title="{{trans('organization.show-action')}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{action('Admin\OrganizationController@edit', $organization->id)}}" class="btn btn-flat btn-info" type="button" data-toggle="tooltip" title="{{trans('organization.edit-action')}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{action('Admin\OrganizationController@destroy',['id' => $organization->id])}}" class="btn btn-flat btn-danger" data-method="DELETE" data-toggle="tooltip" title="{{trans('organization:delete-action')}}" data-token="{{csrf_token()}}" data-confirm="{{trans('app.organization.delete-action-warning')}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {!! $organizations->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection