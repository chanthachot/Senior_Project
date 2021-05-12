<script>
// $(function() {
//     $("form[name='addPathForm']").validate({
//         rules: {
//             input_add_path_path_name: "required",
//         },
//         messages: {
//             input_add_path_path_name: "Please enter your firstname",
//         },
//         submitHandler: function(form) {
//             form.submit();
//         }
//     });
// });

$(document).on("click", "#btnEditPath", function() {
    var data_edit_path_path_id = $(this).data('data_edit_path_path_id');
    var data_edit_path_path_name = $(this).data('data_edit_path_path_name');
    $('#input_edit_path_path_id').val(data_edit_path_path_id);
    $('#input_edit_path_path_name').val(data_edit_path_path_name);
});

$(document).on("click", "#btnDeletePath", function() {
    var data_delete_path_path_id = $(this).data('data_delete_path_path_id');
    $('#input_delete_path_path_id').val(data_delete_path_path_id);
});



$('#btnConfirmAddPath').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmAddPath").disabled = true;

    $.ajax({
        url: "path_crud.php?act=add",
        method: "POST",
        data: $('#addPathForm').serialize(),
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

// $("#addPathForm").validate({
//     rules: {
//         input_add_path_path_name: "required"
//     },
//     messages: {
//         input_add_path_path_name: "กรุณากรอกชื่อเส้นทาง"
//     },
//     submitHandler: function(form) {
//         $.ajax({
//             url: "path_crud.php?act=add",
//             method: "POST",
//             data: $('#addPathForm').serialize(),
//             success: function(data) {
//                 swal('สำเร็จ!',
//                     'บันทึกรายการสำเร็จ',
//                     'success', {
//                         closeOnClickOutside: false,
//                         closeOnEsc: false,
//                         buttons: false,
//                         timer: 3000,
//                     });
//                 window.setTimeout(function() {
//                     location.reload()
//                 }, 1500);
//             }
//         });
//     }
// });


$('#btnConfirmEditPath').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmEditPath").disabled = true;
    $.ajax({
        url: "path_crud.php?act=update",
        method: "POST",
        cache: false,
        data: $('#editPathForm').serialize(),
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


$('#btnConfirmDeletePath').on("click", function(event) {
    event.preventDefault();
    document.getElementById("btnConfirmDeletePath").disabled = true;
    $.ajax({
        url: "path_crud.php?act=delete",
        method: "POST",
        cache: false,
        data: $('#deletePathForm').serialize(),
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