@extends('task::layouts.loginDefault')

@section('content')

<div class="col-lg-12 col-md-12 col-sm-12">                        
    <div id='success' class="alert alert-success" style='text-align: center;display:none;'>Registration Successfully Completed..!!</div>
    <div class="col-lg-6 col-md-6 col-sm-6" style="margin-top: 7%;">
        <div class="jumbotron">
            <h2>What is Task Manager?</h2>
            <ul class="answer">
                <li>
                    This is a web application by which any organization or an individual can manage tasks.
                </li>
                <li>
                   This project has various small parts like Emailing task, Editing task, Deleting task.
                </li>
                <li>
                    To get the ride of this tool please register.
                </li>
                
            </ul>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6" style="margin-top: 9%;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Login</h3>                
            </div>
            <div class="panel-body">
                <form role="form" id='login_form'>
                    {{Form::token()}}
                    <span id='wrg_pwd_error' style='color:red;'></span>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" id="log_eml" name='log_eml' placeholder="Enter Email Address">
                        <span id='log_eml_error' class="error"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="log_pwd" name='log_pwd' placeholder="Enter Password">
                        <span id='log_pwd_error' class="error"></span>
                    </div>
                    <div class="checkbox">                        
                        <a id="forgot_password" data-toggle="modal" data-target="#forgot_modal" style="float:right;cursor: pointer;">
                            Forgot Password??
                        </a>                                                
                    </div>                                                
                    <button id='login_submit' type="button" class="btn btn-block btn-primary">Login</button>                    
<!--                    <span id='loader'><img src='{{ asset("assets/images/loader.GIF") }}'></span>-->
                </form>
            </div>
        </div>                                                            
    </div>    
</div>
<div class="modal fade" id="forgot_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
            </div>
            <div class="modal-body">
                <form role="form" id='forgot_password_form' onSubmit="return false">
                    {{Form::token()}}                        
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" id="frgt_eml" name='frgt_eml' placeholder="Enter Email Address">
                        <span id='frgt_eml_error' class="error" style='color:red;'></span>
                    </div>                        
                    <button id='frgt_submit' type="button" class="btn btn-block btn-primary">Submit</button>
                </form>
            </div>            
        </div>
    </div>
</div>
<div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Register</h4>
            </div>
            <div class="modal-body">
                <form role="form" id='register_form'>
                    {{Form::token()}}
                    <span id='user_ext_error' class='error' style='color:red;'></span>                            
                    <div class="form-group">                                
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" id="reg_eml" name='reg_eml' placeholder="Enter Email Address...">
                        <span id='eml_error' class='error' ></span>
                    </div>                            
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="reg_pwd" name='reg_pwd' placeholder="Enter Password...">
                        <span id='pwd_error' class='error' ></span>
                    </div>                            
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" class="form-control" id="reg_cpwd" name='reg_cpwd' placeholder="Enter Confirm Password...">
                        <span id='cpwd_error' class='error' ></span>
                    </div>                            
                    <button type="button" id='register' class="btn btn-primary">Register</button>
                </form>                        
            </div>                    
        </div>
    </div>
</div>
<script>
                    $(document).ready(function() {


                        $('#log_eml').focus();
                        // footer management
                        var w = $(window).height();
                        var res = w - 133;
                        $(".container").css("min-height", res + "px");
                        $(window).resize(function() {
                            w = $(window).height();
                            res = w - 133;
                            $(".container").css("min-height", res + "px");
                        });

                        $('#register').click(function(e) {
                            e.preventDefault();
                            $("#register").attr('disabled', 'disabled');
                            $(".error").html("");
                            $.ajax({
                                url: '{{ route("register_user") }}',
                                type: 'post',
                                cache: false,
                                data: $('#register_form').serialize(),
                                success: function(result) {
                                    // enable register button
                                    $("#register").removeAttr('disabled');

                                    if (!result.success) {
                                        if (result.user_exist) {
                                            $('#user_ext_error').html(result.user_exist);
                                        }
                                        $.each(result.errors, function(index, error) {
                                            if (result.errors.reg_eml != null) {
                                                $('#eml_error').html(result.errors.reg_eml);
                                                $('#reg_eml').parent().addClass('has-error').focus();
                                            } else {
                                                $('#eml_error').html('');
                                                $('#reg_eml').parent().removeClass('has-error');
                                            }
                                            if (result.errors.reg_cpwd != null) {
                                                $('#cpwd_error').html(result.errors.reg_cpwd);
                                                $('#reg_cpwd').parent().addClass('has-error').focus();
                                            } else {
                                                $('#cpwd_error').html('');
                                                $('#reg_cpwd').parent().removeClass('has-error');
                                            }
                                            if (result.errors.reg_pwd != null) {
                                                $('#pwd_error').html(result.errors.reg_pwd);
                                                $('#reg_pwd').parent().addClass('has-error').focus();
                                            } else {
                                                $('#pwd_error').html('');
                                                $('#reg_pwd').parent().removeClass('has-error');
                                            }
                                        });
                                    } else {
                                        $('.error').html('');
                                        $('#register_form')[0].reset();
                                        $('#reg_eml').parent().removeClass('has-error');
                                        $('#reg_pwd').parent().removeClass('has-error');
                                        $('#reg_cpwd').parent().removeClass('has-error');
                                        $('#register_modal').modal('hide');
                                        $('#success').slideDown(1500);
                                        $('#success').slideUp(3500);
                                    }
                                }
                            });
                        });
                        $('#login_submit').click(function(e) {
                            e.preventDefault();
                            $(".error").html("");
                            $("#login_submit").attr("disabled", "disabled");

                            $.ajax({
                                url: '{{ route("login_user") }}',
                                type: 'post',
                                cache: false,
                                data: $('#login_form').serialize(),
                                success: function(result) {
                                    if (!result.success) {
                                        if (result.wrong_pwd || result.wrong_user) {
                                            $('#wrg_pwd_error').html((result.wrong_pwd == null) ? result.wrong_user : result.wrong_pwd);
                                            $("#login_submit").removeAttr("disabled");
                                        }
                                        $.each(result.errors, function(index, error) {
                                            if (result.errors.log_eml != null) {
                                                $('#log_eml_error').html(result.errors.log_eml);
                                                $('#log_eml').parent().addClass('has-error').focus();
                                            }
                                            if (result.errors.log_pwd != null) {
                                                $('#log_pwd_error').html(result.errors.log_pwd);
                                                $('#log_pwd').parent().addClass('has-error').focus();
                                            }
                                        });
                                        $("#login_submit").removeAttr("disabled");
                                    }
                                    else {
                                        window.location.href = "{{ route('tasks') }}";
                                    }
                                }
                            });
                        });
                        $('#forgot_password').click(function() {
                            setTimeout(function() {
                                $('#frgt_eml').focus();
                            }, 500);
                        });

                        $('#register_modal').click(function() {
                            setTimeout(function() {
                                $('#reg_eml').focus();
                            }, 500);
                        });

                        $('#frgt_submit').click(function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: '{{ route("forgot_password") }}',
                                type: 'post',
                                data: $('#forgot_password_form').serialize(),
                                beforeSend: function() {
                                    $('#frgt_submit').prop('disabled', true);
                                    $("#frgt_eml_error").html("");
                                },
                                success: function(result) {
                                    if (!result.success) {
                                        if (result.errors) {
                                            $.each(result.errors, function(index, error) {
                                                if (result.errors.frgt_eml != null) {
                                                    $('#frgt_eml_error').html(result.errors.frgt_eml);
                                                    $('#frgt_eml').parent().addClass('has-error').focus();
                                                }
                                            });
                                        }
                                        if (result.wrong_user) {
                                            $('#frgt_eml_error').html(result.wrong_user);
                                            $('#frgt_submit').prop('disabled', false);
                                        }
                                        $('#frgt_submit').removeAttr('disabled');
                                    } else {
                                        $("#forgot_modal").modal('hide');
                                        $('#frgt_eml_error').html('');
                                        $('#success').html('Password reset link is sent successfully to ' + result.user.email).slideDown().slideUp(7000);
                                        $('#frgt_eml').val('').focus();
                                        $('#frgt_submit').prop('disabled', false);
                                        setTimeout(function() {
                                            $('#success').html('Registration Successfully Completed..!!');
                                        }, 5500);
                                    }
                                }
                            });
                        });

                        $('#register_modal').on('hidden.bs.modal', function() {
                            $('#register_form')[0].reset();
                            $('.error').html('');
                            $('#reg_eml').parent().removeClass('has-error');
                            $('#reg_pwd').parent().removeClass('has-error');
                            $('#reg_cpwd').parent().removeClass('has-error');
                            $('#log_eml').focus();
                        });

                        $('#forgot_modal').on('hidden.bs.modal', function() {
                            $('#forgot_password_form')[0].reset();
                            $('.error').html('');
                            $('#frgt_eml').parent().removeClass('has-error');
                            $('#log_eml').focus();
                        });

                        // when pressed enter inside form =>forgot password
                        $("#forgot_password_form").keyup(function(e) {
                            e.preventDefault();
                            if (e.keyCode == 13) {
                                $('#frgt_submit').click();
                            }
                        });

                        $("#login_form").keyup(function(e) {
                            e.preventDefault();
                            if (e.keyCode == 13) {
                                $('#login_submit').click();
                            }
                        });

                        $("#register_form").keyup(function(e) {
                            e.preventDefault();
                            if (e.keyCode == 13) {
                                $('#register').click();
                            }
                        });


                    });
</script>
<script>
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button";//again because google chrome don't insert first hash into history
    window.onhashchange = function() {
        window.location.hash = "no-back-button";
    }
</script> 
@stop

