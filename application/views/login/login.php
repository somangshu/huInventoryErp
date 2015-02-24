<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>
		Login 
	</title>
    <link href="/public/css/login.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div class="container">
    <div id="login" class="signin-card">
    <div class="logo-image">
    <img src="public/images/logo.png" alt="Logo" title="Logo" width="138">
    </div>
    <h1 class="display1">Welcome</h1>
    <p class="subhead">Board The Ship</p>
    <form name="loginform" id="loginform" onsubmit="return validateLogin()" method="post" role="form">
    <div id="form-login-username" class="form-group">
      <input id="username" class="form-control" name="username" type="text" size="18" alt="login" required />
      <span class="form-highlight"></span>
      <span class="form-bar"></span>
      <label for="username" class="float-label">login</label>
    </div>
    <div id="form-login-password" class="form-group">
      <input id="password" class="form-control" name="password" type="password" size="18" alt="password" required />
      <span class="form-highlight"></span>
      <span class="form-bar"></span>
      <label for="password" class="float-label">password</label>
    </div>
<!--    <div id="form-login-remember" class="form-group">
      <div class="checkbox checkbox-default">       
          <input id="remember" type="checkbox" value="yes" alt="Remember me" class="">
          <label for="remember">Remember me</label>      
      </div>
    </div>-->
    <div>
      <button class="btn btn-block btn-info ripple-effect" type="submit" name="Submit" alt="sign in" onclick="validateLogin();">Sign in</button>  
          </div>

    </form>
    </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src = "public/js/default.js"></script>
</body>
</html>