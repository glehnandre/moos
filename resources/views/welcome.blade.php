@extends('layouts.master')

@section('title', 'Bem-vindo')

@section('content')

<h2>Onde temos <span class="semi-bold">MOOS?</span></h2>

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
      var eventos = {!! $eventos !!};

      function initMap() {
        var myLatLng = {lat: -15.795884, lng: -47.884028};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: myLatLng
        });

        for (var i = 0; i < eventos.length; i++) {
          var image = '/assets/img/pointer_moos_red.png';
          var id = eventos[i].id;
          if(eventos[i].ativo) image = '/assets/img/pointer_moos_blue.png';
          new google.maps.Marker({
              position: {lat: parseFloat(eventos[i].latitude), lng: parseFloat(eventos[i].longitude)},
              map: map,
              title: eventos[i].nome + '('+eventos[i].data_evento+')',
              icon: image
           }).addListener('click', function() {window.open('/evento/'+id+'/transacoes',"_self");});
        }
      }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlCOo8peujVBQFKdveEAQ8-VJOookq4T8&libraries=places&callback=initMap&sensor=false" async defer>
</script>
@stop