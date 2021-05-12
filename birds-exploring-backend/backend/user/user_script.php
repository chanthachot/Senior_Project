<script>
$(document).on("click", "#btnEditUser", function() {
    var data_edit_user_id = $(this).data('data_edit_user_id');
    var data_edit_user_firstname = $(this).data('data_edit_user_firstname');
    var data_edit_user_lastname = $(this).data('data_edit_user_lastname');
    var data_edit_user_email = $(this).data('data_edit_user_email');
    $('#input_edit_user_id').val(data_edit_user_id);
    $('#input_edit_user_firstname').val(data_edit_user_firstname);
    $('#input_edit_user_lastname').val(data_edit_user_lastname);
    $('#input_edit_user_email').val(data_edit_user_email);

});

$(document).on("click", "#btnDeleteUser", function() {
    var data_delete_user_id = $(this).data('data_delete_user_id');
    $('#input_delete_user_id').val(data_delete_user_id);
});

$('#btnConfirmEditUser').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmEditUser").disabled = true;
    $.ajax({
        url: "user_crud.php?act=update",
        method: "POST",
        cache: false,
        data: $('#editUserForm').serialize(),
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


$('#btnConfirmDeleteUser').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmDeleteUser").disabled = true;
    $.ajax({
        url: "user_crud.php?act=delete",
        method: "POST",
        cache: false,
        data: $('#deleteUserForm').serialize(),
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