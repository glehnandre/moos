@extends('layouts.master')

@section('title', 'Bem-vindo')

@section('content')

<h2>Geolocalização <span class="semi-bold">Vendas</span></h2>

<div id="map" style="height: 100%;"></div>


<!-- Fim geolocalizacao -->
@stop

@section('scripts')
<script>
      $(document).ready(function() {  
          $('#map').height($('.page-container').height()/1.3);
          $( window ).resize(function() {
             $('#map').height($('.page-container').height()/1.3);
          });  
      });

      var transacoes = [];
      transacoes = {!! $transacoes !!};

      function initMap() {
        var myLatLng = {lat: -15.795884, lng: -47.884028};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: myLatLng
        });

        for (var i = 0; i < transacoes.length; i++) {
          var image = '/assets/img/pointer_beer.png';
          console.log(transacoes[i]);
          var id = transacoes[i].id;
          if(transacoes[i].tipo_transacao == 'credito') image = '/assets/img/pointer_credito.png';
          new google.maps.Marker({
              position: {lat: parseFloat(transacoes[i].latitude), lng: parseFloat(transacoes[i].longitude)},
              map: map,
              title: 'Usuário: '+ transacoes[i].cpf + ' (Valor: R$ '+transacoes[i].valor+')',
              icon: image
           }).addListener('click', function() {window.open('/evento/'+id+'/transacoes',"_self");});
        }
      }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlCOo8peujVBQFKdveEAQ8-VJOookq4T8&libraries=places&callback=initMap&sensor=false" async defer>
</script>
@stop