<html>
    <head>
        @include('task::layouts/inc.head')
    </head>
    <body>
        @include('task::layouts/inc.loginHeader')
        <div class="container login_wrapper" >                       
                @yield('content')            
        </div>
        @include('task::layouts/inc.footer')

        

    </body>
</html>
