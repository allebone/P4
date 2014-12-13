<!--            {{ (isset($edit_movie)) ? print_r($edit_movie) : ''}}-->
<form role="form" id='change_setting_form'>
    {{Form::token()}}    
    <span id='user_ext_error' class='error' style='color:red;'></span>    
    <div class="form-group">                                
        <label for="exampleInputEmail1">Email</label>
        <input type="email" class="form-control" id="reg_eml" name='reg_eml' value="{{ Sentry::getUser()->email }}" placeholder="Enter Email Address...">
        <span id='eml_error' class='error' style='color:red;'></span>
    </div>                            
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="reg_pwd" name='reg_pwd' placeholder="Enter Password...">
        <span id='pwd_error' class='error' style='color:red;'></span>
    </div>                            
    <div class="form-group">
        <label for="exampleInputPassword1">Confirm Password</label>
        <input type="password" class="form-control" id="reg_cpwd" name='reg_cpwd' placeholder="Enter Confirm Password...">
        <span id='cpwd_error' class='error' style='color:red;'></span>
    </div>                            
    <button type="button" id='change_setting' class="btn btn-primary">Confirm Change</button>
</form>      
<script>
    $(document).ready(function() {        
        $('#change_setting').click(function() {
            $.ajax({
                url: '{{ route("updateUser",array(Sentry::getUser()->id)) }}',
                type: 'post',
                cache: false,
                data: $('#change_setting_form').serialize(),
                success: function(result) {                    
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
                        $('#change_setting_form')[0].reset();
                        $('#reg_eml').parent().removeClass('has-error');
                        $('#reg_pwd').parent().removeClass('has-error');
                        $('#reg_cpwd').parent().removeClass('has-error');                        
                        $('#abc').modal('hide');
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>




<script>
    $(document).ready(function() {
        
        $('#insert_form').keyup(function(e) {
            if (e.keyCode == 13) {
                $('#insert_task').click();
            }
        });
        $('#insert_task').click(function() {
            $.ajax({
                url: '{{ route("inserttask") }}',
                type: 'post',
                data: $('#insert_form').serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#insert_task').attr('disabled', 'disabled');
                },
                success: function(result) {
                    if (!result.success) {
                        $.each(result.errors, function(index, error) {
                            if (result.errors.title != null) {
                                $('#title_error').html(result.errors.title);
                                $('#title_div').addClass('has-error').focus();
                            }
//                            if (result.errors.description != null) {
//                                $('#description_error').html(result.errors.description);
//                                $('#description_div').addClass('has-error').focus();
//                            }
                        });
                        $('#insert_task').removeAttr('disabled');
                    } else {
                        $('#insert_task').removeAttr('disabled');
                        $('#title_error').html('');
                        $('#title_div').removeClass('has-error');
//                        $('#description_error').html('');
//                        $('#description_div').removeClass('has-error');
                        $('#success').show(1500);
                        $('#insert_form').each(function() {
                            this.reset();   //Here form fields will be cleared.
                        });
                        $('#success').hide(2500);
                    }
                }
            });
        });
<?php if (isset($edit_task)) { ?>
            $('#insert_form').keyup(function(e) {
                if (e.keyCode == 13) {
                    $('#update_task').click();
                }
            });
            $('#update_task').click(function() {
                $.ajax({
                    url: '{{ route("updatetask",array($edit_task->id)) }}',
                    type: 'post',
                    data: $('#insert_form').serialize(),
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#update_task').attr('disabled', 'disabled');
                    },
                    success: function(result) {
                        if (!result.success) {
                            $.each(result.errors, function(index, error) {
                                if (result.errors.title != null) {
                                    $('#title_error').html(result.errors.title);
                                    $('#title_div').addClass('has-error').focus();
                                }
                                //                                if (result.errors.description != null) {
                                //                                    $('#description_error').html(result.errors.description);
                                //                                    $('#description_div').addClass('has-error').focus();
                                //                                }
                            });
                            $('#update_task').removeAttr('disabled');
                        } else {
                            $('#update_task').removeAttr('disabled');
                            $('#success').html('Your Changes Has Been Saved Successfully!!!').show(1500);
                            setTimeout(function() {
                                $('#abc').modal('hide');
                                $('#success').html('Task Created Successfully..!!');
                            }, 3000);
                        }
                    }
                });
            });
<?php } ?>
    });
</script>