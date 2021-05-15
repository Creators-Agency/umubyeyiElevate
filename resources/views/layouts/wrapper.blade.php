<!DOCTYPE html>
<html lang="en">

    <head>
        @include('layouts/header')
    </head>

    <body class="">
        @include('sweet::alert')
        <div class="wrapper ">
            @include('layouts/sidebar')
            <div class="main-panel">
                <!-- Navbar -->
                @include('layouts/navbar')
                <!-- End Navbar -->
                @yield('content')
            </div>
        </div>
        <!-- footer -->
        @include('layouts/footer')
    </body>

</html>