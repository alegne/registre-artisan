<div id="provinces"></div>
<div id="graph"></div>

<div class="row">
    <div class="col-lg-4" style="margin-top: 20px;">
      <h4><em>Répartition géographiquement</em></h4>
        {!! $chartjs->render() !!}
    </div>
    <div class="col-lg-4 table-responsive" style="margin-top: 20px;">
      <h4><em>Répartition par Filière</em></h4>
      <table id="dt-cell-sellection" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Filieres</th>
            <th>Effectif</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($dataFiliere as $key=>$item)
              @if ($item != '0')
              <tr>
                <td>{{$key}}</td>
                <td>{{$item}}</td>
              </tr>
              @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="col-lg-4 table-responsive" style="margin-top: 20px;">
      <h4><em>Répartition selon l'année</em></h4>
      <table id="dt-cell-sellection1" class="table table-hover" cellspacing="0" width="100%">
          <thead class="">
            <tr>
              <th scope="col">Année</th>
              <th scope="col">Nouveau</th>
              <th scope="col">Total</th>
              <th scope="col">Taux</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($dataArtisant as $key=>$data)
            <tr>
              <td>{{$key}}</td>
              <td>{{$data}}</td>
              <td><span hidden>{{$total = (int)$data}}{{$time = (int)$key}}</span>
                    @foreach ($dataArtisant as $cle=>$value) 
                      @if ((int)$cle < $time) 
                        <span hidden>{{$total += (int)$value}}</span>
                      @endif
                    @endforeach
                    {{$total}}
                </td>
              <td>{{number_format($data/$nb*100, 2)}}%</td>
            </tr>
            @endforeach
          </tbody>
        </table>
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

  $(document).ready(function () {
    $('#dt-cell-sellection1').dataTable({

      select: {
        style: 'os',
        items: 'cell'
      }
    });
  });
</script>