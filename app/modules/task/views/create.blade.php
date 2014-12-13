<div id='success' class="alert alert-success">Task Created Successfully..!!</div>

<!-- if there are creation errors, they will show here -->

<div id='error' class="alert alert-danger" style='display:none;'>
    <ul></ul>
</div>

{{ Form::open(array('url' => isset($edit_task) ? 'tasks/update/'. $edit_task->id  : 'tasks/insert','id'=>'insert_form','onsubmit'=>'return false;')) }}
<!--            {{ (isset($edit_movie)) ? print_r($edit_movie) : ''}}-->
<div id="title_div" class="form-group">
    {{ Form::label('title', 'Task Description') }}
    {{ Form::textarea('title', Input::old('title', isset($edit_task) ? $edit_task->title : ''), array('class' => 'form-control','placeholder'=>'Enter Task Description...')) }}
</div>
<span id='title_error' class="error"></span>            

<!--<div id="description_div" class="form-group">
    {{ Form::label('description', 'Description') }}
    {{ Form::textarea('description', Input::old('description', isset($edit_task) ? $edit_task->description : ''), array('class' => 'form-control','placeholder'=>'Enter Task Description...')) }}
</div>            
<span id='description_error' style='color:red;'></span>-->

@if(isset($edit_task))
<div class="form-group">                
    {{ Form::checkbox('complete_task','complete_task', $edit_task->completed == 1 ? true : '' )}} {{ 'Mark As Complete' }}                
</div>
@endif

<div class="form-group">                
    {{ Form::checkbox('email_task','email_task' )}} {{ 'E-mail This Task' }}                
</div>

<!--            <div class="form-group">
                {{ Form::label('producer', 'Producer') }}
                {{ Form::text('producer', Input::old('producer', isset($edit_movie) ? $edit_movie->producer : ''), array('class' => 'form-control','placeholder'=>'Enter Movie Producer...')) }}
            </div>

            <div class="form-group">
                {{ Form::label('music', 'Music') }}
                {{ Form::text('music', Input::old('music', isset($edit_movie) ? $edit_movie->music : ''), array('class' => 'form-control','placeholder'=>'Enter Movie Music Director...')) }}
            </div>-->

{{ Form::button(isset($edit_task) ? 'Save Changes' : 'Create Task!', array('class' => 'btn btn-primary','id'=>isset($edit_task) ? 'update_task' : 'insert_task')) }}

{{ Form::close() }}


<script>
    $(document).ready(function() {
        $('#success').hide();
        $('#insert_form input[name="title"]').keyup(function(e) {
            if (e.keyCode == 13) {
                $('#insert_task').click();
            }
        });
        $('#insert_task').click(function(e) {

            e.preventDefault();
            $(".error").html("");
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
                                $('#title_error').html("Task description is required.");
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