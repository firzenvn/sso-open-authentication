@extends('layouts.'.$ui_mode)

@section('title')
Thông tin cá nhân
@endsection

@section('content')
<h3>Sửa thông tin cá nhân</h3>
@if(Input::has('updated_account') && Input::get('updated_account') != 1)
<section style="padding-left: 20px">
<p class="text-danger" style="font-weight: bold">Bạn cần cập nhật những thông tin sau để thực hiện nạp XU vào tài khoản:</p>
<p class="text-success" style="font-style: italic">Lưu ý: Bạn nên nhập email và số điện thoại thực để thuận tiện cho chúng tôi hỗ trợ trong trường hợp giao dịch nạp tiền của bạn gặp trục trặc.</p>
</section>

@endif
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#profile">
                    Thông tin cá nhân
                </a>
            </h4>
        </div>
        <div id="profile" class="panel-collapse collapse @if(!Input::has('panel') || Input::get('panel')=='profile')in @endif">
            <div class="panel-body">
                {{ Form::open(array('class'=>'form', 'id'=>'profile-form'))}}
                <section id="msg-profile" style="font-weight: bold"></section>
                <div class="form-input">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Họ tên:</label>
                            <div class="col-sm-3">
                                {{ Form::text('first_name', $user->first_name, array('class'=>'form-control','placeholder'=>'Tên', 'id'=>'txtFirstName')) }}
                            </div>
                            <div class="col-sm-6">
                                {{ Form::text('last_name', $user->last_name, array('class'=>'form-control','placeholder'=>'Họ và tên đệm', 'id'=>'txtLastName')) }}
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Giới tính:</label>
                            <div class="col-sm-3">
                                {{ Form::select('gender', array(''=>'--Giới tính--','m'=>'Nam', 'f'=>'Nữ'),$user->gender,array('class'=>'form-control text-center', 'id'=>'cboGender')) }}
                            </div>
                            <label class="col-sm-3 control-label">Số CMND:</label>
                            <div class="col-sm-3">
                                {{ Form::text('identity_number', $user->identity_number,array('class'=>'form-control','placeholder'=>'Số CMND', 'id'=>'txtIdNumber')) }}
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sinh nhật:</label>
                            <div class="day col-sm-3">
                                {{Form::select('day',array(''=>'--Ngày--')+array_combine(range(1,31),range(1,31)),$default['day'],array('class'=>'form-control text-center', 'id'=>'cboDay'))}}
                            </div>
                            <div class="mon col-sm-3">
                                {{Form::select('mon',array(''=>'--Tháng--')+array_combine(range(1,12),range(1,12)),$default['mon'],array('class'=>'form-control text-center', 'id'=>'cboMonth'))}}
                            </div>
                            <div class="year col-sm-3">
                                {{Form::select('year',array(''=>'--Năm--')+array_combine(range(date('Y'),1910),range(date('Y'),1910)),$default['year'],array('class'=>'form-control text-center', 'id'=>'cboYear'))}}
                            </div>
                        </div>
                        <div class="clear"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Địa chỉ:</label>
                            <div class="col-sm-9">
                                {{Form::text('address', $user->address, array('class'=>'form-control','placeholder'=>'Địa chỉ', 'id'=>'txtAddress'))}}
                            </div>
                        </div>
                        <div class="clear"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tỉnh/Thành phố:</label>
                            <div class="col-sm-3">
                                {{Form::select('province_id',array(''=>'--Tỉnh/Thành--')+$provinces,$user->province_id,array('class'=>'province form-control', 'id'=> 'cboProvince'))}}
                            </div>
                            <label class="control-label text-right col-sm-3">Quận/Huyện:</label>
                            <div id="load_districts" class="col-sm-3">
                                {{Form::select('district_id',array(''=>'--Quận/Huyện--')+$user_districts,$user->district_id,array('class'=>'district form-control', 'id'=> 'cboDistrict'))}}
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="form-group form-button">
                    <div class="col-sm-2 col-sm-offset-3">
                        {{Form::button('Cập nhật', array('class'=>'btn btn-primary', 'onClick'=>'updateProfile()', 'id'=>'btn-update-profile'))}}
                        <section class="text-right">
                            <img src="/images/ajax_loading.gif" alt="" style="display: none" height="25" width="25" id="loading-profile" />
                        </section>
                    </div>
                    <div class="col-sm-2">
                        {{Form::reset('Nhập lại', array('class'=>'btn btn-default'))}}
                    </div>
                 </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#account">
                    Thông tin tài khoản
                </a>
            </h4>
        </div>
        <div id="account" class="panel-collapse collapse @if(Input::get('panel')=='account') in @endif">
            <div class="panel-body">
            {{ Form::open(array('class'=>'form', 'id'=>'account-form'))}}
                <section id="msg-account" style="font-weight: bold"></section>
                <div class="form-input">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email hiện tại:</label>
                            <div class="col-sm-9">
                                {{Form::text('old_email', (isset($user->email) && $user->email != '') ? AppHelper::maskEmail($user->email):'', array('class'=>'form-control','disabled','id'=>'txtOldEmail'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email mới:</label>
                            <div class="col-sm-9">
                                {{Form::text('email', null, array('class'=>'form-control','id'=>'txtEmail'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nhập lại email mới:</label>
                            <div class="col-sm-9">
                                {{Form::text('email_confirmation', null, array('class'=>'form-control','id'=>'txtEmailConfirmation'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số điện thoại:</label>
                            <div class="col-sm-9">
                                {{Form::text('current_phone', (isset($user->phone) && $user->phone != '') ? AppHelper::maskPhone($user->phone) : '', array('class'=>'form-control','disabled'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số điện thoại mới:</label>
                            <div class="col-sm-9">
                                {{Form::text('new_phone', null, array('class'=>'form-control','id'=>'txtPhone'))}}
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                 <div class="form-group form-button">
                        <div class="col-sm-2 col-sm-offset-3">
                            {{Form::button('Cập nhật', array('class'=>'btn btn-primary','onclick'=>'updateAccount()','id'=>'btn-update-account'))}}
                            <section class="text-right">
                                <img src="/images/ajax_loading.gif" alt="" style="display: none" height="25" width="25" id="loading-account" />
                            </section>
                        </div>
                        <div class="col-sm-2">
                            {{Form::reset('Nhập lại', array('class'=>'btn btn-default'))}}
                        </div>
                 </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#security">
                    Bảo mật
                </a>
            </h4>
        </div>
        <div id="security" class="panel-collapse collapse @if(Input::get('panel')=='security') in @endif">
            <div class="panel-body">
            {{Form::open(array('class'=>'form'))}}
            <section id="msg-pass" style="font-weight: bold"></section>
            <div class="form-input" style="border: none">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" style="margin: 0">Mật khẩu:</label>
                        <div class="col-sm-2">
                            *************
                        </div>
                        <a href="javascript:;" id="showFormPass"><i class="glyphicon glyphicon-pencil"></i> Sửa</a>
                    </div>
                </div>
            </div>
            {{Form::close()}}
            {{ Form::open(array('class'=>'form', 'id'=>'security-form'))}}
                <div class="form-input">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mật khẩu cũ:</label>
                            <div class="col-sm-9">
                                {{ Form::password('old_password', array('class'=>'form-control', 'required','id'=>'txtOldPass')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mật khẩu mới:</label>
                            <div class="col-sm-9">
                                {{ Form::password('password', array('class'=>'form-control','required','id'=>'txtPass')) }}
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-sm-3 control-label">Nhập lại MK mới:</label>
                            <div class="col-sm-9">
                                {{ Form::password('password_confirmation', array('class'=>'form-control','required','id'=>'txtPassConfirmation')) }}
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                 <div class="form-group form-button">
                        <div class="col-sm-2 col-sm-offset-3">
                            {{Form::button('Cập nhật', array('class'=>'btn btn-primary','onclick'=>'updatePass()','id'=>'btn-update-pass'))}}
                            <section class="text-right">
                                <img src="/images/ajax_loading.gif" alt="" style="display: none" height="25" width="25" id="loading-pass" />
                            </section>
                        </div>
                        <div class="col-sm-2">
                            {{Form::reset('Nhập lại', array('class'=>'btn btn-default'))}}
                        </div>
                 </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
       $(".panel-collapse").on('show.bs.collapse',function(){
           $(this).parent().find(".panel-title").addClass('active');
       });
        $(".panel-collapse").on('hide.bs.collapse',function(){
            $(this).parent().find(".panel-title").removeClass('active');
        });
    });
</script>


    <script>
        function updateProfile(){
            first_name = $("#txtFirstName").val();
            last_name = $("#txtLastName").val();
            gender = $("#cboGender").val();
            identity_number = $("#txtIdNumber").val();
            day = $("#cboDay").val();
            month = $("#cboMonth").val();
            year = $("#cboYear").val();
            address = $("#txtAddress").val();
            province_id = $("#cboProvince").val();
            district_id = $("#cboDistrict").val();
            $("#btn-update-profile").hide();
            $("#loading-profile").show();

            $.post('/users/update-profile',{
                first_name:first_name, last_name:last_name, gender: gender,
                day: day, month: month, year: year, address: address,
                province_id: province_id, district_id: district_id, identity_number: identity_number
            }
            ,function(result){
                $('#msg-profile').html(result.msg);
                if(result.success){
                    $('#msg-profile').addClass('text-success').removeClass('text-danger');
                }else{
                    $('#msg-profile').addClass('text-danger').removeClass('text-success');
                }
                $("#btn-update-profile").show();
                $("#loading-profile").hide();
            },'json');
        }

        function updateAccount(){
            email = $("#txtEmail").val();
            email_confirmation = $("#txtEmailConfirmation").val();
            phone = $("#txtPhone").val();
            $("#btn-update-account").hide();
            $("#loading-account").show();

            $.post('/users/update-account',{
                email: email, email_confirmation: email_confirmation, phone: phone
            }
            ,function(result){
                $('#msg-account').html(result.msg);
                if(result.success){
                    $('#msg-account').addClass('text-success').removeClass('text-danger');
                    @if(Input::has('return_url'))
                        window.location.href = '{{Input::get('return_url')}}?ui_mode={{Input::get('ui_mode')}}';
                    @endif
                }else{
                    $('#msg-account').addClass('text-danger').removeClass('text-success');
                }
                $("#btn-update-account").show();
                $("#loading-account").hide();

            },'json');
        }

        function updatePass(){
            old_password = $("#txtOldPass").val();
            password = $("#txtPass").val();
            password_confirmation = $("#txtPassConfirmation").val();
            $("#btn-update-pass").hide();
            $("#loading-pass").show();

            $.post('/users/update-pass',{
                old_password: old_password, password: password, password_confirmation:password_confirmation
            }
            ,function(result){
                $('#msg-pass').html(result.msg);
                if(result.success){
                    $('#msg-pass').addClass('text-success').removeClass('text-danger');
                }else{
                    $('#msg-pass').addClass('text-danger').removeClass('text-success');
                }
                $("#btn-update-pass").show();
                $("#loading-pass").hide();
            },'json');

        }

        $(function(){
            $.ajaxSetup({
               headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });

            $("#security-form").hide();

            $("#showFormPass").click(function(){
                $("#security-form").fadeToggle();
            });

            $("select[name=province_id]").change(function(){
                var id = $(this).val();
                $.ajax({
                    type:"GET",
                    url:"district",
                    cache:false,
                    data: "id="+id,
                    success:function(data){
                        $("#load_districts").html(data);
                    },
                    error:function(){
                        alert("error");
                    }
                });
            });
        });
    </script>
@endsection

