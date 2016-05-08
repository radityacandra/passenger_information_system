<!doctype html>
<html>
<head>
  <title>Current Bus Location</title>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU&callback=initMap"></script>
  <script type="text/javascript">
    function initMap(){
      var centerLatLng = {lat:<?php echo $viewData['latitude']; ?>, lng:<?php echo $viewData['longitude']; ?>};

      var map = new google.maps.Map(document.getElementById('map'), {
        center: centerLatLng,
        scrollWheel: false,
        zoom: 16
      });

      var positionBus = {lat:<?php echo $viewData['latitude']; ?>, lng:<?php echo $viewData['longitude']; ?>};
      var bus = new google.maps.Marker({
        map: map,
        position: positionBus,
        title: "<?php echo $viewData['plat_nomor']; ?>"
      });
    }
  </script>
</head>
<body>
<div id="map" style="height: 500px"></div>
</body>
</html>