<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>{$title}</title>
	<head>
		{include=admin/inc/head}
	</head>
<body>
	<section id="container">
		{include=admin/inc/header}
		{include=admin/inc/menu}
		 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
				
				{$content}
				
			</section>
		</section>
		{include=admin/inc/footer}	
	</section>
	
</body>
</html>