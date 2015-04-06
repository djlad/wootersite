<html>
<head>
	<title>{$code} - {$title}</title>
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
    <h1>{$title} <small> <font face="Tahoma" color="red">Error {$code}</font></small></h1>
    <br />
    <p>{$message}</p>
	
	{if="$code == 404"}
		 <a href="/" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take Me Home</a>
	{/if}

  </div>
</body>
</html>