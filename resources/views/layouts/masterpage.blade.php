<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>admin panel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('themes/') }}/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('themes/') }}/dist/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('themes/') }}/plugins/iCheck/flat/blue.css">

    {{--<link rel="stylesheet" href="{{ url('themes/') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">--}}
    <link rel="stylesheet" href="{{ url('themes/') }}/dist/css/mystyle.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{ url('themes/') }}/dist/css/bootstrap.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{ url('themes/') }}/dist/css/style.css">
    <title>jQuery UI Datepicker - Default functionality</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="{{ url('themes/') }}/plugins/iCheck/all.css">
    <link rel="stylesheet" href="{{ url('themes/') }}/plugins/select2/select2.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom" style="z-index: 0">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url("Dashboard") }}" class="nav-link">home</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url("Dashboard") }}" class="brand-link">
            {{--<img src="{{ url("uploads/logo/".\App\Settings::where("key","logo")->value("value")) }}" alt="{{ \App\Settings::where("key","title")->value("value") }}" class="brand-image img-circle elevation-3"--}}
                 {{--style="opacity: .8">--}}
            <span class="brand-text font-weight-light">Panel</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="direction: ltr">
            <div>
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">

                    </div>
                    <div class="info">
                        <a href="{{ url('Profile') }}" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{ url('Dashboard')}}" class="nav-link @if(url()->current() == url('Dashboard')) active @endif ">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('Profile')}}" class="nav-link @if(url()->current() == url('Profile')) active @endif ">
                                <i class="nav-icon fa fa-user-o"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview @if(url()->current() == url('Task/Add') || url()->current() == url('Task/Edit/'.@$Edit['id']) || url()->current() == url('Task/List') || url()->current() == url('Task/Filter')) menu-open @endif">
                            <a href="#" class="nav-link @if(url()->current() == url('Task/Add') || url()->current() == url('Task/Edit/'.@$Edit['id']) || url()->current() == url('Task/List') || url()->current() == url('Task/Filter')) active @endif">
                                <i class="nav-icon fa fa-tasks"></i>
                                <p>
                                    Tasks
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('Task/Add')}}" class="nav-link @if(url()->current() == url('Task/Add') || url()->current() == url('Task/Edit/'.@$Edit['id'])) active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Add</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Task/List')}}" class="nav-link @if(url()->current() == url('Task/List') || url()->current() == url('Task/Filter')) active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('logout')}}" class="nav-link">
                                <i class="nav-icon fa fa-sign-out"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>




                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        @if(Session::has('messages'))
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><strong>Done :</strong>{{ Session::get('messages') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
        </div>
        @endif
        <!-- /.card -->
        @if(Session::has('messagee'))
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><strong>Error :</strong>{{ Session::get('messagee') }}</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
            </div>
        @endif
    @if(count($errors) > 0)

                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">occurred this error(s):</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ol id="ul">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
        @endif
 @yield('content')

</div>
<!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ url('themes/') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{--<script>--}}
    {{--$.widget.bridge('uibutton', $.ui.button)--}}
{{--</script>--}}
<!-- Bootstrap 4 -->
<script src="{{ url('themes/') }}/plugins/iCheck/icheck.min.js"></script>
<script src="{{ url('themes/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<script src="{{ url('themes/') }}/https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<!-- Sparkline -->
<!-- jvectormap -->
<!-- jQuery Knob Chart -->
<script src="{{ url('themes/') }}/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="{{ url('themes/') }}/https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

<script src="{{ url('themes/') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ url('themes/') }}/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('themes/') }}/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('themes/') }}/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
{{--<script src="{{ url('themes/') }}/dist/js/demo.js"></script>--}}
<script src="{{ url('themes/') }}/plugins/select2/select2.full.min.js"></script>
{{--<script src="{{ url('themes/') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>--}}
<script src="{{ url('themes/') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="{{ url('themes/') }}/plugins/chartjs-old/Chart.min.js"></script>
<?php
        $x = 0;
        $time_data = '';
        $previous = '';
        $number_data = 1;
        $n_d = '';
        if (@count($not_completed) > 0){
            foreach ($not_completed as $nc){
                $d_t = date('H:i',strtotime($nc['created_at']));
                if ($previous != $d_t){
                    $n_d .= $number_data;
                    $number_data = 1;
                    $time_data .= "\"" . $d_t . "\"";
                    if ($x < count($not_completed)){
                        $n_d .= ",";
                        $time_data .= ",";
                    }
                }else{
                    $number_data++;
                }
                $previous = $d_t;
                $x++;
            }
        }
?>
<script>


    $(function () {

        $( "#datepicker" ).datepicker();

        var areaChartData = {
            // labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60],
            labels: [<?= @$time_data ?>],
            datasets: [
                {
                    label: 'Electronics',
                    fillColor: 'rgba(210, 214, 222, 1)',
                    strokeColor: 'rgba(210, 214, 222, 1)',
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [{{ $n_d }}],
                },
            ]
        };

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };

        var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        lineChart.Line(areaChartData, lineChartOptions);
        $('.select2').select2();


        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-red'

        });
        $("input[type=\"checkbox\"]").on("ifChanged", category_input_checker);
        $("input[type=\"radio\"]").on("ifChanged", category_input_checker);
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    });
</script>
</body>
</html>



