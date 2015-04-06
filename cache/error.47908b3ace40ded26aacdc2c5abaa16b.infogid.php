<?php if(!class_exists('Template')){exit;}?><html>
<head>
<title><? echo $code;?> - <? echo $title;?></title>
<link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet">
<style>
body {
background: #eee;
}
.center {
text-align: center; margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto;
}
</style>
</head>
<body>
  <div class="hero-unit center">
    <h1><? echo $title;?> <small> <font face="Tahoma" color="red">Error <? echo $code;?></font></small></h1>
    <br />
    <p><? echo $message;?></p>

<?php if( $code == 404 ){ ?>
 <a href="/" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take Me Home</a>
<?php } ?>

  </div>
</body>
</html>