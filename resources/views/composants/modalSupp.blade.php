<div class="modal fade" id="modalSupp{{$artisant->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Suppression d'un Artisan</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <h4>Voulez vous vraiment faire la suppression de l'artisan : {{$artisant->name}}</h4>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
      <a href="{{route('suppArtisant', ['id'=>$artisant->id])}}"><button type="button" class="btn btn-danger">Supprimer</button></a>
      </div>
      
    </div>
  </div>
</div>