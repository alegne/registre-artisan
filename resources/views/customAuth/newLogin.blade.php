<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="icon" type="image/jpeg" href="{{ asset('img/mica.jpg') }}">
        <title>Authentification</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" />
        <script src="{{asset('js/all.js')}}" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="text-center">
                            <img src="{{asset('img/mc.jpg')}}" alt="" style="max-width: 350px;  margin-bottom:20px;">
                            <span><h3>Authentification</h3></span>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                    <input class="form-control py-4 @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="inputEmailAddress" type="email" placeholder="Par defaut: admin@artisanat.mg" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputPassword">Mot de passe</label>
                                    <input id="inputPassword" type="password" class="form-control py-4 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"  placeholder="Par defaut: password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" id="rememberPasswordCheck" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="rememberPasswordCheck">Se souvenir de moi</label>
                                    </div>
                                </div>
                                <div class="modal-footer " >
                                    <button type="submit" class="btn btn-success" >S'authentifier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="{{asset('js/jquery.min.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
</html>
