<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('admin_assets/css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin_assets/vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin_assets/vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="{{asset('admin_assets/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin_assets/vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin_assets/css/theme.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" integrity="sha512-UuQ/zJlbMVAw/UU8vVBhnI4op+/tFOpQZVT+FormmIEhRSCnJWyHiBbEVgM4Uztsht41f3FzVWgLuwzUqOObKw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<body>
<div class="">
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <li class="@yield('dashboard_select')">
                        <a href="{{url('home')}}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>

                    @can('assign role')
                    <li class="@yield('role_select')">
                        <a href="{{url('role/show')}}">
                        <i class="fa-regular fa-circle-user"></i> Roles</a>
                    </li>
                    @endcan

                    @can('assign permission')
                    <li class="@yield('permission_select')">
                        <a href="{{url('permission/show')}}">
                        <i class="fas fa-paint-brush"></i> Permissions </a>
                    </li>
                    @endcan

                    @can('assign order')
                    <li class="@yield('order_select')">
                        <a href="{{url('order/show')}}">
                        <i class="fa-brands fa-jedi-order"></i> Orders</a>
                    </li>
                    @endcan

                    @can('assign finance')
                    <li class="@yield('finance_select')">
                        <a href="{{url('finance/show')}}">
                        <i class="fa-solid fa-coins"></i> Finance</a>
                    </li>
                    @endcan

                    @can('assign marketing')
                    <li class="@yield('marketing_select')">
                        <a href="{{url('marketing/show')}}">
                        <i class="fa-solid fa-shop"></i> Marketing</a>
                    </li>
                    @endcan

                    @can('assign blog')
                    <li class="@yield('blog_select')">
                        <a href="{{url('blog/show')}}">
                        <i class="fa-solid fa-blog"></i> Blogs</a>
                    </li>
                    @endcan    

                    @can('assign user')
                    <li class="@yield('user_select')">
                        <a href="{{url('user/show')}}">
                        <i class="fa-solid fa-user"></i> Users</a>
                    </li>
                    @endcan
                </ul>
            </nav>
        </div>
    </aside>
</div>

    <script src="{{asset('admin_assets/vendor/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('admin_assets/vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{asset('admin_assets/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin_assets/vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('admin_assets/js/main.js')}}"></script>
</body>
</html>

