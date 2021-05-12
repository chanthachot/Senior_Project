<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../index.php" class="brand-link">
        <img src="../../dist/img/macaw.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Birds Exploring</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../dist/img/profile.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class=" info">
                <a href="#" class="d-block"><?= $_SESSION["USERNAME"] ?></a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="../qrcode/path.php" class="nav-link <?php if ($page == 'path') {
                                                          echo 'active';
                                                        } ?>">
                        <i class="nav-icon fa fa-qrcode"></i>
                        <p>
                            จัดการคิวอาร์โค้ด
                        </p>
                    </a>
                </li>
                <li class="nav-item <?php if ($page == 'foundbirdpublic' || $page == 'foundbirdprivate') {
                              echo 'menu-open';
                            } ?>">
                    <a href="../foundbird/foundbirdpublic.php" class="nav-link <?php if ($page == 'foundbirdpublic' || $page == 'foundbirdprivate') {
                                                                        echo 'active';
                                                                      } ?>">
                        <i class="nav-icon fa fa-search-location"></i>
                        <p>
                            จัดการพบนก
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../foundbird/foundbirdpublic.php" class="nav-link <?php if ($page == 'foundbirdpublic') {
                                                                            echo 'active';
                                                                          } ?>">
                                <i class="nav-icon fas fa-globe-americas"></i>
                                <p>สาธารณะ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../foundbird/foundbirdprivate.php" class="nav-link <?php if ($page == 'foundbirdprivate') {
                                                                            echo 'active';
                                                                          } ?>">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>ส่วนตัว</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="../birddb/bird_family.php" class="nav-link <?php if ($page == 'birddb') {
                                        echo 'active';
                                      } ?>">
                        <i class="nav-icon fas fa-dove"></i>
                        <p>
                            จัดการฐานข้อมูลนก
                        </p>
                    </a>
                </li>
                <?php
        if ($_SESSION["typeID"] == "1") {
        ?>
                <li class="nav-item <?php if ($page == 'admin') {
                                echo 'active';
                              } ?>">
                    <a href="../admin/admin.php" class="nav-link <?php if ($page == 'admin') {
                                                            echo 'active';
                                                          } ?>">
                        <i class="nav-icon fa fa-user-shield"></i>
                        <p>
                            จัดการผู้ดูแลระบบ
                        </p>
                    </a>
                </li>
                <?php
        } else {
        }
        ?>
                <li class="nav-item">
                    <a href="../user/user.php" class="nav-link <?php if ($page == 'user') {
                                        echo 'active';
                                      } ?>">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            จัดการผู้ใช้
                        </p>
                    </a>
                </li>
                <li class="nav-header">จัดการ</li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#logoutModal">
                        <i class="nav-icon fa fa-sign-out-alt text-danger"></i>
                        <p class="text">ออกจากระบบ</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<div id="logoutModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ออกจากระบบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h1 style="font-size:5.5rem;"><i class="fa fa-sign-out-alt text-danger" aria-hidden="true"></i></h1>
                <p>คุณแน่ใจหรือว่าต้องการออกจากระบบ ?</p>
            </div>
            <div class="modal-footer">
                <a href="../../logout.php" class="btn btn-danger">ออกจากระบบ</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>