<!DOCTYPE html />
<html lang="de">
 <head>
  <meta charset="utf8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $title; ?></title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<?php
if(isset($canonical)){
echo '  <link rel="canonical" href="'.$canonical.'" />';
}
?>
 </head>
 <body role="document">
  <div class="navbar navbar-default">
   <div class="container">
    <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"></button>
     <a class="navbar-brand" href="/">AWGCAL</a>
    </div>
    <div class="navbar-collapse collapse">
     <ul class="nav navbar-nav">
      <li><a href="/">Home</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
      <li><a href="https://github.com/DSchmidtberg/awgcal">GitHub</a></li>
      <li><a href="https://abfallkallender.tal42.de">TAL42 AWGCAL</a></li>
     </ul>
    </div>
   </div>
  </div>
  <div class="container" role="main" id="main">

