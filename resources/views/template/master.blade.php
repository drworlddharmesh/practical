<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>test</title>

    <link rel="icon" type="image/png" sizes="32x32" href="#">

    <!-- Header links Start -->
    @include('template.header-links')
    <!-- End Header links -->

    @yield('header-css')
</head>

<body>



    <div id="wrapper">

        <!-- Sidebar Start -->
        @include('template.sidebar')
        <!-- End Sidebar -->

        <!-- Main Header Start -->
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>

                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome to test</span>
                        </li>

                        <li>
                            <a href="{{ url('admin/logout') }}">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Main Header End -->

            @yield('main-content')

            <!-- Footer Area Start -->
            <div class="footer">
                <div>
                    <strong>Copyright</strong> test &copy; <?php echo date('Y'); ?>
                </div>
            </div>
            <!-- End Footer Area -->
        </div>
    </div>

    <!-- Footer links Start -->
    @include('template.footer-scripts')
    <!-- End Footer links -->

    @yield("footer")
</body>

</html>