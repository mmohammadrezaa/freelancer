@extends('layouts/masterpage')
@section('content')
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@if(@$Edit != '') Edit @else Add @endif Task</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <form class="" action="@if(@$Edit != '') {{ url('Task/Edit/' . @$Edit['id']) }} @else {{ url('Task/Add') }} @endif" method="post">
                @csrf
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
                                        <input type="text" id="title" class="form-control" placeholder="Please Enter Title" name="title" value="@if(old('title') != ''){{ old('title') }} @else {{ @$Edit['title'] }} @endif">
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
                                        <input type="text" id="datepicker" class="form-control" name="date" value="@if(old('date') != ''){{ old('date') }} @else {{ @$Edit['date'] }} @endif">
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
                                        <textarea id="description" class="form-control" placeholder="task description" name="description">@if(old('description') != ''){{ old('description') }} @else {{ @$Edit['description'] }} @endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn @if(@$Edit != '') btn-outline-info @else btn-outline-success @endif">@if(@$Edit != '') Edit @else Add @endif</button>
                            </div>
                        </div>
                    </div>

                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </form>
    </section>
    <!-- /.content -->

@endsection
