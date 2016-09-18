@section('head')
    <style>
        .body {
            background-image: url(/img/welcome-low.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            height: 100vh;
        }

        h1, h2, h3 {
            color: white;
        }
        .buttons {
            padding-top: 5%;
            padding-bottom: 10%;
            float: none;
            margin: 0 auto;
        }
        .sign-in {
            margin-right: 50px;
        }

    </style>
@endsection

<div class="text-center" style="padding-top: 10%; height: 100%;">
    <h1 class="hidden-xs" style="padding-bottom: 2%;">Vllep</h1>

    <h2>Welcome to the worldwide <br> podcast community </h2>

    <h3 style="padding-top: 1%;">Discover new podcasts</h3>

    <h3 style="margin-top: 1%">Find out what your friends are listening</h3>

    <h3 style="margin-top: -5px;">stay in touch with them</h3>

    <div class="buttons">
        <a href="login" class="sign-in btn btn-lg btn-info btn-rounded">
            Sign in
        </a>

        <a href="register" class="sign-up btn btn-lg btn-info btn-rounded">
            Sign up
        </a>
    </div>
</div>
