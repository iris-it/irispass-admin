@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('licences'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('licence.list')}} ({{$licences->count()}})</h3>
                        <div class="box-tools">
                            <a href="{{action('Admin\LicenceController@create')}}" class="btn btn-flat btn-default pull-right">
                                <i class="fa fa-key"></i> {{trans('licence.create-action')}}
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{trans('licence.table-name')}}</th>
                                <th>{{trans('licence.table-identifier')}}</th>
                                <th>{{trans('licence.table-desc')}}</th>
                                <th>{{trans('licence.table-outlets-number')}}</th>
                                <th>{{trans('licence.organizations-count')}}</th>
                                <th>{{trans('user.table-actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($licences as $licence)
                                <tr>
                                    <td>{{$licence->name}}</td>
                                    <td>{{$licence->identifier}}</td>
                                    <td>{{$licence->description}}</td>
                                    <td>{{$licence->outlet_number}}</td>
                                    <td>{{$licence->organizations()->count()}}</td>
                                    <td>
                                        <a href="{{action('Admin\LicenceController@show', $licence->id)}}" class="btn btn-flat btn-default" type="button" data-toggle="tooltip" title="{{trans('licence.show-action')}}"><i class="fa fa-eye"></i></a>
                                        <a href="{{action('Admin\LicenceController@edit', $licence->id)}}" class="btn btn-flat btn-info" type="button" data-toggle="tooltip" title="{{trans('licence.edit-action')}}"><i class="fa fa-pencil"></i></a>
                                        <a href="{{action('Admin\LicenceController@destroy',['id' => $licence->id])}}" class="btn btn-flat btn-danger" data-method="DELETE"  data-toggle="tooltip" title="{{trans('licence:delete-action')}}" data-token="{{csrf_token()}}" data-confirm="{{trans('app.licence.delete-action-warning')}}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {!! $licences->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection