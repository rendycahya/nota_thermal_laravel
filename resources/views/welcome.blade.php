<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
    <link rel="icon" href="{{asset('/img/kodehack.png')}}">
    <title>KODEHACK | LOGIN </title>
</head>
<body>

<div class="main"> 
  <div class="container">
      <center>
        <div class="middle">
          <div id="login">
            <form action="{{ url('/masuk') }}" method="POST">
              @csrf
              <fieldset class="clearfix">
                <p >
                  <span class="fa fa-user"></span>
                  <input type="text"  Placeholder="Username" required name="username">
                </p> <!-- JS because of IE support; better: placeholder="Username" -->
                <p>
                  <span class="fa fa-lock"></span>
                  <input type="password"  Placeholder="Password" required name="password">
                </p> <!-- JS because of IE support; better: placeholder="Password" -->
                <div>
                  <span class="spanLogin">
                    <input type="submit" value="Masuk">
                  </span>
            </form>
                <!-- <form action="{{ url('/daftar') }}"> -->
                  <!-- //Tempatdaftar -->
                  <!-- <span style="width:50%;text-align:right;display: inline-block;float: right;margin-top: 8px;">
                    <a href="{{ url('/daftar') }}" class="pindah">Daftar</a>
                  </span> -->
                <!-- </form> -->
                </div>
              </fieldset>
            <div class="clearfix"></div>
              <div class="clearfix"></div>
          </div> <!-- end login -->
              <div style="margin: 0px 25px;">
                <img src="{{asset('/img/kodehack.png')}}" alt="kodehack" width="180px;" height="180px;" style="vertical-align: middle;">
              </div>
              <div class="logo">
                Kodehack
              </div>
          </div>
      </center>
  </div>
</div>

</body>
</html>


<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>