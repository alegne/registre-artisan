@extends('base')

@section('body')

<div class="alert alert-secondary form-inline  row">
    <div class="col-md-8"><h2 >{{$titre ?? 'Titre pas encore definie'}}</h2></div>
    <div class="col-sm-4 text-center text-md-right"><h2><span class="badge badge-warning">{{$nb." Utilisateurs(s)"}}</span></h2></div>
</div>
@if (Session::get('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 5px;">
            {{Session::get('status')}} 
            <button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 5px;">
            {{Session::get('error')}} 
            <button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

<div class="container-fluid row" id="">
   <div class="col-md-6">
        <table id="dt-cell-sellection" class="table table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Nom</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <span hidden>{{$userId = Auth::user()->id}}</span>
                        @if ($userId == 1)
                            @if ($user->id == 1)
                                <td><button disabled type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalSupp{{$user->id}}"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
                                <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEdit{{$user->id}}"><i class="fas fa-edit" aria-hidden="true"></i></button></td>
                            @else
                                <td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalSupp{{$user->id}}"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
                                <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEdit{{$user->id}}"><i class="fas fa-edit" aria-hidden="true"></i></button></td>
                            @endif
                        @else
                            @if ($user->id == 1 || $userId != $user->id)
                                <td><button disabled type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalSupp{{$user->id}}"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
                                <td><button disabled type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEdit{{$user->id}}"><i class="fas fa-edit" aria-hidden="true"></i></button></td>
                            @else
                                <td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalSupp{{$user->id}}"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
                                <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEdit{{$user->id}}"><i class="fas fa-edit" aria-hidden="true"></i></button></td>
                            @endif
                        @endif
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <!--modal de suppression-->
                        <div class="modal fade" id="modalSupp{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title" id="exampleModalLongTitle">Suppression d'un Utilisateur</h3>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <h4>Voulez vous vraiment supprimer cet utilisateur: {{$user->name}} ?</h4>
                                  <p>La suppression d'un utilisateur resulte qu'il ne puisse plus se connecter à cette application</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <a href="{{route('gestionUsersDelete', ['id'=>$user->id])}}"><button type="button" class="btn btn-danger">Supprimer</button></a>
                                </div>
                              </div>
                            </div>
                        </div>
                        <!--modal de modification-->
                        <div class="modal fade" id="modalEdit{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title" id="exampleModalLongTitle">Modification d'un Utilisateur</h3>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('gestionUsersUpdate', ['id'=>$user->id]) }}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="inputFirstName">Nom</label>
                                                    <input id="inputFirstName" type="text" class="form-control py-4 @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="Entrez votre nom" max="255">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmailAddress">E-mail</label>
                                            <input id="inputEmailAddress" aria-describedby="emailHelp" type="email" class="form-control py-4 @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email"  placeholder="Entrez votre E-mail">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPassword">Entrez le nouveau mot de passe</label>
                                                    <input id="inputPassword" type="password" class="form-control py-4 @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" placeholder="Entrez votre mot de passe" minlength="8">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputConfirmPassword">Confirmez le mot de passe</label>
                                                    <input id="inputConfirmPassword" type="password" class="form-control py-4" name="password_confirmation"  autocomplete="new-password" placeholder="confirmez votre mot de passe" minlength="8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-success">Sauvegarder</button></a>
                                        </div>
                                    </form>
                                </div>
                              </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
   </div>
   <div class="col-md-6">
    <div class="card-body">
        <form method="POST" action="{{ route('gestionUsersAdd') }}">
            @csrf
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputFirstName">Nom</label>
                        <input id="inputFirstName" type="text" class="form-control py-4 @error('name') is-invalid @enderror" name="name"  required autocomplete="name" autofocus placeholder="Entrez votre nom" max="255">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmailAddress">E-mail</label>
                <input id="inputEmailAddress" aria-describedby="emailHelp" type="email" class="form-control py-4 @error('email') is-invalid @enderror" name="email"  required autocomplete="email"  placeholder="Entrez votre E-mail">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputPassword">Mot de passe</label>
                        <input id="inputPassword" type="password" class="form-control py-4 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Entrez votre mot de passe" minlength="8">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputConfirmPassword">Confirmez le mot de passe</label>
                        <input id="inputConfirmPassword" type="password" class="form-control py-4" name="password_confirmation" required autocomplete="new-password" placeholder="confirmez votre mot de passe" minlength="8">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-center col-6"><button type="reset" class="btn btn-secondary btn-block">Vider les champs</button></div>
                <div class="text-center col-6"><button type="submit" class="btn btn-primary btn-block">Créer</button></div>
            </div>
        </form>
    </div>
   </div>
</div>

<script>
    $(document).ready(function () {
        $('#dt-cell-sellection').dataTable({

        select: {
            style: 'os',
            items: 'cell'
        }
        });
    });
</script>
@endsection