@extends('base')

@section('body')

<div class="alert alert-secondary form-inline  row">
    <div class="col-md-8"><h2 >{{$titre ?? 'Titre pas encore definie'}}</h2></div>
    <div class="col-sm-4 text-center text-md-right"><h2><span class="badge badge-warning">{{$nb." Artisan(s)"}}</span></h2></div>
</div>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="margin-top: 8px;">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Liste des artisans</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Répartion des Artisans</a>
    </div>
</nav>

<div class="tab-content" id="nav-tabContent">
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
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        @include('composants.list', [
            'artisants'=>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
        ])
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">      
        @include('composants.stat')
    </div>
</div>

@endsection