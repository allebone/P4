<html>
    <head>
        <title>
            Reset Password
        </title>
    </head>
    <body>
        <h1>
            <a href="{{ URL::route('reset_password_view',array($code,$id)) }}">                
                Reset Your Password.
            </a>
        </h1>
    </body>
</html>
