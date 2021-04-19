@extends('base')

@section('body')

<div class="alert alert-secondary form-inline my-2 my-sm-0 row">
    <div class="col-sm-9"><h3>Nom: {{$artisant->name." ".$artisant->prenom}}</h3></div>
    <div class="col-sm-3"><h3>Matricule: {{$artisant->num}}</h3></div>
</div>

<div class="container" style="margin-top:0.7%">
    <div class="row">
        <div class="col">
            <div class="imgVisu">
                @if ($artisant->urlPhoto == null)
                    <img src="{{asset('img/user1.png')}}" alt="img prev" class="imgDw rounded" style="width: 135px; height:140px;">
                @else
                    <img src="{{asset($artisant->urlPhoto)}}" alt="img prev" class="imgDw rounded" style="width: 135px; height:140px;">
                @endif  
            </div><br> 
            <label for="matricule">Matricule:</label>
            <h5 class="" id="matricule">{{$artisant->num}}</h5>

            <label for="nom">Nom:</label>
            <h5 class="" id="nom">{{$artisant->name}}</h5>
            <h5 class="" id="prenom">{{$artisant->prenom}}</h5>

            <label for="cin">CIN:</label>
            <h5 class="" id="numArtisant">{{$artisant->cin}}</h5>

            <label for="dateNaiss">Date de naissance:</label>
            <h5 class="primary" id="dateNaiss">{{\Carbon\Carbon::parse($artisant->dateNaissance)->format('d M Y')}}</h5>

            <label for="lieuNaiss">Lieu de Naissance:</label>
            <h5 class="primary" id="lieuNaiss">{{$artisant->lieuNaissance}}</h5><br>
        </div>

        <div class="col">
            <div class="form-group"> 
                <label for="adresse">Adresse:</label>
                <h5 class="primary" id="adresse">{{$artisant->adresse}}</h5><br>

                <label for="cartier">Fokontany:</label>
                <h5 class="primary" id="cartier">{{$artisant->cartier}}</h5><br>

                <label for="commune">Commune:</label>
                <h5 class="primary" id="commune">{{$artisant->commune}}</h5><br>

                <label for="district">District:</label>
                <h5 class="primary" id="district">{{$artisant->district}}</h5><br>

                <label for="region">Région:</label>
                <h5 class="primary" id="region">{{$artisant->region->name}}</h5><br>

                <label for="province">Province:</label>
                <h5 class="primary" id="province">{{$artisant->region->province->name}}</h5><br>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="numStat">Numero Statistique:</label>
                <h5 class="primary" id="numStat">{{$artisant->numStat}}</h5><br>
               
                <label for="nif">NIF:</label>
                <h5 class="primary" id="nif">{{$artisant->nif}}</h5><br>

                <label for="numCarte">Numero de la Carte:</label>
                <h5 class="primary" id="numCarte">{{$artisant->numCarte}}</h5><br>

                <label for="dateDelivre">Date de délivrance:</label>
                <h5 class="primary" id="dateDelivre">{{\Carbon\Carbon::parse($artisant->dateDelivrance)->format('d M Y')}}</h5><br>
                
                <label for="lieuDelivre">Lieu de délivrance:</label>
                <h5 class="primary" id="lieuDelivre">{{$artisant->lieuDelivrance}}</h5><br>
            </div>   
        </div>

        <div class="col">
            <div class="form-group">
                <label for="activPrincipal">Activité Principal:</label>
                <span hidden>{{$i = 1 }}</span>
                @foreach ($artisant->metiers as $met)
                  @if ($i == 1)
                    <h5 class="primary" id="activPrincipal">{{$met->name}}</h5>
                    <label for="filiere">Filière:</label>
                    <h5>{{$met->filiere->name}}</h5>   
                    <label for="categorie">Catégorie(s):</label> 
                    @foreach ($met->categories as $categorie)
                        @if ($categorie->name != 'Rien')
                            <h5>{{$categorie->name}}</h5>
                        @endif
                    @endforeach       
                  @endif
                  <span hidden>{{$i++}}</span>
                @endforeach

                <label for="datePrincipale">Date de début d'activité Principal:</label>
                <span hidden>{{$i = 1 }}</span>
                  @foreach ($artisant->metiers as $met)
                    @if ($i == 1)
                        <h5 class="primary" id="datePrincipale">{{\Carbon\Carbon::parse($met->pivot->dateDebut)->format('d M Y')}}</h5><br>           
                    @endif
                    <span hidden>{{$i++}}</span>
                  @endforeach

                
                <label for="activSecondaire">Activité Secondaire:</label>      
                <span hidden>{{$i=1}}</span>
                <span hidden>{{$t = false }}</span>
                @foreach ($artisant->metiers as $met)
                    @if ($i == 2)
                        <h5 class="primary" id="activSecondaire">{{$met->name}}</h5>
                        <label for="filiere">Filière:</label>
                        <h5>{{$met->filiere->name}}</h5>   
                        <label for="categorie">Catégorie(s):</label> 
                        @foreach ($met->categories as $categorie)
                            @if ($categorie->name != 'Rien')
                                <h5>{{$categorie->name}}</h5>
                            @endif
                        @endforeach    
                        <span hidden>{{$t = true}}</span> 
                    @endif
                    <span hidden>{{$i++}}</span>
                @endforeach
                @if (!$t)
                    <h5 class="primary" id="activSecondaire">Pas de métier secondaire</h5><br>
                @endif

                <label for="dateSecondaire">Date de début d'activité Secondaire:</label>
                <span hidden>{{$i=1}}</span>
                <span hidden>{{$t = false }}</span>
                @foreach ($artisant->metiers as $met)
                    @if ($i == 2)
                        @if ($met->pivot->dateDebut != null)
                            <h5 class="primary" id="activSecondaire">{{\Carbon\Carbon::parse($met->pivot->dateDebut)->format('d M Y')}}</h5><br>
                            <span hidden>{{$t = true}}</span> 
                        @else
                            <h5 class="primary" id="activSecondaire">Pas de date</h5><br>
                            <span hidden>{{$t = true}}</span> 
                        @endif
                    @endif
                    <span hidden>{{$i++}}</span>
                @endforeach
                @if (!$t)
                    <h5 class="primary" id="activSecondaire">Pas de date</h5><br>
                @endif
            </div>     
        </div>
    </div>
    <div class="modal-footer">
        <a href="{{URL::previous()}}"><button type="button" class="btn btn-secondary">Retour</button></a>
    </div>
</div>

@endsection