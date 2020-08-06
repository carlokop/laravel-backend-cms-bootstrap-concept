<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{asset('administrator/assets/css/libs.css')}}">
    <link rel="stylesheet" href="{{asset('administrator/assets/css/admin.css')}}">
    @yield('css')
    <title>{{$title}}</title>
</head>

<body>

    <div class="dashboard-main-wrapper">
        {{-- Navbar on top --}}
        @include('admin.partials._navbarTop')

        {{-- Sidebar with menu --}}
        @include('admin.partials._sidebar')

        {{-- Main content --}}
        <div class="dashboard-wrapper">
            <div class="influence-profile">
                <div class="container-fluid dashboard-content ">
                    @include('admin.partials._breadcrumbs')
                    @yield('main')
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('administrator/assets/js/libs.js')}}"></script>
    <script src="{{asset('administrator/assets/js/custom-es5-backend.js')}}"></script>
    @yield('js')
</body>
 
</html>