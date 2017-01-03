<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header text-center">{{ trans('menu.title') }}</li>

            <li><a href="{{ action('OrganizationController@index') }}"><i class="fa fa-briefcase text-aqua"></i> <span>{{ trans('menu.organization') }}</span></a></li>

            <li><a href="{{ action('UsersManagementController@index') }}"><i class="fa fa-user text-aqua"></i> <span>{{ trans('menu.usersmanagement') }}</span></a></li>

            <li><a href="{{ action('WebsiteController@index') }}"><i class="fa fa-user text-aqua"></i> <span>{{ trans('menu.cms') }}</span></a></li>

            <li><a href="#"><i class="fa fa-suitcase text-aqua"></i> <span>CRM</span></a></li>

            <li><a href="#"><i class="fa fa-envelope text-aqua"></i> <span>Mails</span></a></li>

            <li><a href="#"><i class="fa fa-folder-open text-aqua"></i> <span>Mes dossiers</span></a></li>

            <li><a href="#"><i class="fa fa-slack text-aqua"></i> <span>Chat</span></a></li>

            <li><a href="#"><i class="fa fa-file-word-o text-aqua"></i> <span>Bureautique</span></a></li>


            @can('permission::access_flow_admin_section')
                <li class="header">{{ trans('menu.admin-role') }}</li>

                <li class="treeview"><a href="#">
                        <span>{{ trans('menu.admin-section') }}</span>
                        <i class="fa fa-angle-left pull-right text-aqua"></i>
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
            @endcan


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