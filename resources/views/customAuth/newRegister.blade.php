<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Création d'un compte</title>
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />
        <script src="{{asset('js/all.js')}}" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="text-center"><img src="{{asset('img/mc.jpg')}}" alt="" style="max-width: 350px; margin-bottom:20px;"><span><h3>Création d'un nouveau compte</h3></span></div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">Nom</label>
                                                        <input id="inputFirstName" type="text" class="form-control py-4 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Entrez votre nom">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                                <input id="inputEmailAddress" aria-describedby="emailHelp" type="email" class="form-control py-4 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="Entrez votre E-mail">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputPassword">Mot de passe</label>
                                                        <input id="inputPassword" type="password" class="form-control py-4 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Entrez votre mot de passe">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirmez le mot de passe</label>
                                                        <input id="inputConfirmPassword" type="password" class="form-control py-4" name="password_confirmation" required autocomplete="new-password" placeholder="confirmez votre mot de passe">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="text-center col-6"><a class="btn btn-secondary btn-block" href="login.html">Retour</a></div>
                                                <div class="text-center col-6"><button type="submit" class="btn btn-primary btn-block">Créer</button></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="{{asset('js/jquery.min.js')}}" crossorigin="anonymous"></script>
        <script src="{{asset('js/app.js')}}" crossorigin="anonymous"></script>
        <script src="{{asset('js/scripts.js')}}"></script>
    </body>
</html>