<div id="orgausers" class="tab-pane active cont">

    @if($users->count() != 0)

        <table class="table table-hover">
            <thead>
            <tr>
                <td><b>{{ trans('usersmanagement.userstab-identifier') }}</b></td>
                <td><b>{{ trans('usersmanagement.userstab-username') }}</b></td>
                <td><b>{{ trans('usersmanagement.userstab-creation') }}</b></td>
                <td><b>{{ trans('usersmanagement.userstab-update') }}</b></td>
                <td><b>{{ trans('usersmanagement.userstab-show') }}</b></td>
                <td><b>{{ trans('usersmanagement.userstab-destroy') }}</b></td>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)

                <tr>
                    <td>{{$user->given_name}}</td>
                    <td>{{$user->family_name}}</td>
                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td>{{$user->updated_at->diffForHumans()}}</td>
                    <td><a class="btn btn-primary btn-flat" href="{{action('UsersController@show',['id' => $user->id])}}">{{trans('usersmanagement.userstab-show-button')}}</a></td>
                    <td>
                        @if($user->id != Auth::user()->id)
                            <a class="btn btn-danger btn-flat"
                               href="{{action('UsersController@destroy',['id' => $user->id])}}"
                               data-method="DELETE"
                               data-token="{{csrf_token()}}"
                               data-confirm="{{trans('usersmanagement.userstab-destroy-confirmation')}}">
                                {{trans('usersmanagement.userstab-destroy-button')}}
                            </a>
                        @endif
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    @else

        <p>{{ trans('usersmanagement.userstab-no-user') }} {{$organization->name}}. <a class="btn btn-success btn-flat pull-right" href="{{action('UsersController@create')}}">{{ trans('users.create')}}</a></p>

    @endif

</div>