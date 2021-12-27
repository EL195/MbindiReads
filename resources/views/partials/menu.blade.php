<div id="sidebar-disable" class="sidebar-disable hidden"></div>

<div id="sidebar" class="sidebar-menu transform -translate-x-full ease-in">
    <div class="flex items-center justify-center mt-4">
        <div class="flex items-center">
            <span class="text-white text-2xl mx-2 font-semibold">
            <a href="{{ route("admin.home") }}">
               <img style="border-style: none;" src="{{ asset('img/logo.png')}}" />
            </span>
            </a>
        </div>
    </div>

    <nav class="mt-4">
    @can('user_management_access')
        <a class="nav-link ? ' active' : '' }}" href="{{ route("admin.home") }}">
            <i class="fas fa-fw fa-tachometer-alt">
            </i>
            <span class="mx-4">{{ trans('cruds.global.manual') }}</span>
        </a>
        <!-- Management section -->
       <a  style="background:black;color: white !important; pointer-events: none;cursor: default;" class="nav-link ? ' active' : '' }}" href="" disabled>
            <span class="mx-4">{{ trans('cruds.global.rmanagement') }}</span>
        </a>

        <a class="nav-link ? ' active' : '' }}" href="{{ route('admin.ressources.index') }}">
            <i class="fa-fw fas fa-book"> </i>
            <span class="mx-4">{{ trans('cruds.menu.ressources') }}</span>
        </a>
        <a class="nav-link ? ' active' : '' }}" href="{{ route('admin.subjects.index') }}">
            <i class="fa-fw fas fa-user"> </i>
            <span class="mx-4">{{ trans('cruds.menu.subjects') }}</span>
        </a>
        <a class="nav-link ? ' active' : '' }}" href="{{ route('admin.genres.index') }}">
            <i class="fa-fw fas fa-bars"> </i>
             <span class="mx-4">{{ trans('cruds.menu.genres') }}</span>
        </a>
        <a class="nav-link ? ' active' : '' }}" href="{{ route('admin.themes.index') }}">
            <i class="fa-fw fas fa-align-justify"> </i>
             <span class="mx-4">{{ trans('cruds.menu.themes') }}</span>
        </a>
      <!-- Settings section -->
       <a  style="background:black;color: white !important; pointer-events: none;cursor: default;" class="nav-link ? ' active' : '' }}" href="" disabled>
            <span class="mx-4">{{ trans('cruds.global.settings') }}</span>
        </a>

        <a class="nav-link ? ' active' : '' }}" href="{{ route('admin.levels.index') }}">
            <i class="fa-fw fas fa-level-up-alt"> </i>
            <span class="mx-4">{{ trans('cruds.menu.level') }}</span>
        </a>
        <a class="nav-link ? ' active' : '' }}" href="{{ route('admin.memberships.index') }}">
            <i class="fa-fw fas fa-id-card"> </i>
             <span class="mx-4">{{ trans('cruds.menu.memberships') }}</span>
        </a>
        <a class="nav-link ? ' active' : '' }}" href="{{ route('admin.awards.index') }}">
            <i class="fa-fw fas fa-award"> </i>
             <span class="mx-4">{{ trans('cruds.menu.awards') }}</span>
        </a>
        <a class="nav-link ? ' active' : '' }}" href="{{ route('admin.agegroups.index') }}">
            <i class="fa-fw fas fa-users"> </i>
             <span class="mx-4">{{ trans('cruds.menu.agegroup') }}</span>
        </a>
        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="fa-fw fas fa-book-reader"></i>
                <span class="mx-4">{{ trans('cruds.user.title') }}</span>
        </a>
        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.payement.index') }}">
            <i class="fa-fw fas fa-money"></i>
                <span class="mx-4">{{ trans('cruds.global.payements') }}</span>
        </a>
        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.notifications.index') }}">
            <i class="fa-fw fas fa-bell"></i>
                <span class="mx-4">{{ trans('cruds.global.notifications') }}</span>
        </a>
        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.langues.index') }}">
            <i class="fa-fw fas fa-language"></i>
                <span class="mx-4">{{ trans('cruds.global.langues') }}</span>
        </a>
    @endcan
      <!-- My account section -->
       <a  style="background:black;color: white !important; pointer-events: none;cursor: default;" class="nav-link ? ' active' : '' }}" href="" disabled>
            <span class="mx-4">{{ trans('cruds.global.myaccount') }}</span>
        </a>
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            <a class="nav-link{{ request()->is('profile/password') ? ' active' : '' }}" href="{{ route('profile.password.edit') }}">
                <i class="fa-fw fas fa-key">

                </i>

                <span class="mx-4">{{ trans('global.change_password') }}</span>
            </a>
        @endif
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
            <i class="fa-fw fas fa-sign-out-alt">
            </i>
            <span class="mx-4">{{ trans('global.logout') }}</span>
        </a>

{{-- 
        @can('user_management_access')
            <div class="nav-dropdown">
                <a class="nav-link" href="#">
                    <i class="fa-fw fas fa-users">

                    </i>

                    <span class="mx-4">{{ trans('cruds.userManagement.title') }}</span>
                    <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                </a>
                <div class="dropdown-items mb-1 hidden">
                        @can('permission_access')
                        <a class="nav-link{{ request()->is('admin/permissions*') ? ' active' : '' }}" href="{{ route('admin.permissions.index') }}">
                            <i class="fa-fw fas fa-unlock-alt">

                            </i>

                            <span class="mx-4">{{ trans('cruds.permission.title') }}</span>
                        </a>
                    @endcan
                    @can('role_access')
                        <a class="nav-link{{ request()->is('admin/roles*') ? ' active' : '' }}" href="{{ route('admin.roles.index') }}">
                            <i class="fa-fw fas fa-briefcase">

                            </i>

                            <span class="mx-4">{{ trans('cruds.role.title') }}</span>
                        </a>
                    @endcan
                    @can('user_access')
                        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="fa-fw fas fa-user">

                            </i>

                            <span class="mx-4">{{ trans('cruds.user.title') }}</span>
                        </a>
                    @endcan
                </div>
            </div>
        @endcan
        @can('project_access')
            <a class="nav-link{{ request()->is('admin/projects*') ? ' active' : '' }}" href="{{ route('admin.projects.index') }}">
                <i class="fa-fw fas fa-project-diagram">

                </i>

                <span class="mx-4">{{ trans('cruds.project.title') }}</span>
            </a>
        @endcan
        @can('folder_access')
            <a class="nav-link{{ request()->is('admin/folders*') ? ' active' : '' }}" href="{{ route('admin.folders.index') }}">
                <i class="fa-fw fas fa-folder">

                </i>

                <span class="mx-4">{{ trans('cruds.folder.title') }}</span>
            </a>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            <a class="nav-link{{ request()->is('profile/password') ? ' active' : '' }}" href="{{ route('profile.password.edit') }}">
                <i class="fa-fw fas fa-key">

                </i>

                <span class="mx-4">{{ trans('global.change_password') }}</span>
            </a>
        @endif
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
            <i class="fa-fw fas fa-sign-out-alt">

            </i>

            <span class="mx-4">{{ trans('global.logout') }}</span>
        </a> --}}
    </nav>
</div>
