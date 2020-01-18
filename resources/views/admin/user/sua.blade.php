@extends('admin.layout.index')

@section('content')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Người dùng
                    <small>{{$user->name}}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @if(count($errors)>0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $err)
                        {{$err}}
                    @endforeach
                </div>
            @endif
            @if(session('thongbao'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                </div>
            @endif
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="admin/user/sua/{{$user->id}}" method="POST">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input class="form-control" value="{{$user->name}}" name="name" placeholder="Nhập tên của bạn" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control"  value="{{$user->email}}" name="email" readonly placeholder="Mời bạn nhập email" />
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="changPassword" id="changPassword">
                        <label>Đổi mật khẩu</label>
                    <input class="form-control password" type="password" disabled="" name="password" placeholder="Mời bạn nhập mật khẩu" />
                    </div>
                    <div class="form-group">
                        <label>Nhập lại mật khẩu</label>
                        <input class="form-control password" type="password" disabled="" name="passwordAgain" placeholder="Mời bạn nhập lại mật khẩu" />
                    </div>
                    <div class="form-group">
                        <label>Quyền</label>
                        <label class="radio-inline">
                            <input type="radio" name="quyen" value="0"
                            @if($user->quyen == 0)
                                {{"checked"}}
                            @endif
                            />Thường
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="quyen" value="0"
                            @if($user->quyen == 1)
                                {{"checked"}}
                            @endif
                            />Admin
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Sửa thông tin người dùng</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $("#changPassword").change(function(){
                if($(this).is(":checked"))
                {
                    $(".password").removeAttr('disabled');
                }else{
                    $(".password").attr('disabled','');
                }
            });
        });
    </script>
@endsection
