<header class="main-nav">
    <nav>
        <div class="main-navbar">
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
{{--                    <li class="sidebar-main-title">--}}
{{--                        <div>--}}
{{--                            <h6>General</h6>--}}
{{--                        </div>--}}
{{--                    </li>--}}
                    <li class="dropdown mt-2"><a class="nav-link menu-title link-nav {{request()->route()->getName()=='backend.dashboard' ? 'active' : ''}}" href="{{route('backend.dashboard')}}" ><i data-feather="home"></i><span>Dashboard</span></a></li>
                    @can('inquiry.list')
                        <li class="dropdown mt-2"><a class="nav-link menu-title link-nav {{in_array(request()->route()->getName(),['backend.inquiry.index', 'backend.inquiry.edit']) ? 'active' : ''}}" href="{{route('backend.inquiry.index')}}" > <i data-feather="server"></i> <span>Registeration Inquiry</span></a></li>
                    @endcan
            
                    @can('user.list')
                        <li class="dropdown mt-2"><a class="nav-link menu-title link-nav {{in_array(request()->route()->getName(),['backend.user.index', 'backend.user.edit']) ? 'active' : ''}}" href="{{route('backend.user.index')}}" ><i data-feather="user"></i><span>User Management</span></a></li>
                    @endcan
                    @can('role.list')
                    <li class="dropdown mt-2"><a class="nav-link menu-title link-nav {{in_array(request()->route()->getName(),['backend.role.index', 'backend.role.edit']) ? 'active' : ''}}" href="{{route('backend.role.index')}}" ><i data-feather="users"></i><span>Role Management</span></a></li>
                    @endcan
                </ul>
            </div>
        </div>
    </nav>
</header>
