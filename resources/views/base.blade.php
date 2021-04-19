<!doctype html>

<html>

    <head>
        <title>Registre Artisant</title>
        <meta charset="utf-8">

        <link rel="icon" type="image/jpeg" href="{{ asset('img/mica.jpg') }}">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/chart.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" ></script>
        <script src="{{ asset('js/all.js') }}" ></script>
        <script src="{{ asset('js/jquery.min.js') }}" ></script>
        <script src="{{ asset('js/chart.js')}}" ></script>
        <script src="{{ asset('js/jquery.datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.min.js') }}"></script>
        <script src="{{asset('js/scripts.js')}}"></script>
    </head>

    <body>
        <div class="row" id="body" style="margin:0px;">
          <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #454f58; width:100%" >
            <a class="navbar-brand" href="{{route('homeArtisant')}}"><i class="fas fa-home" aria-hidden="true"></i></a>
          
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent" >
              
              <ul class="navbar-nav mr-auto ">
          
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Antananarivo
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{route('globalTana')}}">Toute la province</a>        
                      <a class="dropdown-item" href="{{route('analamanga')}}">Analamanga</a>
                      <a class="dropdown-item" href="{{route('vakinankaratra')}}">Vakinankaratra</a>
                      <a class="dropdown-item" href="{{route('itasy')}}">Itasy</a>
                      <a class="dropdown-item" href="{{route('bongolava')}}">Bongolava</a>
                  </div>
                </li>
          
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Toamasina
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{route('globalToam')}}">Toute la province</a> 
                      <a class="dropdown-item" href="{{route('atsinanana')}}">Atsinanana</a>
                      <a class="dropdown-item" href="{{route('analanjirofo')}}">Analanjirofo</a>
                      <a class="dropdown-item" href="{{route('alaotramangoro')}}">Alaotra Mangoro</a>
                  </div>
                </li>
          
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Antsiranana
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{route('globalAntsir')}}">Toute la province</a> 
                      <a class="dropdown-item" href="{{route('diana')}}">Diana</a>
                      <a class="dropdown-item" href="{{route('sava')}}">Sava</a>
                  </div>
                </li>
          
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Fianarantsoa
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{route('globalFianar')}}">Toute la province</a> 
                      <a class="dropdown-item" href="{{route('hautematsiatsa')}}">Matsiatsa Ambony</a>
                      <a class="dropdown-item" href="{{route('amoronimania')}}">Amoron'i mania</a>
                      <a class="dropdown-item" href="{{route('ihorombe')}}">Ihorombe</a>
                      <a class="dropdown-item" href="{{route('vatovavyfitovinany')}}">vato Vavy Fito Vinany</a>
                      <a class="dropdown-item" href="{{route('atsimoatsinanana')}}">Atsimo Atsinanana</a>
                  </div>
                </li>
          
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mahajanga
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{route('globalMahaj')}}">Toute la province</a> 
                      <a class="dropdown-item" href="{{route('boeny')}}">Boeny</a>
                      <a class="dropdown-item" href="{{route('melaky')}}">Melaky</a>
                      <a class="dropdown-item" href="{{route('sofia')}}">Sofia</a>
                      <a class="dropdown-item" href="{{route('betsiboka')}}">Betsiboka</a>
                  </div>
                </li>
          
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Toliara
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{route('globalTol')}}">Toute la province</a> 
                      <a class="dropdown-item" href="{{route('atsimoandrefana')}}">Atsimo Andrefana</a>
                      <a class="dropdown-item" href="{{route('menabe')}}">Menabe</a>
                      <a class="dropdown-item" href="{{route('androy')}}">Androy</a>
                      <a class="dropdown-item" href="{{route('anosy')}}">Anosy</a>
                  </div>
                </li>
          
              </ul>
          
              <div class="form-inline my-2 my-lg-0" style="margin-right:">
                <ul class="navbar-nav mr-auto" >
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <button type="button" class="btn btn-success">Création</button>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('createArtisant')}}"><button type="button" class="btn btn-primary">Nouvel Artisant</button></a> 
                        <a class="dropdown-item" href="{{route('createMetier')}}"><button type="button" class="btn btn-warning">Régistre Métier</button></a>
                    </div>
                  </li>
                </ul>
          
                <ul class="navbar-nav ml-auto">
                  <!-- Authentication Links -->
                  @guest
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                      </li>
                      @if (Route::has('register'))
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                          </li>
                      @endif
                  @else
                      <li class="nav-item dropdown">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              {{ Auth::user()->name }}
                          </a>
          
                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  Se deconnecter
                              </a>
                              <a class="dropdown-item" href="{{ route('gestionUsers') }}">
                                Gestion d'utilisateur
                              </a>
          
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                  @csrf
                              </form>
                          </div>
                      </li>
                  @endguest
              </ul>
              </div>
          
            </div>
          </nav>
          
          <header class="row" id="header" style="width:100% ; position: relative;">
            <div class="col-md-2" style="text-align: center;"><img src="{{ asset('img/mc.jpg') }}" alt="en tete" style="; max-height:130px;"></div>
            <div class="col-md-10"><h1 class="text-center text-md-right" style="padding-top: 40px;"><b>DIRECTION CHARGEE DE L'ARTISANAT</b></h1></div>  
          </header>
          
          <div class="container-fluid" style="margin-bottom: 56px;">
              @yield('body')
          </div>
          
          <!-- Footer -->
          <footer class="page-footer fixed-bottom" style="width: 100%; background-color:rgb(84, 82, 82); text-align:center;">
            
              <div class="row d-flex align-items-center container-fluid" style="padding-top: 15px;">
                <div class="col-md-7 col-lg-7">
                  <!--Copyright-->
                  <p class="text-center text-md-right" style="color: aliceblue">© 2020 Copyright by <strong>MICA</strong></p>
                </div>
          
                <div class="col-md-5 col-lg-5 ml-lg-0">
                  <div class="text-center text-md-right">
                    <ul class="list-unstyled list-inline">
                      <li class="list-inline-item">
                        <a class="btn-floating btn-md rgba-white-slight mx-1" href="https://www.facebook.com/MICAMADA2019">
                          <i class="fab fa-facebook-f"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a class="btn-floating btn-md rgba-white-slight mx-1" href="http://www.mica.gov.mg/?fbclid=IwAR2B2Wo3by0XAOJ5up-wO4zGG5Vz6jDIw6FbxpNbTUy6Baa4n-PoB-TCFKQ">
                          <i class="fas fa-globe"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a class="btn-floating btn-md rgba-white-slight mx-1" href="https://www.linkedin.com/in/mica-mada-6132b9184/">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
          
                </div>
                <!-- Grid column -->
          
              </div>
            
            </footer>
          <!-- Footer -->  
        </div>
    </body>

</html>