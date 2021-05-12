<script>
x = navigator.geolocation;
x.getCurrentPosition(success, failure);

function success(position) {

    var myLat = position.coords.latitude;
    var myLong = position.coords.longitude;
    var map;
    var marker;
    var myLatlng = new google.maps.LatLng(myLat, myLong);
    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();

    var mapOptions = {
        zoom: 18,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(document.getElementById("pointMap"), mapOptions);

    marker = new google.maps.Marker({
        map: map,
        position: myLatlng,
        draggable: true
    });

    geocoder.geocode({
        'latLng': myLatlng
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                $('#input_add_point_point_lat,#input_add_point_point_lng').show();
                $('#input_add_point_point_lat').val(marker.getPosition().lat());
                $('#input_add_point_point_lng').val(marker.getPosition().lng());
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            }
        }
    });

    google.maps.event.addListener(marker, 'dragend', function() {

        geocoder.geocode({
            'latLng': marker.getPosition()
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#input_add_point_point_lat').val(marker.getPosition().lat());
                    $('#input_add_point_point_lng').val(marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
            }
        });
    });
}

function failure() {}


google.maps.event.addDomListener(window, 'load', initialize);
</script>