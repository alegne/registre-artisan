
<div class="modal fade" id="modalEdit{{$metcategories->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Modification d'un Metier</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('updateMetier')}}">
            @csrf
              
            <div class="form-group">
              <input type="hidden" value="{{$metcategories->id}}" name="id">
              <label for="metier">Métier</label>
              <input name="metier" type="text" class=" form-control" id="metier" placeholder="Nom du métier" value="{{$metcategories->name}}" required>
            </div>
          
            <div class="form-group">
              <label for="filiere">Filière</label>
              <!--
              <span id="plus11"><i class="fas fa-plus" aria-hidden="true" style="margin-left: 8px;"></i></span>
              <span id="plus21" style="display:;"><i class="fas fa-plus" aria-hidden="true" style="margin-left: 8px;"></i></span>
              -->
              <br>
              
              <select class="custom-select  mr-sm-2" name="filiere" id="fil1" style="display:">
                @foreach ( $filieres as $filiere)
                  @if ($filiere->id == $metcategories->filiere->id)
                  <option  value="{{$filiere->name}}" selected>{{$filiere->name}}</option>
                  @else
                  <option  value="{{$filiere->name}}">{{$filiere->name}}</option>
                  @endif
                @endforeach  
              </select>

              
              <div id="placeElement1" style="display: none">
                <input name='filiereAutre1' type='text' class='form-control' id='filiereAutre1' placeholder='Précision du filière'>
              </div>
            </div>
            
            <div class="form-group">
              <label for="categorie2">Catégorie(s)</label><br>
              <select class="custom-select mr-sm-2" id="categorie" name="categorie2">
                {{$i = 1}}
                @foreach ( $metcategories->categories as $categ)
                  @foreach ($categories as $cat)
                    @if ($i == 2)
                        @if ($categ->id == $cat->id)
                          <option  value="{{$cat->name}}" selected>{{$cat->name}}</option>
                        @else
                          <option  value="{{$cat->name}}">{{$cat->name}}</option>
                        @endif
                    @endif
                  @endforeach
                  {{$i++}}
                @endforeach  
              </select>
            </div>
        
            <div class="form-group">
              <label for="categorie3"></label>
              <select class="custom-select mr-sm-2" id="categorie" name="categorie3">
                {{$i = 1}}
                @foreach ( $metcategories->categories as $categ)
                  
                  @foreach ($categories as $cat)
                    @if ($i == 3)
                        @if ($categ->id == $cat->id)
                          <option  value="{{$cat->name}}" selected>{{$cat->name}}</option>
                        @else
                          <option  value="{{$cat->name}}">{{$cat->name}}</option>
                        @endif
                    @endif
                  @endforeach
                  {{$i++}}
                @endforeach
                @if ($i == 3)
                  @foreach ($categories as $cat)
                    <option  value="{{$cat->name}}">{{$cat->name}}</option>
                  @endforeach
                @endif  
              </select>
            </div>
                
            <div class="form-group">
              <label for="categorie1"></label>
              <select class="custom-select mr-sm-2" id="categorie" name="categorie1">
                {{$i = 1}}
                @foreach ( $metcategories->categories as $categ)
                    @foreach ($categories as $cat)
                      @if ($i == 1)
                          @if ($categ->id == $cat->id)
                            <option  value="{{$cat->name}}" selected>{{$cat->name}}</option>
                          @else
                            <option  value="{{$cat->name}}">{{$cat->name}}</option>
                          @endif
                      @endif
                    @endforeach
                  {{$i++}}
                @endforeach
              </select>
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

<script type="text/javascript">

  /*premiere element iny avao ro mety diteva
  var element1 = "<input name='filiereAutre1' type='text' class='form-control' id='filiereAutre1' placeholder='Précision du filière' required >"
  var select1 = document.getElementById( "fil1" )
  var input1 = document.getElementById( "placeElement1" )
  var filAutre = document.getElementById("filiereAutre1")
  var plus11 = document.getElementById( "plus11" )
  var plus21 = document.getElementById( "plus21" )
  plus11.addEventListener( "click", function (){ 
    plus11.style.display = "none"
    plus21.style.display = "inline"
    select1.style.display = "none"
    input1.style.display = "inline"
    filAutre.required = 'required'
  } )

  plus21.addEventListener( "click", function ()
  {   
    plus21.style.display = "none"
    plus11.style.display = "inline-block"
    select1.style.display = "inline-block"
    input1.style.display = "none"
    filAutre.required = ''
  } )*/
</script>