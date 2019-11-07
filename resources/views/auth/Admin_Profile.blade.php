@extends('layouts/masterpage')
@section('content')
    <?php
    $page_address = "Profile";
    ?>
    <script>
        function image_ajax() {

            var file_data = $("#image").prop("files")[0];
            console.log(file_data);


            if(file_data['type'] == 'image/jpg' || file_data['type'] == 'image/jpeg' || file_data['type'] == 'image/png'){
                var form_data = new FormData();

                form_data.append("image", file_data);
                form_data.append("upload_ajax_image", true);
                form_data.append("_token", '{{ csrf_token() }}');
                $.ajax({
                    url : "{{ url('/'.$page_address.'/Images/') }}",
                    type: 'post',
                    data : form_data,
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                }).done( function(data){

                    console.log(data);
                    $("#Admin_avatar_tag").remove();
                    if(data != 'error'){
                        $('#result_upload').append('<div id="Admin_avatar_tag" class="card profile-user-img img-fluid img-circle" style="width:100px; height:100px; border: 0px solid #ccc;padding: 1px;border-radius: 3px;">\n' +
                            '<img class="profile-user-img img-fluid img-circle" src="{{ url('Uploads/Admins/' . auth()->user()->id).'/'}}'+ data +'" alt="">' +
                            '                                                                                <div class="mr_full-width" onclick="ajax_delete()"><i class="fa fa-trash"></i></div>\n' +
                            '</div>');
                        $("#avatar").remove();
                        $("#form_setting_profile").append('<input type="hidden" value="'+data+'" id="avatar" name="avatar">\n');
                    }else{
                        var errortext = $('#show_error').html();
                        $('#show_error').html(errortext + 'آپلود تصویر با خطا مواجه شد اتصال اینترنت خود را بررسی نمایید .');
                        $('#show_error').css('display', 'block');
                    }
                });
            }else{
                var errortext = $('#show_error').html();
                $('#show_error').html(errortext + 'فرمت فایل وارد شده معتبر نیست شما تنها فایل با فرمت های png , jpg , jpeg میتوانید انتخاب نمایید .');
                $('#show_error').css('display', 'block');
            }
        }
        function ajax_delete() {
            console.log("doooooneeeeee");
            document.getElementById("Admin_avatar_tag").remove(200);
            $("#avatar").val("");
            $('#result_upload').append('<div id="Admin_avatar_tag" class="profile-user-img img-fluid img-circle"><i class="fa fa-user-secret" style="font-size: 80px"></i></div>');
        }
    </script>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ url('Dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">

                        <div class="card-body box-profile">
                            <div class="text-center" id="result_upload">
                                <?= $admin_avatar_tag ?>
                            </div>

                            <h3 class="profile-username text-center">{{ $user['name'] }}</h3>

                            <p class="text-muted text-center">{{ $user['bio'] }}</p>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Setting</a></li>
                                <li class="nav-item"><a class="nav-link" href="#change_pass" data-toggle="tab">change password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">


                                <div class="tab-pane active" id="settings">
                                    <form id="form_setting_profile" class="form-horizontal" action="{{ url('Profile') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ auth()->user()->avatar }}" id="avatar" name="avatar">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">F-Name and L-Name</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="F-Name and L-Name" value="{{ $user['name'] }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" value="{{ $user['email'] }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="bio" class="col-sm-2 control-label">bio</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="bio" placeholder="bio" name="bio" value="{{ $user['bio'] }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">profile avatar</label>
                                            <div class="input-group col-sm-10">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image" onchange="image_ajax()">
                                                    <label class="custom-file-label" for="image">select file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-info">update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="change_pass">
                                    <form id="form_setting_profile" class="form-horizontal" action="{{ url('Profile') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="1" id="c_p" name="c_p">
                                        <div class="form-group">
                                            <label for="old_password" class="col-sm-4 control-label">old password</label>

                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="old_password" name="old_password" placeholder="old password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password" class="col-sm-4 control-label">new password</label>

                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="new password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-info">change</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>


@endsection