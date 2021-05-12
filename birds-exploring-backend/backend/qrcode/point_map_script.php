<script>
x = navigator.geolocation;
x.getCurrentPosition(success, failure);

function success(position) {

    var map;
    var marker;

    var myLat = position.coords.latitude;
    var myLong = position.coords.longitude;
    var myLatlng = new google.maps.LatLng(myLat, myLong);


    $('#input_add_point_point_lat').val(myLat);
    $('#input_add_point_point_lng').val(myLong);


    var mapOptions = {
        zoom: 18,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(document.getElementById("pointMap"), mapOptions);

    google.maps.event.addListener(map, 'center_changed', function() {
        document.getElementById('input_add_point_point_lat').value = map.getCenter().lat();
        document.getElementById('input_add_point_point_lng').value = map.getCenter().lng();

    });

    $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
        .click(function() {
            var that = $(this);
            if (!that.data('win')) {
                // that.data('win', new google.maps.InfoWindow({
                //     content: 'this is the center'
                // }));
                that.data('win').bindTo('position', map, 'center');
            }
            that.data('win').open(map);
        });
}

function failure() {}
google.maps.event.addDomListener(window, 'load', initialize);


</script>