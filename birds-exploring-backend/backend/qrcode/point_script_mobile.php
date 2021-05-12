<script>
$(document).on('click', '.duplicate', function() {
    Swal.fire({
        title: 'รายการนี้มีคิวอาร์โค้ดอยู่แล้ว',
        text: "คุณแน่ใจหรือไม่ว่าต้องการสร้างอันใหม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ใช่',
        confirmButtonColor: '#3085d6',
        cancelButtonText: 'ไม่',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            var data_point_id = $(this).data("data_point_id");
            var data_point_name = $(this).data("data_point_name");
            var data_point_lat = $(this).data("data_point_lat");
            var data_point_lng = $(this).data("data_point_lng");
            window.open('qrcodelib/index.php?point_id=' + data_point_id + '&point_name=' +
                data_point_name +
                '&point_lat=' + data_point_lat + '&point_lng=' + data_point_lng, '_blank');
        }
    })
});

$(document).on('click', '.not_exist', function() {
    Swal.fire({
        icon: 'error',
        title: 'ไม่สามารถสร้างคิวอาร์โค้ดได้',
        text: 'ต้องมีนกอย่างน้อย 1 ตัว อยู่ในจุดนี้',
        confirmButtonText: 'ตกลง'
    })
});

$('#btnConfirmAddPoint').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmAddPoint").disabled = true;
    $.ajax({
        url: "point_crud.php?act=add",
        method: "POST",
        data: $('#addPointForm').serialize(),
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'บันทึกรายการสำเร็จ',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 3000
            })
            window.setTimeout(function() {
                location.reload()
            }, 1500);
        }
    });
});



$('.editPointModal').click(function() {
    var data_edit_point_point_id = $(this).data('data_edit_point_point_id');
    var data_edit_point_point_name = $(this).data('data_edit_point_point_name');
    var data_edit_point_point_address = $(this).data('data_edit_point_point_address');
    var data_edit_point_point_lat = $(this).data('data_edit_point_point_lat');
    var data_edit_point_point_lng = $(this).data('data_edit_point_point_lng');
    $('#input_edit_point_point_id').val(data_edit_point_point_id);
    $('#input_edit_point_point_name').val(data_edit_point_point_name);
    $('#input_edit_point_point_address').val(data_edit_point_point_address);
    $('#input_edit_point_point_lat').val(data_edit_point_point_lat);
    $('#input_edit_point_point_lng').val(data_edit_point_point_lng);

    load_image_data();

    function load_image_data() {
        $.ajax({
            url: "fetch_image_table.php?point_id=" + data_edit_point_point_id,
            method: "POST",
            success: function(data) {
                $('#image_qrcode_table').html(data);
            }
        });
    }

    $(document).on('click', '.deleteQRCodeModal', function() {
        var qrcode_id = $(this).attr("id");
        var qrcode_image = $(this).data("data_qrcode_image");
        $('#input_delete_qrcode_id').val(qrcode_id);
        $('#input_delete_qrcode_image').val(qrcode_image);
    });

    $(document).on('click', '.confirmDeleteQRCode', function() {
        $.ajax({
            url: "point_crud.php?act=delete_qrcode",
            method: "POST",
            cache: false,
            data: $('#deleteQRCodeForm').serialize(),
            success: function(data) {
                $("#deleteQRCodeModal").modal('hide');
                load_image_data();
            }
        });

    });

    $('#btnConfirmEditPoint').on("click", function(event) {
        event.preventDefault();
        document.getElementById("btnConfirmEditPoint").disabled = true;
        $.ajax({
            url: "point_crud.php?act=update&point_id=<?= $row['point_id'] ?>",
            method: "POST",
            cache: false,
            data: $('#editPointForm').serialize(),
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'บันทึกรายการสำเร็จ',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 3000
                })
                window.setTimeout(function() {
                    location.reload()
                }, 1500);
            }
        });
    });

    x = navigator.geolocation;
    x.getCurrentPosition(success, failure);

    function success(position) {

        var myLat = data_edit_point_point_lat;
        var myLong = data_edit_point_point_lng;
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

        map = new google.maps.Map(document.getElementById("pointMapEdit"), mapOptions);

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
                    $('#input_edit_point_point_lat,#input_edit_point_point_lng').show();
                    $('#input_edit_point_point_lat').val(marker.getPosition().lat());
                    $('#input_edit_point_point_lng').val(marker.getPosition().lng());
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
                        $('#input_edit_point_point_lat').val(marker.getPosition().lat());
                        $('#input_edit_point_point_lng').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    }
                }
            });
        });
    }

    function failure() {}


    google.maps.event.addDomListener(window, 'load', initialize);
});



$(document).on("click", "#btnDeletePoint", function() {
    var data_delete_point_point_id = $(this).data('data_delete_point_point_id');
    $('#input_delete_point_point_id').val(data_delete_point_point_id);
});


$('#btnConfirmDeletePoint').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmDeletePoint").disabled = true;
    $.ajax({
        url: "point_crud.php?act=delete",
        method: "POST",
        cache: false,
        data: $('#deletePointForm').serialize(),
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'บันทึกรายการสำเร็จ',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 3000
            })
            window.setTimeout(function() {
                location.reload()
            }, 1500);
        }
    });
});
</script>