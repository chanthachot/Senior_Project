<script>

$('.addBirdsModal').click(function() {

    $('#addBirdsModal').on('hidden.bs.modal', function(e) {
        location.reload()
    })

    var xp = 0;
    var input_btn = 0;
    var dts = [];

    $(document).on("click", ".imgbuts", function(e) {
        input_btn++;
        $("#addBirdForm").append(
            "<input type='file' style='display:none;' name='upload_files[]' id='filenumber" +
            input_btn +
            "' class='img_file upload_files' accept='.gif,.jpg,.jpeg,.png,' multiple/>"
        );
        $("#filenumber" + input_btn).click();
    });

    $(document).on("change", ".upload_files", function(e) {
        $('#error_msg').html("");
        files = e.target.files;
        filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
            xp++;
            var f = files[i];
            var res_ext = files[i].name.split(".");
            var ext = res_ext.pop().toLowerCase();
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $('#error_msg').html("<span class='text-danger'>รูปแบบไฟล์ไม่ถูกต้อง</span>");
            } else {
                var img_or_video = res_ext[res_ext.length - 1];
                var fileReader = new FileReader();
                fileReader.name = f.name;
                fileReader.onload = function(e) {
                    var file = e.target;
                    $("#message_box").append(
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
                        "'><span class='cancel_mutile_image btnxc cancel_fa" +
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
    $(document).on("click", ".cancel_mutile_image", function(e) {
        $('.cancel_mutile_image').each(function() {
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

    $('#btnConfirmAddBird').on("click", function(event) {
        event.preventDefault();
        suggested = $(".suggested-posts-article").length;
        document.getElementById("btnConfirmAddBird").disabled = false;
        if (suggested > 0) {
            var formData = new FormData(document.getElementById("addBirdForm"));
            formData.append("dts", dts);
            $.ajax({
                url: "birds_crud.php?act=add_bird&bird_family_id=<?= $_REQUEST['bird_family_id'] ?>",
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
            $('#error_msg').html(
                "<span class='text-danger'>กรุณาเลือกอย่างน้อย 1 รูป</span>");
        }
    });
});


$('.editBirdsModal').click(function() {
    
    $('#editBirdsModal').on('hidden.bs.modal', function(e) {
        location.reload()
    })
    
    var data_edit_bird_bird_id = $(this).data('data_edit_bird_bird_id');
    var data_edit_bird_bird_name = $(this).data('data_edit_bird_bird_name');
    var data_edit_bird_bird_commonname = $(this).data('data_edit_bird_bird_commonname');
    var data_edit_bird_bird_sciname = $(this).data('data_edit_bird_bird_sciname');
    var data_edit_bird_bird_description = $(this).data('data_edit_bird_bird_description');
    var data_edit_bird_bird_habitat = $(this).data('data_edit_bird_bird_habitat');
    $('#input_edit_bird_bird_id').val(data_edit_bird_bird_id);
    $('#input_edit_bird_bird_name').val(data_edit_bird_bird_name);
    $('#input_edit_bird_bird_commonname').val(data_edit_bird_bird_commonname);
    $('#input_edit_bird_bird_sciname').val(data_edit_bird_bird_sciname);
    $('#input_edit_bird_bird_description').val(data_edit_bird_bird_description);
    $('#input_edit_bird_bird_habitat').val(data_edit_bird_bird_habitat);

    load_image_data();

    function load_image_data() {
        $.ajax({
            url: "fetch_image_table.php?bird_id=" + data_edit_bird_bird_id,
            method: "POST",
            success: function(data) {
                $('#image_table').html(data);
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

    $(document).on('click', '.deleteBirdPicModal', function() {
        var bird_pic_id = $(this).attr("id");
        var bird_pic_name = $(this).data("data_bird_pic_name");
        $('#input_delete_bird_pic_id').val(bird_pic_id);
        $('#input_delete_bird_pic_name').val(bird_pic_name);
    });

    $(document).on('click', '.confirmDeleteBirdPic', function() {
        $.ajax({
            url: "birds_crud.php?act=delete_bird_pic",
            method: "POST",
            cache: false,
            data: $('#deleteBirdPicForm').serialize(),
            success: function(data) {
                $("#deleteBirdPicModal").modal('hide');
                load_image_data();
            }
        });

    });

    var xp = 0;
    var input_btn2 = 0;
    var dts = [];

    $(document).on("click", ".imgbuts2", function(e) {
        input_btn2++;
        $("#editBirdForm").append(
            "<input type='file' style='display:none;' name='upload_files[]' id='filenumber2" +
            input_btn2 +
            "' class='img_file upload_files2' accept='.gif,.jpg,.jpeg,.png,' multiple/>"
        );
        $("#filenumber2" + input_btn2).click();
    });

    $(document).on("change", ".upload_files2", function(e) {
        $('#error_msg2').html("");
        files = e.target.files;
        filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
            xp++;
            var f = files[i];
            var res_ext = files[i].name.split(".");
            var ext = res_ext.pop().toLowerCase();
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $('#error_msg2').html("<span class='text-danger'>รูปแบบไฟล์ไม่ถูกต้อง</span>");
            } else {
                var img_or_video = res_ext[res_ext.length - 1];
                var fileReader = new FileReader();
                fileReader.name = f.name;
                fileReader.onload = function(e) {
                    var file = e.target;
                    $("#message_box2").append(
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
                        "'><span class='cancel_mutile_image2 btnxc cancel_fa" +
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
    $(document).on("click", ".cancel_mutile_image2", function(e) {
        $('.cancel_mutile_image2').each(function() {
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


    $('#btnConfirmEditBird').on("click", function(event) {
        event.preventDefault();
        suggested = $(".suggested-posts-article").length;
        document.getElementById("btnConfirmEditBird").disabled = false;
        if (suggested > 0) {
            var formData = new FormData(document.getElementById("editBirdForm"));
            formData.append("dts", dts);
            $.ajax({
                url: "birds_crud.php?act=update_with_bird_pic",
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
            var formData = new FormData(document.getElementById("editBirdForm"));
            $.ajax({
                url: "birds_crud.php?act=update",
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
});


$('.deleteBirdModal').click(function() {
    var data_delete_bird_bird_id = $(this).data('data_delete_bird_bird_id');
    $('#input_delete_bird_bird_id').val(data_delete_bird_bird_id);

    $('#btnConfirmDeleteBird').on("click", function(event) {
        event.preventDefault();
        document.getElementById("btnConfirmDeleteBird").disabled = true;
        $.ajax({
            url: "birds_crud.php?act=delete",
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
});
</script>