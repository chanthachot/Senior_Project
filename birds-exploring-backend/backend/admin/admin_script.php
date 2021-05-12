<script>
$(function() {
    $("#showPassword").on("click", function() {
        var x = $("#input_edit_admin_password");
        if (x.attr('type') === "password") {
            x.attr('type', 'text');
            $(this).removeClass('fa fa-eye-slash')
            $(this).addClass('fa fa-eye')
        } else {
            x.attr('type', 'password');
            $(this).removeClass('fa fa-eye')
            $(this).addClass('fa fa-eye-slash')
        } // End of if
    }) // End of click event
});

$(document).on("click", "#btnEditAdmin", function() {
    var data_edit_admin_id = $(this).data('data_edit_admin_id');
    var data_edit_admin_username = $(this).data('data_edit_admin_username');
    var data_edit_admin_password = $(this).data('data_edit_admin_password');
    var data_edit_admin_type_id = $(this).data('data_edit_admin_type_id');
    var data_edit_admin_type_name = $(this).data('data_edit_admin_type_name');
    $('#input_edit_admin_id').val(data_edit_admin_id);
    $('#input_edit_admin_username').val(data_edit_admin_username);
    $('#input_edit_admin_password').val(data_edit_admin_password);
    $('#option_edit_admin_type_id').val(data_edit_admin_type_id);
    $('#option_edit_admin_type_id').text(data_edit_admin_type_name);

});

$(document).on("click", "#btnDeleteAdmin", function() {
    var data_delete_admin_id = $(this).data('data_delete_admin_id');
    $('#input_delete_admin_id').val(data_delete_admin_id);
});

$('#btnConfirmAddAdmin').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmAddAdmin").disabled = true;
    $.ajax({
        url: "admin_crud.php?act=add",
        method: "POST",
        data: $('#addAdminForm').serialize(),
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


$('#btnConfirmEditAdmin').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmEditAdmin").disabled = true;
    $.ajax({
        url: "admin_crud.php?act=update",
        method: "POST",
        cache: false,
        data: $('#editAdminForm').serialize(),
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


$('#btnConfirmDeleteAdmin').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmDeleteAdmin").disabled = true;
    $.ajax({
        url: "admin_crud.php?act=delete",
        method: "POST",
        cache: false,
        data: $('#deleteAdminForm').serialize(),
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