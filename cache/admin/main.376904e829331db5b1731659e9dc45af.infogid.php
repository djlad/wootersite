<?php if(!class_exists('Template')){exit;}?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title><? echo $title;?></title>
<head>
<?php
$template = new Template;
$template->addVar($this->var);
$template->display("head" , "admin" , "inc");
?>
</head>
<body>
<section id="container">
<?php
$template = new Template;
$template->addVar($this->var);
$template->display("header" , "admin" , "inc");
?>
<?php
$template = new Template;
$template->addVar($this->var);
$template->display("menu" , "admin" , "inc");
?>
 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
<section class="wrapper">

<? echo $content;?>

</section>
</section>
<?php
$template = new Template;
$template->addVar($this->var);
$template->display("footer" , "admin" , "inc");
?>
</section>

</body>
</html>