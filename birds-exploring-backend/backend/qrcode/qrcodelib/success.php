<div id="createQRCodeSuccess">
    <div class="modal-content animate container">
        <?php
        ?>

        <img src="userQr/<?php echo $_GET['qrimage']; ?>" width=250; height=250; alt="">
        <?php
        $workDir = $_SERVER['HTTP_HOST'];
        $qrlink = $workDir . "/birds-exploring-backend/backend/qrcode/qrcodelib/userQr/" . $_GET['qrimage'];
        ?>


        <input type="text" value="<?php echo $qrlink; ?>" readonly>
        <br><br><br>
        <a href="<?php echo "userQr/" ?><?php echo $_GET['qrimage']; ?>">ดาวน์โหลด</a>
        <br><br>

    </div>
</div>