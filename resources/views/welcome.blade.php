<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div id="app">
                <example-component></example-component>
            </div>
           
            <div class="content">
               <ul>
                   <li><a href="{{ route('ministry_login_page') }}">Ministry Login</a> </li>
                   <li><a href="{{ route('school_login_page') }}">School Login</a> </li>
                   <li><a href="{{ route('teacher_login_page') }}">Teacher Login</a> </li>
                   <li><a href="{{ route('student_login_page') }}">Student Login</a> </li>
                   <li><a href="{{ route('liberian_login_page') }}">Liberian Login</a> </li>
                   <li><a href="{{ route('burser_login_page') }}">Burser Login</a> </li>
                   <li><a href="{{ route('parent_login_page') }}">Parent Login</a> </li>
                   <li><a href="{{ route('aeo_zeo_login_page') }}">AEO / ZEO</a> </li>
               </ul>
         
            </div>
        </div>
    </body>
</html>
