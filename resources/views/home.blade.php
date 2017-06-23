<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Sistema de Avaliação</title>

   <!-- Bootstrap Core CSS -->
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

   <!-- Custom CSS -->
   <link href="agency/css/agency.min.css" rel="stylesheet">
   <link href="css/styles.css" rel="stylesheet">

   <!-- Custom Fonts -->
   <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
   <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
   <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
   <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->

</head>

<body id="page-top" class="index">

   @include('layout.home.nav')

   @include('layout.home.header')

   @include('layout.home.about')

   @include('layout.home.why')

   @include('layout.home.how')

   {{-- @include('layout.home.contact') --}}

   <footer>
      <div class="container">
         <div class="row">
            <span class="copyright">Copyright © {{date('Y')}} <strong><a href="https://github.com/otobraz" target="_blank">Oto Braz Assunção</a></strong>, Licensed under the Apache License, Version 2.0</span>
         </div>
      </div>
   </footer>

   @include('layout.home.modals')

   <!-- jQuery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

   <!-- Bootstrap Core JavaScript -->
   <script src="bootstrap/js/bootstrap.min.js"></script>

   <!-- Plugin JavaScript -->
   <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

   <!-- Custom Theme JavaScript -->
   <script src="agency/js/agency.min.js"></script>

</body>

</html>
