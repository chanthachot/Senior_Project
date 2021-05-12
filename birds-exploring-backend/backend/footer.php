</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>
<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>
<!-- SlimScroll -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"
    integrity="sha512-cJMgI2OtiquRH4L9u+WQW+mz828vmdp9ljOcm/vKTQ7+ydQUktrPVewlykMgozPP+NUBbHdeifE6iJ6UVjNw5Q=="
    crossorigin="anonymous"></script>
<!-- FastClick -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.js"
    integrity="sha512-CWIhArE41HBbJmCKNaI+oHPt8r94Gb+qGty6KUyfl4T8ODsqhoyIm2NjGzV7js1cbvqUfrminjCjxUPLh3Wn7A=="
    crossorigin="anonymous"></script>
<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Google Map API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY1H_JfpBIHCLLAI4fzI5ahTCHKo4N_B4"></script>
<!-- AdminLte -->
<script src="../dist/js/adminlte.min.js"></script>


<?php 
require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if($detect->isMobile()) {
    // จัดการ QR Code
    include('qrcode/point_script_mobile.php');
    include('qrcode/point_map_script_mobile.php');
    include('qrcode/bird_script_mobile.php');
    include('qrcode/bird_map_script_mobile.php');

    // จัดการพบนก 
    include('foundbird/foundbirdpublic_script_mobile.php');
    include('foundbird/foundbirdprivate_script_mobile.php');
    
}else{
    // จัดการ QR Code
    include('qrcode/point_script.php');
    include('qrcode/point_map_script.php'); 
    include('qrcode/bird_script.php');
    include('qrcode/bird_map_script.php');
    
    // จัดการพบนก 
    include('foundbird/foundbirdpublic_script.php');
    include('foundbird/foundbirdprivate_script.php');
}
?>

<!-- จัดการ QR Code -->
<?php include('qrcode/path_script.php'); ?>

<!-- จัดการผู้ดูแลระบบ -->
<?php include('admin/admin_script.php'); ?>

<!-- จัดการฐานข้อมูลนก -->
<?php include('birddb/bird_family_script.php'); ?>
<?php include('birddb/birds_script.php'); ?>

<!-- จัดการผู้ใช้ -->
<?php include('user/user_script.php'); ?>



<!-- page script -->
<script>
$(document).ready(function() {
    $('#example1').DataTable({
        stateSave: true,
        language: {
            "decimal": "",
            "emptyTable": "ไม่มีข้อมูลในตารางนี้",
            "info": "แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ",
            "infoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "แสดง _MENU_ รายการ",
            "loadingRecords": "กำลังโหลด...",
            "processing": "กำลังทำรายการ...",
            "search": "ค้นหา:",
            "zeroRecords": "ไม่มีข้อมูลที่ต้องการ",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            },
            "aria": {
                "sortAscending": ": เรียงจากน้อยไปมาก",
                "sortDescending": ": เรียงจากมากไปน้อย"
            }
        },
        "aaSorting": [
            [0, 'desc']
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });
});

$(document).ready(function() {
    $('.slider').bxSlider({
        auto: true,
        autoHover: true,
        autoDelay: 1000,
        controls: false,
        mode: 'fade'
    });
});

$(document).ready(function() {
    $('.modal').on("hidden.bs.modal", function(e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass(
                'modal-open'
            ); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });
});


// $(document).ready(function() {
//     $('.modal').on('hidden.bs.modal', function(e) {
//         location.reload()
//     })
// });
</script>
</body>

</html>