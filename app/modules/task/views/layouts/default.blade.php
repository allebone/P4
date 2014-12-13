<!DOCTYPE html>
<html lang="en">
    <head>
        @include('task::layouts/inc.head')
    </head>

    <body>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ URL::to('tasks') }}">Task Manager</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">                                                                                                    
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" role="button" aria-expanded="false" href='#'>
                            <i class="fa fa-user fa-fw"></i> &nbsp;{{Sentry::getUser()->email;}}  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">                            
                            <li>
                                <a style='cursor: pointer;' data-toggle="modal"  data-target="#abc" class='change_setting_modal' id='change_setting_modal'>
                                    <i class="fa fa-gear fa-fw"></i> Settings
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href='{{ URL::to("logout") }}'>
                                    <i class="fa fa-sign-out fa-fw"></i> Logout
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">                            
                            <li>
                                <a style='cursor: pointer;' data-toggle="modal"  data-target="#abc" class='create_modal' id='create_modal'><i class="fa fa-check-square-o"></i> Create Task</a>
                            </li>
                            <li>
                                <a class="{{ Route::is('tasks') ? 'active' : '' }}" style='cursor: pointer;' href='{{ URL::to("tasks") }}'><i class="fa fa-tasks fa-fw"></i> All Tasks</a>
                            </li>
                            <li>
                                <a class="{{ Route::is('incompleteTask') ? 'active' : '' }}" style='cursor: pointer;' href='{{ URL::to("incompleteTask") }}'><i class="fa fa-times fa-fw"></i> Incomplete Tasks</a>
                            </li>                            
                            <li>
                                <a class="{{ Route::is('completeTask') ? 'active' : '' }}" style='cursor: pointer;' href='{{ URL::to("completeTask") }}'><i class="fa fa-check fa-fw"></i> Completed Tasks</a>
                            </li>                                                                                    
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">{{ Route::is('tasks') ? 'All Tasks' : (Route::is('completeTask') ? 'Completed Tasks' : (Route::is('incompleteTask') ? 'Incomplete Tasks' : '')) }}</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <a href='{{ URL::to("incompleteTask") }}'>
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <i class="fa fa-times fa-3x"></i>                                        
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="huge">Incomplete Tasks</div>
                                        </div>                                    
                                        <div class="col-xs-2 text-right">
                                            <div class="huge">{{$incomplete_count}}</div>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>    
                        </div>
                    <div class="col-lg-6 col-md-12">
                        <a href='{{ URL::to("completeTask") }}'>
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <i class="fa fa-check fa-3x"></i>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="huge">Completed Tasks</div>
                                        </div>                                    
                                        <div class="col-xs-2 text-right">
                                            <div class="huge">{{$complete_count}}</div>                                        
                                        </div>                                    
                                    </div>
                                </div>                            
                            </div>
                        </a>    
                    </div>                                        
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <div class="modal fade" id="abc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">

                    </div>                    
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    $(document).ready(function() {
        $(document).off('click', '.change_setting_modal').on('click', '.change_setting_modal', function() {
            $.ajax({
                url: '{{ route("changeSetting") }}',
                cache: false,
                beforeSend: function() {
                    $('#abc .modal-body').html('');
                },
                success: function(result) {
                    $('#abc .modal-title').html('<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Change Setting');
                    $('#abc .modal-body').html(result);
                }
            });
        });
    });
</script>