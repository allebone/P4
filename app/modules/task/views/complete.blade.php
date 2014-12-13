@extends('task::layouts.default')

@section('content')
<!--<h1><span class="glyphicon glyphicon-ok-circle" aria-hidden="true" style="font-size: 30px;"></span> Completed Tasks</h1>
<hr color="#a1a1a1" style="border:1px solid black !important;margin-top:10px !important;"/>-->

<!-- will be used to show any messages -->
<div id='info' class="alert alert-info">Task Deleted Successfully!!!</div>

<table class="table table-bordered" id='complete_task_table'>
    <thead>
        <tr>                           
            <th>Task Summary</th>
            <th>Created On</th>            
            <th>Completed On</th>                       
            <th></th>
        </tr>
    </thead>
    <tbody class="table-hover">

    </tbody>
</table>

<div id='links' style='float:right;'></div>

<script>
    $(document).ready(function() {
        $('#info').hide();
        $(document).off('click', '.create_modal').on('click', '.create_modal', function() {
            $.ajax({
                url: '{{ route("task_create") }}',
                cache: false,
                beforeSend: function() {
                    $('#abc .modal-body').html('<center><img src="{{ asset("assets/images/loader_large.gif") }}" /></center>');
                },
                success: function(result) {
                    console.log(result);
                    $('#abc .modal-title').html('<span class="glyphicon glyphicon-check" aria-hidden="true"></span> Create Task');
                    $('#abc .modal-body').html(result);
                }
            });
        });

        $(document).off('click', '.edit_modal').on('click', '.edit_modal', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var url = $(this).attr('taskid');
            $.ajax({
                url: url,
                cache: false,
                beforeSend: function() {
                    $('#abc .modal-body').html('<center><img src="{{ asset("assets/images/loader_large.gif") }}" /></center>');
                },
                success: function(result) {
                    $('#abc .modal-title').html('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Task');
                    $('#abc .modal-body').html(result);
                }
            });
        });

        $(document).off('click', '.delete_task').on('click', '.delete_task', function(e) {            
            e.preventDefault();
            e.stopPropagation();
            var conf = confirm("Are you sure you want to delete this Task?");
            if (conf === true) {
                var task_id = $(this).attr('taskid');
                var ele = $(this);
                $.ajax({
                    url: task_id,
                    cache: false,
                    beforeSend: function() {
                        $(ele).html("<span><img src='{{ asset('assets/images/loader.GIF') }}'></span>");
                    },
                    success: function(result) {
                        if (result) {
                            $('#info').html('Task Deleted Successfully!!!').slideDown(1500);
                            $('#info').html('Task Deleted Successfully!!!').slideUp(1500);
                            showData();
                            $(ele).html("<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>");
                        }

                    }
                });
            }
        });

        $(document).off('click', '.complete_task').on('click', '.complete_task', function() {
            var conf = confirm("Are you sure you want to complete this Task?");
            if (conf === true) {
                var task_id = $(this).attr('taskid');
                var ele = $(this);
                $.ajax({
                    url: task_id,
                    cache: false,
                    beforeSend: function() {
                        $(ele).html("<span><img src='{{ asset('assets/images/loader.GIF') }}'></span>");
                    },
                    success: function(result) {
                        if (result) {
                            $('#info').html('Task Mark As Complete Successfully!!!').slideDown(1500);
                            $('#info').html('Task Mark As Complete Successfully!!!').slideUp(1500);
                            showData();
                            $(ele).html("<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>");
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
                        $(ele).html("<span><img src='{{ asset('assets/images/loader.GIF') }}'></span>");
                    },
                    success: function(result) {
                        if (result) {
                            $('#info').html('Task Has Been E-mail Successfully!!!').slideDown(1500);
                            $('#info').html('Task Has Been E-mail Successfully!!!').slideUp(1500);
                            showData();
                            $(ele).html("<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>");
                        }

                    }
                });
            }
        });

        $(document).off('click', '.show_modal').on('click', '.show_modal', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var url = $(this).attr('taskid');
            $.ajax({
                url: url,
                cache: false,
                beforeSend: function() {
                    $('#abc .modal-body').html('<center><img src="{{ asset("assets/images/loader_large.gif") }}" /></center>');
                },
                success: function(result) {
                    $('#abc .modal-title').html('Task Detail');
                    $('#abc .modal-body').html(result);
                }
            });
        });

        $('#abc').on('hidden.bs.modal', function() {            
                showData();            
        });

        showData();
        $(window).bind("hashchange", function() {
            showData();
        });


        //-----this function will return the data based on the "url" provided to it-------- 
        function getData(page)
        {

            $.ajax({
                url: "{{ Route('completeTask') }}?page=" + page,
                cache: false,
                dataType: 'json',
                type: "get",
                beforeSend: function() {
                    //---before data comes from the ajax request will show the loader--------------
                    $("#links").html("");
                    $("#complete_task_table tbody").html('<tr><td colspan="6"><center><img src="{{ asset("assets/images/loader_large.gif") }}" /></center></td></tr>');
//                    $("#loader_image").html('<center><div class="loader_large img_load"><img src="{{ asset("assets/images/large_loader.gif") }}" /></div></center>');

                },
                success: function(data) {

                    //---this will make empty the 'div' and it will fill it with requested data--------
                    $("#complete_task_table tbody").html(data.task);
                    $("#links").html(data.links);
                    //$('#t1 tr:last').after(data);

                }
            });

        }


        //----when page loads or reloads based on the current "url" will get the data from the function-------------
        function showData()
        {
            var hash = window.location.hash;
            //----if there is no hash variable then will show the first page---i.e. the basic url----------------------
            if (hash == "")
            {
                getData(1);
            }
            else
            {
                //---storing hash variables in json 'data'----------------------------------- 
                var data = {};
                data = $.deparam(hash.substring(1));
                //----validating the 'page' variable-----------------------
                if (typeof data.page != "undefined" && data.page != "")
                {
                    //----getting the result according to the page variable--------------------
                    getData(data.page);

                }
                else
                {
                    getData(1);
                }
            }
        }

        //-------here will define what to do when user clicks on the pagination links------------------
        $(document).off("click", ".pagination li a").on("click", ".pagination li a", function(e) {

            //---first of all will prevent the default work of the pagination-------
            e.preventDefault();
            var state = {};
            //----then will get the url of the link---------------------------
            var url = $(this).attr('href');
            //------here will get the page number from the link-----------------------
            var page = url.substring(url.lastIndexOf("/") + 19);
            //-----if there is no variable with this name then will take default "1"
            state['page'] = page ? page : "1";
            //----will push the new page number on the querystring(fragment)----
            $.bbq.pushState(state);

        });
    });
</script>

@stop