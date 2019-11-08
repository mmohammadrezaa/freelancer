@extends('layouts/masterpage')
@section('content')
    <script>
        var lineChartCanvas          = $('#lineChart').get(0).getContext('2d');
        var lineChart                = new Chart(lineChartCanvas);
        var lineChartOptions         = areaChartOptions;
        lineChartOptions.datasetFill = false;
        lineChart.Line(areaChartData, lineChartOptions);
    </script>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
    <form class="" action="@if(@$Edit != '') {{ url('Task/Edited/' . @$Edit['id']) }} @else {{ url('Task/Add') }} @endif" method="post">
        @csrf
        <input type="hidden" value="1" name="d">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Task details</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title" class="control-label">Title</label>

                            <div class="col-sm-10">
                                <input type="text" id="title" class="form-control" placeholder="Please Enter Title" name="title" value="{{ old('title') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Task detail</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="datepicker" class="control-label">date:</label>
                            <div class="col-sm-10">
                                <input type="text" id="datepicker" class="form-control" name="date" value="{{ old('date') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="description" class="control-label">description</label>
                            <div class="col-sm-10">
                                <textarea id="description" class="form-control" placeholder="task description" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-success">Add</button>
                    </div>
                </div>
            </div>

            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </form>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">The 5 Last Tasks</h3>
                </div>
                <div class="card-body p-0">

                    <ul class="timeline timeline-inverse">
                        <!-- timeline time label -->

                        <!-- /.timeline-label -->
                        <!-- timeline item -->
                        @foreach($Content as $C)
                            <?php
                            $fa = rand(1,5);
                            $co = rand(1,5);
                            switch ($fa){
                                case 1:
                                    $fa_icon= "fa-user";
                                    break;
                                case 2:
                                    $fa_icon= "fa-mail-forward";
                                    break;
                                case 3:
                                    $fa_icon= "fa-tasks";
                                    break;
                                case 4:
                                    $fa_icon= "fa-dashboard";
                                    break;
                                default:
                                    $fa_icon= "fa-user-secret";
                                    break;
                            }
                            switch ($co){
                                case 1:
                                    $color = "bg-primary";
                                    break;
                                case 2:
                                    $color = "bg-success";
                                    break;
                                case 3:
                                    $color = "bg-info";
                                    break;
                                case 4:
                                    $color = "bg-danger";
                                    break;
                                default:
                                    $color = "bg-warning";
                                    break;
                            }
                            ?>
                            <li>
                                <i class="fa {{ $fa_icon }} {{ $color }}"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i',strtotime($C['created_at'])) ?></span>

                                    <h3 class="timeline-header"> @if($C['done'])<i style="color: green;font-size: 20px;" class="fa fa-check-square"></i> @else <i style="color: green;font-size: 20px;" class="fa fa-square"></i>@endif <b>{{ $C['title'] }}</b></h3>

                                    <div class="timeline-body">
                                        {{ $C['description'] }}
                                    </div>
                                    <div class="timeline-footer">
                                        @if($C['done'] != 1)<a href="{{ url('Task/Done/'.$C['id'] . '/?d=1') }}" class="btn btn-primary btn-sm">Done</a> @endif
                                        <a href="{{ url('Task/Delete/'.$C['id'] . '/?d=1') }}" class="btn btn-danger btn-sm">Delete</a>
                                    </div>
                                </div>
                            </li>
                    @endforeach
                    <!-- END timeline item -->
                        <!-- timeline item -->

                        <!-- END timeline item -->
                        <!-- timeline item -->

                        <!-- END timeline item -->
                        <!-- timeline time label -->

                        <!-- /.timeline-label -->
                        <!-- timeline item -->

                        <!-- END timeline item -->

                    </ul>
                </div>

            </div>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">not completed task(s) in last hour</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="lineChart" style="height:250px"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
    </section>
@endsection