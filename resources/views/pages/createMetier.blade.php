@extends('base')

@section('body')

  <div class="row alert alert-primary">
    <h2 class="">Régistre des Métiers</h2>
  </div>

  <div class="container-fluid">

    @if (Session::get('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('status')}} 
            <button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{Session::get('error')}} 
            <button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <div class="row">
      <div class="col-md-9">
        <div class="table-responsive text-nowrap">
          <table id="example" class="table w-auto table-hover" width="100%">
            <thead class="">
              <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">Métiers</th>
                <th scope="col">Filières</th>
                <th scope="col">Catégorie(s)</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($metcategories as $metier )
                <tr>
                  <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEdit{{$metier->id}}"><i class="fas fa-edit" aria-hidden="true"></i></button></td>
                  <td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalSuppMetier{{$metier->id}}"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
                  <td>{{$metier->name}}</td>
                  <td>{{$metier->filiere->name}}</td>
                    @foreach ($metier->categories as $categorie)
                      @if ($categorie->name != "Rien")
                        <td>{{$categorie->name}}</td>
                      @endif
                    @endforeach
                    @include('composants.modalSuppMetier', ['id'=>$metier->id, 'fil_id'=>$metier->filiere_id])
                    @include('composants.modalEditMetier', ['metcategories'=>$metier, 'filieres'=>$filieres, 'categories'=>$categories])
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
        
      <div class="col-md-3">
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
              <button class=" btn btn-secondary" type="reset">Vider les champs</button>
              <button class=" btn btn-primary" type="submit">Ajouter Métier</button>
            </div>
          </form>
      </div>        
    </div>
  </div>

  <script type="text/javascript">
    var element = "<input name='filiereAutre' type='text' class='form-control' id='filiereAutre' placeholder='Précision de la filière si Autres' required>"
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
    $(document).ready(function() {
      $('#example').DataTable();
    } );
  </script>

@endsection