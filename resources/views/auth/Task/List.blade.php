@extends('layouts/masterpage')
@section('content')
    <script>
        function confirm_to_do(title,id){
            if (confirm("Are you sure to delete \""+title+"\" ")) {
                window.location.href = '{{ url('Task/Delete/') }}/'+id;
            }
        }
    </script>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tasks List</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Tasks</h3>
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
                                                @if($C['done'] != 1)<a href="{{ url('Task/Done/'.$C['id']) }}" class="btn btn-primary btn-sm">Done</a> @endif
                                                    <a href="{{ url('Task/Delete/'.$C['id']) }}" class="btn btn-danger btn-sm" onclick="confirm_to_do('{{ $C['title'] }}',{{ $C['id'] }})">Delete</a>
                                                    <a href="{{ url('Task/Edit/'.$C['id']) }}" class="btn btn-info btn-sm">Edit</a>
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
                                <li>
                                    <i class="fa fa-pagelines bg-info"></i>

                                    <div class="timeline-item">

                                        <h3 class="timeline-header">
                                           <b>Page Navigation</b>
                                        </h3>
                                        <div class="timeline-body">
                                            <?php
                                            use App\Libraries\Gh_class;
                                            if (@$f == ''){

                                                $GH = new Gh_class();
                                                echo $GH->pagination(@$count,10,@$pid,url('Task/List/%s'));
                                            }
                                            ?>
                                        </div>

                                    </div>

                                </li>
                            </ul>

                        </div>

                    </div>


                    <!-- /.card -->
<?php /*
                    <div class="card">
                        <div class="card-header">
                            <div style="float: left;">
                                <a href="{{ url("Task/Add/") }}" class="btn btn-sm">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <h3 class="card-title">Tasks list</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 10px; text-align: center">#</th>
                                    <th>Title</th>
                                    <th>date</th>
                                    <th>مادر دسته</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                                <?php $num = 1; ?>
                                @foreach($Content as $C)
                                    <?php
                                    if ($C['icon'] != '' && $C['icon'] != 'null'){
                                        $category_image = url('/uploads/category/'.$C['icon']);
                                    }else{
                                        $category_image = url('/uploads/category/default.png');
                                    }
                                    ?>
                                    <tr>
                                        <th scope="row">{{ $num }}</th>
                                        <td>
                                            <img src="{{ $category_image }}" alt="" width="30px" height="30px" style="margin-top: -5px;">
                                        </td>
                                        <td> {{ $C['title'] }} </td>
                                        <td> {{ \App\Categories::where('id',$C['head_category'])->value('title') }} </td>
                                        <td>@if($C['active'] == 1)  <span class="btn-success btn-sm">فعال</span> @else  <span class="btn-warning btn-sm">غیر فعال</span> @endif</td>
                                        <td>
                                            <a href="{{ url('Task/Edit/'.$C['id']) }}">
                                                <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></button>
                                            </a>
                                            <a onclick="confirm_to_do('{{ $C['title'] }}',{{ $C['id'] }})">
                                                <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </a>

                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                @endforeach
                            </table>
                        </div>
                        <div style="margin: 0 auto; margin-top: 15px; margin-bottom: 10px;">
                            <?php
                            use App\Libraries\Gh_class;
                            if (@$f == ''){

                                $GH = new Gh_class();
                                echo $GH->pagination(@$count,10,@$pid,url('Admin/'.$page_address.'/Page/%s'));
                            }
                            ?>
                        </div>

                        <!-- /.card-body -->
                    </div>
                    */ ?>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
