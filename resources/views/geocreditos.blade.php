@extends('layouts.master')

@section('title', 'Bem-vindo')

@section('content')

<h2>Geolocalização <span class="semi-bold">Créditos</span></h2>

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

      

      function initMap() {
        var myLatLng = {lat: -15.795884, lng: -47.884028};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: myLatLng
        });

      
      }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlCOo8peujVBQFKdveEAQ8-VJOookq4T8&libraries=places&callback=initMap&sensor=false" async defer>
</script>
@stop