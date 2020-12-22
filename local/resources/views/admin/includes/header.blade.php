{{! $user = auth()->user() }}
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <span class="logo-mini"><b><img src="{{ asset("logo/logo.png") }}" width="30px"></b></span>
        <span class="logo-lg"><img src="{{ asset("logo/logo.png") }}" width="30px"></b> <b>{{ transLang('company') }}</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ transLang('toggle_navigation') }}</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li style="padding:7px;">
                    <a href="{{ route('admin.change.locale', ['lang' => (getSessionLang() == 'en' ? 'ar' : 'en')]) }}" class="btn change-lang-btn">
                        {{ getSessionLang() == 'en' ? transLang('ar') : transLang('en') }}
                    </a>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if($user->profile_image)
                            <img src="{{ imageBasePath($user->profile_image) }}" class="user-image">
                        @else 
                            <img src="{{ imageBasePath('backend/images/default-user.png') }}" class="user-image">
                        @endif
                        <span class="hidden-xs">{{ $user->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            @if($user->profile_image)
                            <img src="{{ imageBasePath($user->profile_image) }}" class="img-circle"> @else
                            <img src="{{ imageBasePath('backend/images/default-user.png')}}" class="img-circle"> @endif
                            <p>{{ $user->name }}</p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('admin.profile.details') }}" class="btn btn-default btn-flat">{{ transLang('profile') }}</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">{{ transLang('sign_out') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>