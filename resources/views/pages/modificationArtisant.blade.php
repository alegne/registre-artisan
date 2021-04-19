@extends('base')

@section('body')

<div class="alert alert-success form-inline my-2 my-lg-0 row">
  <div class="col-sm-10">
    <h2 class="">Modification d'un Artisant</h2>
  </div>
  <div style="float: right;" class="col-sm-2">
    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEditEditMetier" >Créer un Métier</button>
  </div>
</div>

<div class="container">

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

  <form method="POST" action="{{route('updateArtisant')}}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{$artisant->id}}" name="id">
    <input type="hidden" value="{{$url}}" name="url">
    
    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="numArtisant">Numero Artisant</label>
          <input type="text" name="numArtisant" value="{{$artisant->num}}" class="form-control-sm form-control" id="numArtisant" placeholder="25469102458001" required maxlength="14" minlength="14" pattern="[0-9]{14}">

          <label for="name">Nom ou Nom de la société</label>
          <input type="text" name="nomArtisant" value="{{$artisant->name}}" class="form-control-sm form-control" id="nomArtisant" placeholder="Nom" required>

          <label for="prenom">Prénom(s)</label>
          <input type="text" name="prenomArtisant" value="{{$artisant->prenom}}" class="form-control-sm form-control" id="prenomArtisant" placeholder="Prénom(s)">
          
          <label for="dateNaiss">Date de naissance</label>
          <input type="date" name="dateNaiss" value="{{$artisant->dateNaissance}}" class="form-control-sm form-control @error('dateNaiss') is-invalid @enderror" id="dateNaiss" required>
          @error('dateNaiss')
            <div class="invalid-feedback">{{$message}}</div>
          @enderror

          <label for="lieuNaiss">Lieu de Naissance</label>
          <input type="text" name="lieuNaiss" value="{{$artisant->lieuNaissance}}" class="form-control-sm form-control" id="lieuNaiss" placeholder="Lieu de naissance" required>

          <label for="cin">CIN</label>
          <input type="text" name="cin" value="{{$artisant->cin}}" class="form-control-sm form-control" id="cin" placeholder="501031254210" required maxlength="12" minlength="12" pattern="^[1-9][0-9]{11}">

          <label for="adresse">Adresse</label>
          <input type="text" name="adresse" value="{{$artisant->adresse}}" class="form-control-sm form-control" id="adresse" placeholder="Adresse" required>  

          <label for="cartier">Fokontany</label>
          <input type="text" name="cartier" value="{{$artisant->cartier}}" class="form-control-sm form-control" id="cartier" placeholder="Fokontany" required>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label for="commune">Commune</label>
          <input type="text" name="commune" value="{{$artisant->commune}}" class="form-control-sm form-control" id="commune" placeholder="Commune" required>

          <label for="district">District</label>
          <input type="text" name="district" value="{{$artisant->district}}" class="form-control-sm form-control" id="district" placeholder="District" required>

          <label for="region">Région</label>
          <select class="custom-select custom-select-sm mr-sm-2" id="region" name="region">
            @foreach ($regions as $region)
              @if ($region->id == $artisant->region->id)
                <option value="{{$region->name}}" selected>{{$region->name}}</option>
              @else
                <option value="{{$region->name}}">{{$region->name}}</option>
              @endif  
            @endforeach
          </select>
          
          <label for="numStat">Numero Statistique</label>
          <input type="text" name="numStat"  value="{{$artisant->numStat}}" class="form-control-sm form-control" id="numStat" placeholder="Numero Statistique" required maxlength="17" minlength="17" pattern="\d{17}">

          <label for="nif">NIF</label>
          <input type="text" name="nif"  value="{{$artisant->nif}}" class="form-control-sm form-control" id="nif" placeholder="Numero d'identification fiscal" required maxlength="10" minlength="10" pattern="\d{10}">

          <label for="numCarte">Numero de la Carte</label>
          <input type="text" name="numCarte" value="{{$artisant->numCarte}}" class="form-control-sm form-control" id="numCarte" placeholder="0001/L ou 0001/F" required pattern="^[0-9]+\/(l|f|L|F)">

          <label for="dateDelivre">Date de délivrance</label>
          <input type="date" name="dateDelivre"  value="{{$artisant->dateDelivrance}}" class="form-control-sm form-control @error('dateDelivre') is-invalid @enderror" id="dateDelivre" required>
          @error('dateDelivre')
            <div class="invalid-feedback">{{"La date doit être anterieur à la date d'aujourd'hui"}}</div>
          @enderror

          <label for="lieuDelivre">Lieu de délivrance</label>
          <input type="text" name="lieuDelivre"  value="{{$artisant->lieuDelivrance}}" class="form-control-sm form-control" id="lieuDelivre" placeholder="Lieu de délivrance" required>  
        </div> 
      </div>

      <div class="col">
        <div class="form-group">
          <label for="activPrincipal">Activité Principal</label>
          <select class="custom-select custom-select-sm mr-sm-2" id="activPrincipal" name="activPrincipal">
            <span hidden>{{$i=1}}</span>
            @foreach ($artisant->metiers as $met)
              @if ($i == 1)
                @foreach ($metiers as $metier)
                @if ($metier->id == $met->id)
                  <option value="{{$metier->name}}" selected>{{$metier->name}}</option>
                @else
                  <option value="{{$metier->name}}">{{$metier->name}}</option>
                @endif
                @endforeach
              @endif
              <span hidden>{{$i++}}</span>
            @endforeach
          </select>

            <label for="datePrincipale">Début d'activité Principal</label>
            <span hidden>{{$i = 1 }}</span>
            @foreach ($artisant->metiers as $met)
              @if ($i == 1)
                <input type="date" name="datePrincipale"  value="{{$met->pivot->dateDebut}}" class="form-control-sm form-control @error('datePrincipale') is-invalid @enderror" id="datePrincipale" required>
                @error('datePrincipale')
                  <div class="invalid-feedback">{{"La date doit être anterieur à la date d'aujourd'hui"}}</div>
                @enderror           
              @endif
              <span hidden>{{$i++}}</span>
            @endforeach

            <label for="activSecondaire">Activité Secondaire</label>
            <select class="custom-select custom-select-sm mr-sm-2" id="activSecondaire" name="activSecondaire">
              <span hidden>{{$i=1}}</span>
              <span hidden>{{$t = false }}</span>
              <option value="Rien" selected>Rien</option>
              @foreach ($artisant->metiers as $met)
                @if ($i == 2)
                  @foreach ($metiers as $metier)
                  @if ($metier->id == $met->id)
                    <option value="{{$metier->name}}" selected>{{$metier->name}}</option>
                  @else
                    <option value="{{$metier->name}}">{{$metier->name}}</option>
                  @endif
                  @endforeach
                  <span hidden>{{$t = true}}</span> 
                @endif
                <span hidden>{{$i++}}</span>
              @endforeach
              @if (!$t)
              <option value="Rien" selected>Rien</option>
              @foreach ($metiers as $metier)
                <option value="{{$metier->name}}">{{$metier->name}}</option>
              @endforeach
              @endif
            </select>
  
            <label for="dateSecondaire">Début d'activité Secondaire</label>
            <span hidden>{{$i = 1 }}</span>
            <span hidden>{{$t = false }}</span>
            @foreach ($artisant->metiers as $met)
              @if ($i == 2)
                <input type="date" name="dateSecondaire"  value="{{$met->pivot->dateDebut}}" class="form-control-sm form-control @error('dateSecondaire') is-invalid @enderror" id="dateSecondaire">
                @error('datePrincipale')
                  <div class="invalid-feedback">{{"La date doit être anterieur à la date d'aujourd'hui"}}</div>
                @enderror
                <span hidden>{{$t = true}}</span>           
              @endif
              <span hidden>{{$i++}}</span>
            @endforeach
            @if (!$t)
              <input type="date" name="dateSecondaire" class="form-control-sm form-control @error('dateSecondaire') is-invalid @enderror" id="dateSecondaire" >
              @error('datePrincipale')
                <div class="invalid-feedback">{{"La date doit être anterieur à la date d'aujourd'hui"}}</div>
              @enderror
            @endif  
            <div class="container-fluid" style="text-align: center;">
              <div class="imgVisu" style="align-items: center; margin-top:30px;">
                <label for="photo">
                  @if ($artisant->urlPhoto == null)
                    <img src="{{asset('img/user1.png')}}" alt="img prev" class="imgDw rounded" style="width: 155px; height:160px;">
                  @else
                    <img src="{{asset($artisant->urlPhoto)}}" alt="img prev" class="imgDw rounded img-circle" style="width: 155px; height:160px;">
                  @endif   
                </label>
                <span id="delPhoto" style="position: absolute; bottom:1;"><i class="fas fa-user-minus"></i></span>
              </div>
              @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 5px; padding-bottom:0">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
              <input type="file" id="photo" style="display:none; @error('photo') is-invalid @enderror" name="photo">
              @error('photo')
                <div class="invalid-feedback">{{'la photo doit etre au format jpeg ou png'}}</div>
              @enderror
            </div>
        </div> 
      </div>
    </div>
    <div class="modal-footer">
      <!--<a href="{{URL::previous()}}"><button type="button" class="btn btn-danger">Annuler</button></a>-->
      <button type="submit" class="btn btn-success">Sauvegarder</button>
    </div>
  </form>
</div>

<div class="modal fade" id="modalEditEditMetier" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Ajout d'un Metier</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('insertMetier')}}">
          @csrf
            <label for="metier">Métier</label>
          <input name="metier" type="text" class=" form-control" id="metier" placeholder="Nom du métier" required>
            
          <label for="filiere">Filière&nbsp;&nbsp;
            <span id="plus1"><i class="fas fa-plus" aria-hidden="true" style="margin-left: 8px;"></i></span>
            <span id="plus2" style="display:none;"><i class="fas fa-plus" aria-hidden="true" style="margin-left: 8px;"></i></span>
          </label>
          
          <select class="custom-select  mr-sm-2"  name="filiere" id="fil" style="display:">
            @foreach ( $filieres as $filiere)
                <option  value="{{$filiere->name}}">{{$filiere->name}}</option>
            @endforeach  
          </select>

          <div id="placeElement">
            
          </div>
          
          <label for="categorie1">Catégorie(s)</label>
          <select class="custom-select mr-sm-2" id="categorie" name="categorie1">
            @foreach ( $categories as $categorie)
          <option  value="{{$categorie->name}}">{{$categorie->name}}</option>
            @endforeach  
          </select>
          <label for="categorie2"></label>
          <select class="custom-select mr-sm-2" id="categorie" name="categorie2">
            @foreach ( $categories as $categorie)
          <option  value="{{$categorie->name}}">{{$categorie->name}}</option>
            @endforeach  
          </select>
          <label for="categorie3"></label>
          <select class="custom-select mr-sm-2" id="categorie" name="categorie3">
            @foreach ( $categories as $categorie)
          <option  value="{{$categorie->name}}">{{$categorie->name}}</option>
            @endforeach  
          </select>

          <div style="text-align: center; margin-top: 10%;">
          <button class=" btn btn-primary" type="submit">Ajouter Métier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  const nvFichier = document.getElementById('photo');
  const imgDw = document.querySelector('.imgDw');
  const txt = document.querySelector('.txt');
  
  nvFichier.addEventListener('change', function(){
    const fichier = this.files[0];
  
   if(fichier){
      const analyseur = new FileReader();
      analyseur.readAsDataURL(fichier);
      analyseur.addEventListener('load', function(){
        imgDw.setAttribute('src', this.result);
      })
    }
  })
</script>

<script type="text/javascript">
    var element = "<input name='filiereAutre' type='text' class='form-control' id='filiereAutre' placeholder='Précision de la filière si Autres' required >"
    var select = document.getElementById( "fil" )
    var input = document.getElementById( "placeElement" )
    var plus1 = document.getElementById( "plus1" )
    var plus2 = document.getElementById( "plus2" )
    plus1.addEventListener( "click", function (){ 
        plus1.style.display = "none"
        plus2.style.display = "inline"
        select.style.display = "none"
        input.innerHTML = element

    } )

  plus2.addEventListener( "click", function ()
    {   
      plus2.style.display = "none"
      plus1.style.display = "inline-block"
      select.style.display = "inline-block"
      input.innerHTML= ""
    } )
</script>

<script>
  var boutton = document.getElementById("delPhoto")
  var input = document.getElementById('photo')
  var photo = document.querySelector('.imgDw')

  boutton.addEventListener('click', function(){
    input.setAttribute('value', '')
    photo.setAttribute('src', '{{asset("img/user1.png")}}')
  })
</script>

@endsection
