<?php
/*
Template Name: Single Column

*/
?>
<?php get_header(); ?>

<!-- CONTENT -->
<div id="wrapper_content">
  <div id="container_content" class="full_width">
  
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
var map;
var adjmi = new google.maps.LatLng(40.705160, -74.01175);

var MY_MAPTYPE_ID = 'custom_style';

function initialize() {

  //var featureOpts = [ { "featureType": "administrative.country", "stylers": [ { "visibility": "off" } ] },{ "featureType": "administrative.province", "stylers": [ { "visibility": "off" } ] },{ "featureType": "landscape.natural", "stylers": [ { "visibility": "on" }, { "color": "#d6d6d4" } ] },{ "featureType": "landscape.man_made", "elementType": "geometry", "stylers": [ { "color": "#e6e4e1" }, { "visibility": "off" } ] },{ "featureType": "poi", "stylers": [ { "visibility": "off" } ] },{ "featureType": "poi.park", "stylers": [ { "visibility": "on" }, { "color": "#9ca196" } ] },{ "featureType": "road", "elementType": "geometry.fill", "stylers": [ { "color": "#999999" }, { "visibility": "on" } ] },{ "featureType": "road", "elementType": "geometry.stroke", "stylers": [ { "color": "#ffffff" } ] },{ "featureType": "road", "elementType": "labels.text.fill", "stylers": [ { "weight": 0.9 }, { "color": "#000000" } ] },{ "featureType": "road", "elementType": "labels.text.stroke", "stylers": [ { "color": "#000000" }, { "visibility": "off" } ] },{ "featureType": "transit", "stylers": [ { "visibility": "off" } ] },{ "featureType": "administrative.neighborhood", "elementType": "labels.text.fill", "stylers": [ { "color": "#000000" } ] },{ "featureType": "administrative.neighborhood", "elementType": "labels.text.stroke", "stylers": [ { "color": "#ffffff" } ] },{ "featureType": "landscape.man_made", "elementType": "geometry.stroke", "stylers": [ { "visibility": "on" }, { "color": "#bab8bb" } ] },{ "featureType": "road.local", "elementType": "geometry.fill" },{ "featureType": "road.local", "elementType": "geometry.stroke", "stylers": [ { "weight": 1.2 } ] },{ "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "visibility": "on" }, { "color": "#000000" } ] } ];
  var featureOpts = [
  {
    "featureType": "poi",
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "road",
    "elementType": "labels.text.stroke",
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "landscape.man_made",
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "landscape.natural",
    "elementType": "geometry.fill",
    "stylers": [
      { "visibility": "on" },
      { "color": "#e6e6e6" }
    ]
  },{
    "featureType": "road",
    "elementType": "geometry.stroke",
    "stylers": [
      { "color": "#bebebe" }
    ]
  },{
    "featureType": "transit",
    "elementType": "labels.icon",
    "stylers": [
      { "visibility": "on" }
    ]
  },{
    "featureType": "transit",
    "elementType": "labels.text.fill",
    "stylers": [
      { "color": "#969696" }
    ]
  },{
    "featureType": "transit",
    "elementType": "labels.text.stroke",
    "stylers": [
      { "visibility": "on" }
    ]
  },{ 
    "featureType": "transit.station", 
    "elementType": "labels.icon", 
    "stylers": [ 
      { "saturation": -100 }, 
      { "gamma": 0.59 }
    ] 
  },
  {
    "featureType": "water",
    "elementType": "labels",
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "road.highway",
    "elementType": "geometry.fill",
    "stylers": [
      { "color": "#ffffff" }
    ]
  },{
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      { "color": "#bebebe" }
    ]
  }
];

  var mapOptions = {
    zoom: 16,
    center: adjmi,
    mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
    },
    mapTypeId: MY_MAPTYPE_ID
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
  
  var image = '<?php bloginfo('template_directory'); ?>/image/marker3.png';
  var ma_marker = new google.maps.LatLng(40.705160, -74.01175);
  var beachMarker = new google.maps.Marker({
      position: ma_marker,
      map: map,
      icon: image
  });

  
  
  var styledMapOptions = {
    name: 'Custom Style'
  };

  var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>

<div class="map_container seven_col">
<div id="map-canvas"></div>
</div>

<div class="single_column">

<?php the_content(); ?>
</div><!-- single_column -->
<?php endwhile; ?>
<?php endif; ?>

<div class="clear"></div>
  </div><!-- #container_content -->
</div><!-- wrapper_content -->

<?php get_footer(); ?>