<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Diário de Classe</title>

   <!-- Bootstrap Core CSS -->

   <!-- Custom CSS -->
   <link href="css/styles.css" rel="stylesheet">
   {!! HTML::style('css/bootstrap/bootstrap.min.css') !!}
   {!! HTML::style('css/font-awesome/font-awesome.min.css') !!}
   {!! HTML::style('css/app.css') !!}
   {!! HTML::style('css/agency.min.css') !!}

   {!! HTML::style('css/styles.css') !!}

   {!! HTML::favicon('favicon.ico') !!}
   <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

   <!-- Custom Fonts -->
   <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
.mySlides {display:none}
.w3-left, .w3-right, .w3-badge {cursor:pointer}
.w3-badge {height:13px;width:13px;padding:0}
</style>
<body id="page-top" class="index">



   @include('layout.home.nav')

   <!--@include('layout.home.header')-->

   @include('layout.home.about')

   @include('layout.home.why')

   @include('layout.home.how')

   {{-- @include('layout.home.contact') --}}

   <footer>
      <div class="container">
         <div class="row">
            <span class="copyright">Copyright © {{date('Y')}} <strong><a href="https://github.com/chesman12" target="_blank">Bárbara Chesman</a></strong>, Licensed under the Apache License, Version 2.0</span>
         </div>
      </div>
   </footer>

   @include('layout.home.modals')

   <!-- jQuery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


   <!-- Plugin JavaScript -->
   <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>



   <script>
   var slideIndex = 1;
   showDivs(slideIndex);

   function plusDivs(n) {
     showDivs(slideIndex += n);
   }

   function currentDiv(n) {
     showDivs(slideIndex = n);
   }

   function showDivs(n) {
     var i;
     var x = document.getElementsByClassName("mySlides");
     var dots = document.getElementsByClassName("demo");
     if (n > x.length) {slideIndex = 1}
     if (n < 1) {slideIndex = x.length}
     for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
     }
     for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" w3-white", "");
     }
     x[slideIndex-1].style.display = "block";
     dots[slideIndex-1].className += " w3-white";
   }
   </script>
</body>

</html>
