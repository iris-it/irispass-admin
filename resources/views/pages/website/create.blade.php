@extends('layouts.app')

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('website.create') }}</h3>
                    </div>
                    <div class="box-body">
                        @include('errors.list')

                        {!! Form::open(['method' => 'POST','action' => 'WebsiteController@store']) !!}

                        @include('pages.website.partials.form')

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection