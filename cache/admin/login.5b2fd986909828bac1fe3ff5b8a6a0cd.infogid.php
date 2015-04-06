<?php if(!class_exists('Template')){exit;}?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DASHGUM - Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="/static/admin/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="/static/admin/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="/static/admin/css/style.css" rel="stylesheet">
    <link href="/static/admin/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<!-- js placed at the end of the document so the pages load faster -->
    <script src="/static/admin/js/jquery.js"></script>
    <script src="/static/admin/js/bootstrap.min.js"></script>
<script src="/static/default/js/forms/jquery.validate.js"></script>
<script src="/static/admin/js/login.js"></script>

  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

  <div id="login-page">
  <div class="container">

      <form class="form-login" action="/admin/ajax/login" id="admin-login" method="post">
        <h2 class="form-login-heading">sign in now</h2>
        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="Login" autofocus name="login"  data-msg-required="Enter login" >
            <br>
            <input type="password" class="form-control" placeholder="Password"  name="pswd"  data-msg-required="Enter password" >
            <label class="checkbox">
              <div class="alert alert-danger" style="display:none"></div>
            </label>
            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>

        </div>

      </form>  

  </div>
  </div>

  </body>
</html>
