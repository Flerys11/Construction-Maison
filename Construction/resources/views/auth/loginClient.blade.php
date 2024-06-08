<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <link rel="stylesheet" href="{{asset('login/fonts/material-icon/css/material-design-iconic-font.min.css')}}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('login/css/style.css')}}">
</head>
<body>

<div class="main">
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="{{asset('login/images/long.jpg')}}" alt="sing up image"></figure>

                </div>

                <div class="signin-form">
                    <h2 class="form-title">Login Client</h2>
                    <form action="{{route('login.client')}}" method="POST" class="register-form" id="login-form">
                        @csrf
                        <div class="form-group">
                            <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="number" name="contact" id="contact" placeholder="Contact" value="" />

                        </div>
                        <div class="form-group form-button">
                            <input type="submit" class="form-submit" value="Log in"/>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>


</div>

<script src="{{asset('login/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('login/js/main.js')}}"></script>
</body>
</html>
