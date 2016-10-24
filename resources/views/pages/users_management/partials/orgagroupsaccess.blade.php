<div id="orgagroupsaccess" class="tab-pane cont">

    @if($users->count() > 0 || $groups->count() > 0)

        <div class="row">
            <div class="col-md-12">
                <h3>{{ trans('usersmanagement.groupaccesstab-index') }}</h3>
                <p>{{ trans('usersmanagement.groupaccesstab-description') }}</p>
            </div>
        </div>

        @foreach($groups->chunk(3) as $groups)
            <div class="row">
                @foreach($groups as $group)

                    <div class="col-md-4 col-lg-4">
                        <div class="box box-primary box-access">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-folder"></i> {{$group->name}}</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-border hover">
                                        <thead class="no-border">
                                        <tr>
                                            <th><strong>{{trans('usersmanagement.groupaccesstab-username')}}</strong></th>
                                            <th><strong>{{trans('usersmanagement.groupaccesstab-status')}}</strong></th>
                                        </tr>
                                        </thead>
                                        <tbody class="no-border-y">
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->given_name}} {{$user->family_name}}</td>
                                                <td>
                                                    @if($group->users->contains('id', $user->id))
                                                        {!! Form::open(['method' => 'POST','action' => ['GroupsController@removeUserFromGroup', 'groupId' => $group->id,'userId' => $user->id]]) !!}
                                                        <button class="btn btn-block btn-danger btn-flat" name="submit-usergroup-disable" type="submit">{{trans('usersmanagement.groupaccesstab-disable')}}</button>
                                                        {!! Form::close() !!}
                                                    @else
                                                        {!! Form::open(['method' => 'POST','action' => ['GroupsController@addUserToGroup','groupId' => $group->id,'userId' => $user->id]]) !!}
                                                        <button class="btn btn-block btn-primary btn-flat" name="submit-usergroup-enable" type="submit">{{trans('usersmanagement.groupaccesstab-enable')}}</button>
                                                        {!! Form::close() !!}

                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @endforeach

    @elseif($users->count() == 0 && $groups->count() == 0)
        <div class="btn-group pull-right">
            <a class="btn btn-success btn-flat" href="{{action('GroupsController@create')}}">{{ trans('groups.create') }}</a>
            <a class="btn btn-success btn-flat" href="{{action('UsersController@create')}}">{{ trans('users.create') }}</a>
        </div>
        <p>
            {{ trans('usersmanagement.groupaccesstab-no-user-no-group') }}
        </p>
    @elseif($users->count() == 0)
        <p>
            {{ trans('usersmanagement.groupaccesstab-no-user') }}
            <a class="btn btn-primary btn-flat pull-right" href="{{action('UsersController@create')}}">{{ trans('users.create') }}</a>
        </p>
    @elseif($groups->count() == 0)
        <p>
            {{ trans('usersmanagement.groupaccesstab-no-group') }}
            <a class="btn btn-primary btn-flat pull-right" href="{{action('GroupsController@create')}}">{{ trans('groups.create') }}</a>
        </p>
    @endif

</div>