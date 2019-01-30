<!DOCTYPE html>
<html lang="en">

@include('home.head_metadata')

<body>

    <!-- Navigation -->
    @include('home.home_nav')

    <!-- Page Content -->
    @yield('content')
   
    <!-- Footer -->
    @include('home.home_footer')

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
