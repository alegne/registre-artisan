<div class="modal fade" id="modalSuppMetier{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
     
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Suppression d'un Metier ou une Filière</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p>Veuillez confirmer votre choix</p>
        <b>Attention:</b><p>La suppression d'une filiere entraine la suppression des metiers <br> correspondants</p>
      </div>
      
      <div class="modal-footer">
        <a href="{{route('suppFiliere', ['id'=>$fil_id])}}"><button type="button" class="btn btn-danger">Filière</button></a>
        <a href="{{route('suppMetier', ['id'=>$id])}}"><button type="button" class="btn btn-warning">Métier</button></a>
      </div>
      
    </div>
  </div>
</div>

