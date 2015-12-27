<!doctype html>
<html>
<head>
    <title>Dashboard Transjogja</title>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvyyijm6cgfQmrd5Sn-T8OltJdK4WkRQ8&callback=initMap"></script>
    <script type="text/javascript">
        function initMap(){
            var map;
            var directionDisplay = new google.maps.DirectionsRenderer();
            var directionService = new google.maps.DirectionsService();

            var mapOptions = {
                center: {lat:-7.767931, lng:110.374198}, //koordinat halte bus sebagai center of map
                zoom: 17
            };
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            directionDisplay.setMap(map);

            //titik awal dan titik akhir
            var origin = new google.maps.LatLng(-7.76780555555556, 110.37425); //panggil ajax posisi bus saat ini
            var destination = new google.maps.LatLng(-7.77427777777778, 110.375138888889); //posisi halte tujuan

            //buat deskripsi latitude longitude yang harus dilewati rute. Buat versi free maksimal 8 waypoints
            //optional, karena letak halte kebanyakan di jalan besar, jadi routing sudah sesuai
            /*var through1 = new google.maps.LatLng();
             var through2 = new google.maps.LatLng();
             var through3 = new google.maps.LatLng();*/

            //waypoints dijadikan satu array
            /*var wps = [{location: through1}, {location: through2}, {location:through3}];*/

            //parameter request yang dikirimkan ke google maps API
            var request = {
                origin: origin,
                destination: destination,
                //waypoint di print di request kalau dibutuhkan saja
                //waypoints: wps,
                travelMode: google.maps.TravelMode.DRIVING,
                drivingOptions: {
                    departureTime: new Date(/* now, or future date */),
                    trafficModel: google.maps.TrafficModel.BEST_GUESS
                }
            };

            //kirim request sekaligus handler result request
            directionService.route(request, function(result, status){
                if(status==google.maps.DirectionsStatus.OK){
                    directionDisplay.setDirections(result);
                    console.log(result);

                    var point = result.routes[ 0 ].legs[ 0];
                    console.log(point);
                }
                else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }


    </script>

    <style type="text/css">
        html, body { height: 100%; margin: 0; padding: 0; }
        #map { height: 100%; }
    </style>
    <?php
        echo Html::style('css/dashboard_home.css');
    ?>
</head>
<body>
    <div id="map" style="width: 25%;"></div>
    <div id="response_data">
        <h1>Waktu Kedatangan</h1>
        <p>3 menit</p>
    </div>
    <?php echo csrf_token(); ?>
</body>
</html>