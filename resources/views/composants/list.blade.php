<div class="table-responsive " style="margin-top: 30px;">
  <table id="example" class="table table-hover" width="100%">
    <thead class="">
      <tr>
        <th class="th-sm"></th>
        <th class="th-sm"></th>
        <th class="th-sm"></th>
        <th class="th-sm">Numero</th>
        <th class="th-sm">Nom</th>
        <th class="th-sm">Commune</th>
        <th class="th-sm">District</th>
        <th class="th-sm">Activité Principale</th>
        <th class="th-sm">Filière</th>
        <th class="th-sm">Activité Secondaire</th>
        <th class="th-sm">Filière</th>
        <th class="th-sm">N° Carte</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($artisants as $artisant)
      <tr>
        <td><a href="{{route('detailsArtisant', ['id'=>$artisant->id])}}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-user" aria-hidden="true"></i></button></a></td>
        <td><a href="{{route('modificationArtisant', ['id'=>$artisant->id])}}"><button type="button" class="btn btn-success btn-sm"><i class="fas fa-edit" aria-hidden="true"></i></button></a></td>
        <td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalSupp{{$artisant->id}}"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
        <td>{{$artisant->num}}</td>
        <td>{{$artisant->name}}{{" "}}{{$artisant->prenom}}</td>
        <td>{{$artisant->commune}}</td>
        <td>{{$artisant->district}}</td>
        <span hidden>{!!$i=1!!}</span>
        @foreach ($artisant->metiers as $metier)
          <td>{{$metier->name}}</td>
          <span hidden>{!!$i++!!}</span>
          @foreach ($metiers as $met)
              @if ($met->name == $metier->name)
                  <td>{{$met->filiere->name}}</td>
              @endif
          @endforeach
        @endforeach
        @if ($i == 2)
            <td>Rien</td>
            <td>Rien</td>
        @endif     
        <td>{{$artisant->numCarte}}</td>
        @include('composants.modalSupp', ['artisant'=>$artisant])
      </tr>
      @endforeach
    </tbody>
  </table>

</div>

<script>
  $(document).ready(function() {
    $('#example').DataTable(

    );
  } );
</script>