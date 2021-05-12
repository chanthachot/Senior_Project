<script>
//แสดงรูปที่จะเปลี่ยน
function previewEditBirdImage() {
    image_edit_bird.src = URL.createObjectURL(event.target.files[0]);
}

//รับค่า bird family dropdown 
function get_bird_family_text(element) {
    var textHolder = element.options[element.selectedIndex].text
    document.getElementById("bird_family_text").value = textHolder;
}

//jquery dropdown นก
$(function() {
    var birdFamilyObject = $('#bird_family_id');
    var birdObject = $('#bird_id');

    birdFamilyObject.on('change', function() {
        var birdFamilyId = $(this).val();

        birdObject.html('<option value="">เลือกนก</option>');

        $.get('bird_jquery.php?bird_family_id=' + birdFamilyId, function(data) {
            var result = JSON.parse(data);
            $.each(result, function(index, item) {
                birdObject.append(
                    $('<option></option>').val(item.bird_id).html(item.bird_name)
                );
            });
        });
    });

});


//ajax แสดงข้อมูลนกที่เลือก
function showBirdDetail(str) {
    if (str == "") {
        document.getElementById("bird_sciname").innerHTML = "";
        document.getElementById("bird_description").innerHTML = "";
        document.getElementById("bird_pic").innerHTML = "";
        return;
    }
    var xhr;
    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xhr = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("bird_sciname").innerHTML = xhr.responseText;
        }
    }
    xhr.open("GET", "bird_ajax.php?bird_id=" + str, true);
    xhr.send();
}


// crud script
$(document).on("click", "#btnEditBird", function() {
    var data_edit_bird_id = $(this).data('data_edit_bird_id');
    var data_edit_bird_name = $(this).data('data_edit_bird_name');
    var data_edit_bird_lat = $(this).data('data_edit_bird_lat');
    var data_edit_bird_lng = $(this).data('data_edit_bird_lng');
    var data_edit_bird_sciname = $(this).data('data_edit_bird_sciname');
    var data_edit_bird_description = $(this).data('data_edit_bird_description');
    var data_edit_bird_pic = $(this).data('data_edit_bird_pic');
    $('#input_edit_bird_id').val(data_edit_bird_id);
    $('#input_edit_bird_name').val(data_edit_bird_name);
    $('#input_edit_bird_lat').val(data_edit_bird_lat);
    $('#input_edit_bird_lng').val(data_edit_bird_lng);
    $('#input_edit_bird_sciname').val(data_edit_bird_sciname);
    $('#input_edit_bird_description').val(data_edit_bird_description);
    $('#image_edit_bird').attr("src", data_edit_bird_pic);


    x = navigator.geolocation;
    x.getCurrentPosition(success, failure);

    function success(position) {
        var map;
        var marker;

        var myLatlng = new google.maps.LatLng(data_edit_bird_lat, data_edit_bird_lng);

        $('#input_edit_bird_lat').val(data_edit_bird_lat);
        $('#input_edit_bird_lng').val(data_edit_bird_lng);


        var mapOptions = {
            zoom: 18,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        map = new google.maps.Map(document.getElementById("birdMapEdit"), mapOptions);

        google.maps.event.addListener(map, 'center_changed', function() {
            document.getElementById('input_edit_bird_lat').value = map.getCenter().lat();
            document.getElementById('input_edit_bird_lng').value = map.getCenter().lng();
        });

        $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
            .click(function() {
                var that = $(this);
                if (!that.data('win')) {
                    that.data('win').bindTo('position', map, 'center');
                }
                that.data('win').open(map);
            });
    }

    function failure() {}
    google.maps.event.addDomListener(window, 'load', initialize);
});

$(document).on("click", "#btnDeleteBird", function() {
    var data_delete_bird_id = $(this).data('data_delete_bird_id');
    $('#input_delete_bird_id').val(data_delete_bird_id);
});

$('#btnConfirmAddBird').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmAddBird").disabled = true;
    $.ajax({
        url: "bird_crud.php?act=add",
        method: "POST",
        data: $('#addBirdForm').serialize(),
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

$('#btnConfirmEditBird').on("click", function(event) {
    event.preventDefault();
    var form = $('#editBirdForm')[0];
    var data = new FormData(form);
    document.getElementById("btnConfirmEditBird").disabled = true;
    $.ajax({
        url: "bird_crud.php?act=update",
        enctype: 'multipart/form-data',
        method: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: data,
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

$('#btnConfirmDeleteBird').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmDeleteBird").disabled = true;
    $.ajax({
        url: "bird_crud.php?act=delete",
        method: "POST",
        cache: false,
        data: $('#deleteBirdForm').serialize(),
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