<div id="sidebar-disable" class="sidebar-disable hidden"></div>

<div id="sidebar" class="sidebar-menu transform -translate-x-full ease-in">
    <div class="flex items-center justify-center mt-4">
        <div class="flex items-center">
            <span class="text-white text-2xl mx-2 font-semibold">
            <a href="#">
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
{{--         <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.notifications.index') }}">
            <i class="fa-fw fas fa-bell"></i>
                <span class="mx-4">{{ trans('cruds.global.notifications') }}</span>
        </a> --}}
        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.langues.index') }}">
            <i class="fa-fw fas fa-language"></i>
                <span class="mx-4">{{ trans('cruds.global.langues') }}</span>
        </a>







    @else
        <!-- Management section -->
       <a  style="background:black;color: white !important; pointer-events: none;cursor: default;" class="nav-link ? ' active' : '' }}" href="" disabled>
            <span class="mx-4">{{ trans('cruds.global.management') }}</span>
        </a>
        @can('folder_show') 
        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.students.index') }}">
            <i class="fa-fw fas fa-user"></i>
                <span class="mx-4">{{ trans('cruds.global.students') }}</span>
        </a>
        @endcan
        @can('folder_access') 
        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.classes.index') }}">
            <i class="fa-fw fas fa-users"></i>
                <span class="mx-4">{{ trans('cruds.global.classes') }}</span>
        </a>
        @endcan
        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.payement.index') }}">
            <i class="fa-fw fas fa-money"></i>
                <span class="mx-4">{{ trans('cruds.global.payements') }}</span>
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
    </nav>
</div>
