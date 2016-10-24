<div id="orgagroups" class="tab-pane cont">

    @if($groups->count() != 0)


        <table class="table table-hover">
            <thead>
            <tr>
                <td><b>{{ trans('usersmanagement.groupstab-name') }}</b></td>
                <td><b>{{ trans('usersmanagement.groupstab-users-allowed') }}</b></td>
                <td><b>{{ trans('usersmanagement.groupstab-creation') }}</b></td>
                <td><b>{{ trans('usersmanagement.groupstab-update') }}</b></td>
                <td><b>{{ trans('usersmanagement.groupstab-show') }}</b></td>
                <td><b>{{ trans('usersmanagement.groupstab-destroy') }}</b></td>
            </tr>
            </thead>
            <tbody class="no-border-x no-border-y">

            @foreach($groups as $group)

                <tr>
                    <td>{{$group->name}}</td>
                    <td>{{$group->users()->count()}}</td>
                    <td>{{$group->created_at->diffForHumans()}}</td>
                    <td>{{$group->updated_at->diffForHumans()}}</td>
                    <td><a class="btn btn-primary btn-flat" href="{{action('GroupsController@show',['id' => $group->id])}}">{{trans('usersmanagement.groupstab-show-button')}}</a></td>
                    <td>

                        {!! Form::open(['method' => 'DELETE','action' => ['GroupsController@destroy', $group->id]]) !!}

                        {!! Form::submit(trans('usersmanagement.groupstab-destroy-button'), ['class' => 'btn btn-danger btn-flat', 'name' => 'submit-group-delete', 'onclick' => 'if(!confirm(\''.trans('usersmanagement.groupstab-destroy-confirmation').'\')){return false;}']) !!}

                        {!! Form::close() !!}

                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>


    @else

        <p>{{ trans('usersmanagement.groupstab-no-group') }} {{$organization->name}}. <a class="btn btn-success btn-flat pull-right" href="{{action('GroupsController@create')}}">{{ trans('groups.create')}}</a></p>

    @endif

</div>