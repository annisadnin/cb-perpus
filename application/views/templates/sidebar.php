<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PENJUALAN</div>
    </a>

    <!-- Divider -->

    <!-- <li class="nav-item">
        <a class="nav-link mt-3" href="">
            <i class="fas fa-fw fa-columns"></i>
            <span>Dashboard</span></a>
    </li> -->

    <hr class="sidebar-divider">
    <?php
    $role_id = $this->session->userdata('role_id');
    $querymenu = "SELECT user_menu.id, user_menu.menu, user_menu.icon FROM user_menu JOIN user_access_menu ON user_menu.id = user_access_menu.menu_id
    WHERE user_access_menu.role_id = $role_id ORDER BY user_access_menu.menu_id ASC ";
    $menu = $this->db->query($querymenu)->result_array();
    ?>
    <!-- Heading -->

    <!-- LOAPING  -->
    <?php foreach ($menu as $m) : ?>
        <?php
        $menuid = $m['id'];
        $qsubmenu = " SELECT * 
        FROM user_sub_menu 
        WHERE menu_id = $menuid
        AND is_active = 1";
        $submenu = $this->db->query($qsubmenu)->result_array();
        ?>
        <?php if ($title == $m['menu']) { ?>
            <li class="nav-item active">
            <?php } else { ?>
            <li class="nav-item ">
            <?php } ?>
            <?php if ($jummenu == 1) { ?>
                <span class="nav-link mt-3" href="<?= base_url(''); ?>">
                    <i class="fas fa-fw fa-columns"></i>
                    <span><?= $m['menu']; ?></span>
                <?php } else { ?>

                    <a class="nav-link collapsed" data-toggle="collapse" onclick="SetActiveDiv(this);" data-target="#menu-<?= $m['id']; ?>" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="<?= $m['icon']; ?>"></i>
                        <span><?= $m['menu']; ?></span>
                    </a>
                    <div id="menu-<?= $m['id']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <?php foreach ($submenu as $sm) : ?>
                                <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                                    <span><?= $sm['title']; ?></span></a>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
            </li>
            <hr class="sidebar-divider">
        <?php } ?>
    <?php endforeach; ?>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->