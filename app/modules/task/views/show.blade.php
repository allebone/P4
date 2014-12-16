                        

    <div style='margin-top: 10px;' class='loader alert alert-info'></div>
    <div style='text-align: left;'>
        @if($task->completed == 0)
        <button type="button" taskid="{{ URL::route('task_complete',$task->id) }}" class="complete_task btn btn-success btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true" style='vertical-align: -1px;'></span> &nbsp;Mark As Complete</button>
        @endif
        <button type="button" taskid="{{ URL::route('task_email',$task->id) }}" class="email_task btn btn-primary btn-sm"><span class="glyphicon glyphicon-envelope" aria-hidden="true" style='vertical-align: -1px;'></span> &nbsp;E-mail Task</button>
    </div>
    <div>
        <div style='margin-top: 10px;' id='success' class="alert alert-success success"></div>                

        <p style='margin-top:20px;word-break: break-all;'>               
            {{ ($task->title != "") ? $task->title : "---"}}            
        </p>                          

        <div style='margin-top: 20px;'>
            <div style='float:left;'>
                <strong>Created On:</strong> {{ date('d-m-Y h:i',strtotime($task->start_date)) }}                    
            </div>            
            <div style='float:left;margin-left:70px;'>
                <strong>Completed On:</strong> {{ isset($task->end_date) ? date('d-m-Y h:i',strtotime($task->end_date)) : '---' }}                    
            </div>
        </div>        
    </div>
    <div class="clear"></div>    

<script>
    $(document).ready(function() {
        $('#success').hide();
        $('.loader').hide();
        $(document).off('click', '.complete_task').on('click', '.complete_task', function() {
            var conf = confirm("Are you sure you want to mark the task as complete?");
            if (conf === true) {
                var task_id = $(this).attr('taskid');
                var ele = $(this);
                $.ajax({
                    url: task_id,
                    cache: false,
                    beforeSend: function() {
                        $('.loader').html('Updating Task...').show();
                        ele.attr('disabled', 'disabled');
                    },
                    success: function(result) {
                        if (result) {
                            $('.loader').hide();
                            $('#success').html('Task Marked As Complete').slideDown(1000);
                            $('#success').html('Task Marked As Complete').slideUp(1000);
                            ele.removeAttr('disabled');
                            setTimeout(function() {
                                $('#abc').modal('hide');
                            }, 3000);
                        }
                    }
                });
            }
        });

        $(document).off('click', '.email_task').on('click', '.email_task', function() {
            var conf = confirm("Are you sure you want to E-mail this Task?");
            if (conf === true) {
                var task_id = $(this).attr('taskid');
                var ele = $(this);
                $.ajax({
                    url: task_id,
                    cache: false,
                    beforeSend: function() {
                        $('.loader').html('Sending Mail...').show();
                        ele.attr('disabled', 'disabled');
                    },
                    success: function(result) {
                        if (result) {
                            $('.loader').hide();
                            $('#success').html('Task Has Been E-mail Successfully!!!').slideDown(1000);
                            $('#success').html('Task Has Been E-mail Successfully!!!').slideUp(1000);
                            setTimeout(function() {
                                $('#abc').modal('hide');
                            }, 3000);
                            ele.removeAttr('disabled');
                        }

                    }
                });
            }
        });
    });
</script>
