<!-- Header -->
<header>
    <div class="container">
        <div class="intro-text">
           {{-- <div class="intro-lead-in">Seja Bem-vindo!</div> --}}
           {{-- <div class="intro-heading">Seja Bem-Vindo!</div> --}}

           <div class="w3-content w3-display-container">
              <img class="mySlides" src="../img/a.jpg">
              <div class="w3-center w3-display-bottommiddle" style="width:100%">
                <div class="w3-left" onclick="plusDivs(-1)">&#10094;</div>
                <div class="w3-right" onclick="plusDivs(1)">&#10095;</div>
              </div>
              <br><br><br>
            </div>
            <a href="#about" class="page-scroll btn btn-xl home-btn">Saiba mais!</a>
            <a href="{{route('login')}}" class="page-scroll btn btn-xl" data-toggle="modal">ACESSE AQUI!</a>
            {{-- <a href="#loginModal" class="page-scroll btn btn-xl home-btn">ACESSE AQUI!</a> --}}
        </div>
    </div>
</header>
