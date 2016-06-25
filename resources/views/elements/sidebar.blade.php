<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header text-center">{{ trans('menu.title') }}</li>

            <li><a href="{{ action('OrganizationController@index') }}"><i class="fa fa-briefcase"></i> <span>{{ trans('menu.organization') }}</span></a></li>

            <li><a href="{{ action('UsersManagementController@index') }}"><i class="fa fa-user"></i> <span>{{ trans('menu.usersmanagement') }}</span></a></li>


        </ul>
    </section>
</aside>
