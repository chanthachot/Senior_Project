<script>

$('.ViewFoundBirdPrivateModal').click(function() {

    // $('#ViewFoundBirdPublicModal').on('hidden.bs.modal', function(e) {
    //     location.reload()
    // })

    var data_view_foundbirdprivate_foundbird_id = $(this).data('data_view_foundbirdprivate_foundbird_id');
    var data_view_foundbirdprivate_bird_family_name = $(this).data(
        'data_view_foundbirdprivate_bird_family_name');
    var data_view_foundbirdprivate_bird_name = $(this).data('data_view_foundbirdprivate_bird_name');
    var data_view_foundbirdprivate_amount = $(this).data('data_view_foundbirdprivate_amount');
    var data_view_foundbirdprivate_lat = $(this).data('data_view_foundbirdprivate_lat');
    var data_view_foundbirdprivate_lng = $(this).data('data_view_foundbirdprivate_lng');
    var data_view_foundbirdprivate_date = $(this).data('data_view_foundbirdprivate_date');
    var data_view_foundbirdprivate_time = $(this).data('data_view_foundbirdprivate_time');
    var data_view_foundbirdprivate_timestamp = $(this).data('data_view_foundbirdprivate_timestamp');
    var data_view_foundbirdprivate_mouth_desc = $(this).data('data_view_foundbirdprivate_mouth_desc');
    var data_view_foundbirdprivate_body_desc = $(this).data('data_view_foundbirdprivate_body_desc');
    var data_view_foundbirdprivate_tail_desc = $(this).data('data_view_foundbirdprivate_tail_desc');
    var data_view_foundbirdprivate_wings_desc = $(this).data('data_view_foundbirdprivate_wings_desc');
    var data_view_foundbirdprivate_legs_desc = $(this).data('data_view_foundbirdprivate_legs_desc');
    var data_view_foundbirdprivate_other_desc = $(this).data('data_view_foundbirdprivate_other_desc');
    var data_view_foundbirdprivate_place = $(this).data('data_view_foundbirdprivate_place');
    var data_view_foundbirdprivate_first_name = $(this).data('data_view_foundbirdprivate_first_name');
    var data_view_foundbirdprivate_last_name = $(this).data('data_view_foundbirdprivate_last_name');
    $('#input_view_foundbirdprivate_foundbird_id').val(data_view_foundbirdprivate_foundbird_id);
    $('#input_view_foundbirdprivate_bird_family_name').val(data_view_foundbirdprivate_bird_family_name);
    $('#input_view_foundbirdprivate_bird_name').val(data_view_foundbirdprivate_bird_name);
    $('#input_view_foundbirdprivate_amount').val(data_view_foundbirdprivate_amount);
    $('#input_view_foundbirdprivate_lat').val(data_view_foundbirdprivate_lat);
    $('#input_view_foundbirdprivate_lng').val(data_view_foundbirdprivate_lng);
    $('#input_view_foundbirdprivate_date').val(data_view_foundbirdprivate_date);
    $('#input_view_foundbirdprivate_time').val(data_view_foundbirdprivate_time);
    $('#input_view_foundbirdprivate_timestamp').val(data_view_foundbirdprivate_timestamp);
    $('#input_view_foundbirdprivate_mouth').val(data_view_foundbirdprivate_mouth_desc);
    $('#input_view_foundbirdprivate_body').val(data_view_foundbirdprivate_body_desc);
    $('#input_view_foundbirdprivate_tail').val(data_view_foundbirdprivate_tail_desc);
    $('#input_view_foundbirdprivate_wings').val(data_view_foundbirdprivate_wings_desc);
    $('#input_view_foundbirdprivate_legs').val(data_view_foundbirdprivate_legs_desc);
    $('#input_view_foundbirdprivate_other').val(data_view_foundbirdprivate_other_desc);
    $('#input_view_foundbirdprivate_place').val(data_view_foundbirdprivate_place);
    $('#input_view_foundbirdprivate_first_name').val(data_view_foundbirdprivate_first_name);
    $('#input_view_foundbirdprivate_last_name').val(data_view_foundbirdprivate_last_name);

    load_image_data();

    function load_image_data() {
        $.ajax({
            url: "fetch_image_table.php?act=view_foundbird_private&foundbirdprivate_foundbird_id=" +
                data_view_foundbirdprivate_foundbird_id,
            method: "POST",
            success: function(data) {
                $('#image_table_view').html(data);
            }
        });
    }

    x = navigator.geolocation;
    x.getCurrentPosition(success, failure);

    function success(position) {

        var myLat = data_view_foundbirdprivate_lat;
        var myLong = data_view_foundbirdprivate_lng;
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

        map = new google.maps.Map(document.getElementById("foundbirdprivate_map_view"), mapOptions);

        marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            draggable: false
        });
    }

    function failure() {}
    google.maps.event.addDomListener(window, 'load', initialize);
});

$('.editFoundBirdPrivateModal').click(function() {
    
    $('#editFoundBirdPublicModal').on('hidden.bs.modal', function(e) {
        location.reload()
    })

    var data_edit_foundbirdprivate_foundbird_id = $(this).data('data_edit_foundbirdprivate_foundbird_id');
    var data_edit_foundbirdprivate_bird_family_name = $(this).data(
        'data_edit_foundbirdprivate_bird_family_name');
    var data_edit_foundbirdprivate_bird_name = $(this).data('data_edit_foundbirdprivate_bird_name');
    var data_edit_foundbirdprivate_amount = $(this).data('data_edit_foundbirdprivate_amount');
    var data_edit_foundbirdprivate_lat = $(this).data('data_edit_foundbirdprivate_lat');
    var data_edit_foundbirdprivate_lng = $(this).data('data_edit_foundbirdprivate_lng');
    var data_edit_foundbirdprivate_date = $(this).data('data_edit_foundbirdprivate_date');
    var data_edit_foundbirdprivate_time = $(this).data('data_edit_foundbirdprivate_time');
    var data_edit_foundbirdprivate_timestamp = $(this).data('data_edit_foundbirdprivate_timestamp');
    var data_edit_foundbirdprivate_mouth_desc = $(this).data('data_edit_foundbirdprivate_mouth_desc');
    var data_edit_foundbirdprivate_body_desc = $(this).data('data_edit_foundbirdprivate_body_desc');
    var data_edit_foundbirdprivate_tail_desc = $(this).data('data_edit_foundbirdprivate_tail_desc');
    var data_edit_foundbirdprivate_wings_desc = $(this).data('data_edit_foundbirdprivate_wings_desc');
    var data_edit_foundbirdprivate_legs_desc = $(this).data('data_edit_foundbirdprivate_legs_desc');
    var data_edit_foundbirdprivate_other_desc = $(this).data('data_edit_foundbirdprivate_other_desc');
    var data_edit_foundbirdprivate_place = $(this).data('data_edit_foundbirdprivate_place');
    var data_edit_foundbirdprivate_first_name = $(this).data('data_edit_foundbirdprivate_first_name');
    var data_edit_foundbirdprivate_last_name = $(this).data('data_edit_foundbirdprivate_last_name');
    $('#input_edit_foundbirdprivate_foundbird_id').val(data_edit_foundbirdprivate_foundbird_id);
    $('#input_edit_foundbirdprivate_bird_family_name').val(data_edit_foundbirdprivate_bird_family_name);
    $('#input_edit_foundbirdprivate_bird_name').val(data_edit_foundbirdprivate_bird_name);
    $('#input_edit_foundbirdprivate_amount').val(data_edit_foundbirdprivate_amount);
    $('#input_edit_foundbirdprivate_lat').val(data_edit_foundbirdprivate_lat);
    $('#input_edit_foundbirdprivate_lng').val(data_edit_foundbirdprivate_lng);
    $('#input_edit_foundbirdprivate_date').val(data_edit_foundbirdprivate_date);
    $('#input_edit_foundbirdprivate_time').val(data_edit_foundbirdprivate_time);
    $('#input_edit_foundbirdprivate_timestamp').val(data_edit_foundbirdprivate_timestamp);
    $('#input_edit_foundbirdprivate_mouth').val(data_edit_foundbirdprivate_mouth_desc);
    $('#input_edit_foundbirdprivate_body').val(data_edit_foundbirdprivate_body_desc);
    $('#input_edit_foundbirdprivate_tail').val(data_edit_foundbirdprivate_tail_desc);
    $('#input_edit_foundbirdprivate_wings').val(data_edit_foundbirdprivate_wings_desc);
    $('#input_edit_foundbirdprivate_legs').val(data_edit_foundbirdprivate_legs_desc);
    $('#input_edit_foundbirdprivate_other').val(data_edit_foundbirdprivate_other_desc);
    $('#input_edit_foundbirdprivate_place').val(data_edit_foundbirdprivate_place);
    $('#input_edit_foundbirdprivate_first_name').val(data_edit_foundbirdprivate_first_name);
    $('#input_edit_foundbirdprivate_last_name').val(data_edit_foundbirdprivate_last_name);

    load_image_data();

    function load_image_data() {
        $.ajax({
            url: "fetch_image_table.php?act=edit_foundbird_private&foundbirdprivate_foundbird_id=" +
                data_edit_foundbirdprivate_foundbird_id,
            method: "POST",
            success: function(data) {
                $('#image_table_edit').html(data);
            }
        });
    }

    $(document).on('click', '.oneDataTable', function() {
        Swal.fire({
            icon: 'error',
            title: 'ไม่สามารถลบรายการนี้ได้',
            text: 'ต้องมีอย่างน้อย 1 รูปเหลือไว้',
            confirmButtonText: 'ตกลง'
        })
    });

    $(document).on('click', '.deleteFoundBirdPicPrivateModal', function() {
        var foundbird_pic_id = $(this).attr("id");
        $('#input_delete_foundbirdprivate_foundbird_pic_id').val(foundbird_pic_id);
    });

    $(document).on('click', '.confirmDeleteFoundBirdPicPrivate', function() {
        $.ajax({
            url: "foundbirdprivate_crud.php?act=delete_foundbird_pic",
            method: "POST",
            cache: false,
            data: $('#deleteFoundBirdPicPrivateForm').serialize(),
            success: function(data) {
                $("#deleteFoundBirdPicPrivateModal").modal('hide');
                load_image_data();
            }
        });

    });

    var xp = 0;
    var input_btn4 = 0;
    var dts = [];

    $(document).on("click", ".imgbuts4", function(e) {
        input_btn4++;
        $("#editFoundBirdPrivateForm").append(
            "<input type='file' style='display:none;' name='upload_files[]' id='filenumber4" +
            input_btn4 +
            "' class='img_file upload_files4' accept='.gif,.jpg,.jpeg,.png,' multiple/>"
        );
        $("#filenumber4" + input_btn4).click();
    });

    $(document).on("change", ".upload_files4", function(e) {
        $('#error_msg4').html("");
        files = e.target.files;
        filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
            xp++;
            var f = files[i];
            var res_ext = files[i].name.split(".");
            var ext = res_ext.pop().toLowerCase();
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $('#error_msg4').html("<span class='text-danger'>รูปแบบไฟล์ไม่ถูกต้อง</span>");
            } else {
                var img_or_video = res_ext[res_ext.length - 1];
                var fileReader = new FileReader();
                fileReader.name = f.name;
                fileReader.onload = function(e) {
                    var file = e.target;
                    $("#message_box4").append(
                        "<article class='suggested-posts-article remove_artical" + xp +
                        "' data-file='" +
                        file
                        .name +
                        "'><div class='posts_article background_v" +
                        xp +
                        "' style='background-image: url(" +
                        e.target.result +
                        ")'></div><div class='p_run_div'><span class='pp_run progress_run" +
                        xp +
                        "' style='opacity: 1;'></span></div><p class='fa_p p_for_fa" +
                        xp +
                        "'><span class='cancel_mutile_image4 btnxc cancel_fa" +
                        xp +
                        "' deltsid='" + 0 +
                        "'>&#10006;</span><span class='btnxc btnxc_r' >&#10004;</span></p></article>"
                    );
                };
                fileReader.readAsDataURL(f);
            }
        }

    });

    var rty = 0;
    $(document).on("click", ".cancel_mutile_image4", function(e) {
        $('.cancel_mutile_image4').each(function() {
            chk_id = $(this).attr('deltsid');
            if (chk_id == 0) {
                rty++;
                $(this).attr('deltsid', rty);
            }
        });
        deltsid = $(this).attr('deltsid');
        dts.push(deltsid);
        $(this).parents(".suggested-posts-article").remove();
    });

    // $('#btnConfirmEditFoundBirdPrivate').on("click", function(event) {
    //     event.preventDefault();
    //     document.getElementById("btnConfirmEditFoundBirdPrivate").disabled = true;
    //     $.ajax({
    //         url: "foundbirdprivate_crud.php?act=update",
    //         method: "POST",
    //         cache: false,
    //         data: $('#editFoundBirdPrivateForm').serialize(),
    //         success: function(data) {
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: 'สำเร็จ!',
    //                 text: 'บันทึกรายการสำเร็จ',
    //                 showConfirmButton: false,
    //                 allowOutsideClick: false,
    //                 allowEscapeKey: false,
    //                 timer: 3000
    //             })
    //             window.setTimeout(function() {
    //                 location.reload()
    //             }, 1500);
    //         }
    //     });
    // });

    $('#btnConfirmEditFoundBirdPrivate').on("click", function(event) {
        event.preventDefault();
        suggested = $(".suggested-posts-article").length;
        document.getElementById("btnConfirmEditFoundBirdPrivate").disabled = false;
        if (suggested > 0) {
            var formData = new FormData(document.getElementById("editFoundBirdPrivateForm"));
            formData.append("dts", dts);
            $.ajax({
                url: "foundbirdprivate_crud.php?act=update_with_foundbird_pic",
                enctype: 'multipart/form-data',
                method: "POST",
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
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
        } else {
            var formData = new FormData(document.getElementById("editFoundBirdPrivateForm"));
            $.ajax({
                url: "foundbirdprivate_crud.php?act=update",
                enctype: 'multipart/form-data',
                method: "POST",
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
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
        }
    });

    x = navigator.geolocation;
    x.getCurrentPosition(success, failure);

    function success(position) {

        var myLat = data_edit_foundbirdprivate_lat;
        var myLong = data_edit_foundbirdprivate_lng;
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

        map = new google.maps.Map(document.getElementById("foundbirdprivate_map_edit"), mapOptions);

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
                    $('#input_edit_foundbirdprivate_lat,#input_edit_foundbirdprivate_lng').show();
                    $('#input_edit_foundbirdprivate_lat').val(marker.getPosition().lat());
                    $('#input_edit_foundbirdprivate_lng').val(marker.getPosition().lng());
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
                        $('#input_edit_foundbirdprivate_lat').val(marker.getPosition().lat());
                        $('#input_edit_foundbirdprivate_lng').val(marker.getPosition().lng());
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

$('.deleteFoundBirdPrivateModal').click(function() {
    var data_delete_foundbirdprivate_foundbird_id = $(this).data('data_delete_foundbirdprivate_foundbird_id');
    $('#input_delete_foundbirdprivate_foundbird_id').val(data_delete_foundbirdprivate_foundbird_id);

    $('#btnConfirmDeleteFoundBirdPrivate').on("click", function(event) {
        event.preventDefault();
        document.getElementById("btnConfirmDeleteFoundBirdPrivate").disabled = true;
        $.ajax({
            url: "foundbirdprivate_crud.php?act=delete",
            method: "POST",
            cache: false,
            data: $('#deleteFoundBirdPrivateForm').serialize(),
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
});
</script>