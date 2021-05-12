<script>
function previewAddBirdFamilyImage() {
    image_add_bird_family.src = URL.createObjectURL(event.target.files[0]);
}

function previewEditBirdFamilyImage() {
    image_edit_bird_family.src = URL.createObjectURL(event.target.files[0]);
}
$(document).on("click", "#btnEditBirdFamily", function() {
    var data_edit_bird_family_bird_family_id = $(this).data('data_edit_bird_family_bird_family_id');
    var data_edit_bird_family_bird_family_name = $(this).data('data_edit_bird_family_bird_family_name');
    var data_edit_bird_family_bird_family_pic = $(this).data('data_edit_bird_family_bird_family_pic');
    $('#input_edit_bird_family_bird_family_id').val(data_edit_bird_family_bird_family_id);
    $('#input_edit_bird_family_bird_family_name').val(data_edit_bird_family_bird_family_name);
    $('#image_edit_bird_family').attr("src", data_edit_bird_family_bird_family_pic);
});

$(document).on("click", "#btnDeleteBirdFamily", function() {
    var data_delete_bird_family_bird_family_id = $(this).data('data_delete_bird_family_bird_family_id');
    $('#input_delete_bird_family_bird_family_id').val(data_delete_bird_family_bird_family_id);
});

$('#btnConfirmAddBirdFamily').on("click", function(event) {
    event.preventDefault();
    var form = $('#addBirdFamilyForm')[0];
    var data = new FormData(form);
    document.getElementById("btnConfirmAddBirdFamily").disabled = false;
    if ($('#input_add_bird_family_bird_family_pic').get(0).files.length === 0) {
        $('#error_msg').html(
            "<span class='text-danger'>กรุณาเลือกอย่างน้อย 1 รูป</span>");

        $(document).on("change", "#input_add_bird_family_bird_family_pic", function(e) {
            $('#error_msg').html("");
        });
    } else {
        $.ajax({
            url: "bird_family_crud.php?act=add",
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
    }
});


$('#btnConfirmEditBirdFamily').on("click", function(event) {
    event.preventDefault();
    var form = $('#editBirdFamilyForm')[0];
    var data = new FormData(form);
    document.getElementById("btnConfirmEditBirdFamily").disabled = true;
    $.ajax({
        url: "bird_family_crud.php?act=update",
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


$('#btnConfirmDeleteBirdFamily').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmDeleteBirdFamily").disabled = true;
    $.ajax({
        url: "bird_family_crud.php?act=delete",
        method: "POST",
        cache: false,
        data: $('#deleteBirdFamilyForm').serialize(),
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