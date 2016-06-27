<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header text-center">{{ trans('menu.title') }}</li>

            <li><a href="{{ action('OrganizationController@index') }}"><i class="fa fa-briefcase"></i> <span>{{ trans('menu.organization') }}</span></a></li>

            <li><a href="{{ action('UsersManagementController@index') }}"><i class="fa fa-user"></i> <span>{{ trans('menu.usersmanagement') }}</span></a></li>

            <li><a href="{{ action('WebsiteController@index') }}"><i class="fa fa-user"></i> <span>{{ trans('menu.cms') }}</span></a></li>

            @can('permission::access_flow_admin_section')
            @endcan

            <li class="header">{{ trans('menu.admin-role') }}</li>

            <li class="treeview"><a href="#">
                    <span>{{ trans('menu.admin-section') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ action('Admin\UserController@index') }}">{{trans('menu.admin-users-link')}}</a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\OrganizationController@index') }}">{{trans('menu.admin-organizations-link')}}</a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\RoleController@index') }}">{{trans('menu.admin-roles-link')}}</a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\PermissionController@index') }}">{{trans('menu.admin-permissions-link')}}</a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\LicenceController@index') }}">{{trans('menu.admin-licences-link')}}</a>
                    </li>
                </ul>
            </li>
            {{--@endcan--}}


        </ul>
    </section>
</aside>

@section('scripts')
    @parent
    <script type="text/javascript">
        $(function () {
            var path = "{{Request::url()}}";
            $(".sidebar-menu a").each(function () {
                var href = $(this).attr('href');
                if (path.substring(0, href.length) === href) {
                    $(this).closest('li').addClass('active');
                    $(this).closest('li').parent().closest('li').addClass('menu-open active');
                    $(this).closest('li').parent().closest('li').parent().closest('li').addClass('menu-open active');
                }
            });
        });
    </script>
@endsection