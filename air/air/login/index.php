<?php
    ob_start();
    session_start();
    if(empty($_SESSION['user']) && empty($_SESSION['pass'])) {
        echo "<script>window.location.replace('../index.php')</script>";
    }
    include '../assets/funch.php';
    $air = new klas_air;
    $koneksi = $air->koneksi();
    $dt_user=$air->dt_user($_SESSION['user']);
    $level = $dt_user[2];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>AquaPay</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../air.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">AquaPay</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success fa-spin"></i></div>
                                Dashboard
                            </a>
                            <?php
                            if($level == "admin") {
                            ?>
                                <a class="nav-link" href="index.php?p=user">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success fa-spin"></i></div>
                                    Manajement User
                                </a>
                                <a class="nav-link" href="index.php?p=pemakaian_warga">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success fa-spin"></i></div>
                                    Lihat Pemakaian Warga
                                </a>
                                <a class="nav-link" href="index.php?p=manajement_tarif">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success fa-spin"></i></div>
                                    Manajemen Tarif
                                </a>
                            <?php
                            } elseif($level=="bendahara") {
                                ?>
                                 <a class="nav-link" href="index.php?p=kelola_penggunaan">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success fa-spin"></i></div>
                                    Lihat Pemakaian Warga
                                </a>
                                <a class="nav-link" href="index.php?p=manajement_tarif">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success fa-spin"></i></div>
                                    Manajement Tarif
                                </a>
                                <?php
                            } elseif($level=="petugas") {
                                ?>
                                 <a class="nav-link" href="index.php?p=mencatat_meter_warga">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success fa-spin"></i></div>
                                    Mencatat Meter Warga
                                </a>
                                <?php
                            } elseif($level=="warga") {
                                ?>
                                 <a class="nav-link" href="index.php?p=lihat_pemakaian">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success fa-spin"></i></div>
                                    Pemakaian
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"><i class="fa-regular fa-user fa-flip text-warning"></i> Logged in as: <?php echo $dt_user[2] ?></div>
                        <?php echo $dt_user[0] . '(' . $dt_user[1] . ')'; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <?php
                        // echo $_SERVER['REQUEST_URI'];
                        // echo $_SERVER['REQUEST_URI'];
                        $e = explode("=", $_SERVER['REQUEST_URI']);
                        //echo "<BR>[0]: $e[0] --> [1]: $e[1]";
                        if(!empty($e[1])) {
                            if ($e[1]=="user" || $e[1] == "user_edit&user") {
                                $h1="Manajemen User";
                                $li="Menu untuk CRUD user";
                            }
                            elseif ($e[1]=="pemakaian_warga" || $e[1] == "meter_edit&no") {
                                $h1="Pemakaian warga";
                                $li="Menu untuk melihat pemakaian warga";
                            }
                            elseif ($e[1]=="kelola_penggunaan" || $e[1] == "meter_edit&no") {
                                $h1="Pemakaian warga";
                                $li="Menu untuk melihat pemakaian warga";
                            }
                            elseif ($e[1]=="manajement_tarif" || $e[1] == "tarif_edit&kd_tarif") {
                                $h1="Manajement Tarif";
                                $li="Menu untuk mengatur Tarif";
                            }
                            elseif ($e[1]=="mencatat_meter_warga" || $e[1] == "meter_edit&no") {
                                $h1="Pencatatan Meter Warga";
                                $li="Menu untuk Mencatat warga";
                            }
                            elseif ($e[1]=="lihat_pemakaian" || $e[1] == "meter_bayar&no" || $e[1] == "proses_bayar&no") {
                                $h1="Pemakaian";
                                $li="Menu untuk Melihat pemakaian";
                            }
                        } else {
                            $h1 = "Dashboard";
                            $li = "Dashboard";
                        }
                        ?>
                        <h1 class="mt-4"><?php echo $h1 ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo $li ?></li>
                        </ol>
                        <?php
                        if (!empty($e[1])) {
                            if ($e[1] == "user" || $e[1] == "user_edit&user") {
                                // tampilkan konten untuk user
                                include '../konten/manajement_user.php';
                            }
                            elseif ($e[1] == "pemakaian_warga" || $e[1] == "meter_edit&no") {
                                include '../konten/lihat_pemakaian_warga.php';
                            }
                            elseif ($e[1] == "kelola_penggunaan" || $e[1] == "meter_edit&no") {
                                include '../konten/lihat_pemakaian_bendahara.php';
                            }
                            elseif ($e[1] == "manajement_tarif" || $e[1] == "tarif_edit&kd_tarif") {
                                include '../konten/mengelola_pembayaran.php';
                            }
                            elseif ($e[1]=="mencatat_meter_warga" || $e[1] == "meter_edit&no") {
                                include '../konten/mencatat_meteran.php';
                            }
                            elseif ($e[1]=="lihat_pemakaian" || $e[1] == "meter_bayar&no") {
                                include '../konten/melihat_tagihan.php';
                            }
                        } else {
                            include '../konten/dasboard.php';
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
        <style>
            .datatable-selector {
                margin-left: 5px;
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-radius: 0.5rem;
                font-size: 16px;
                width: 70px;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <!-- <script src="../assets/demo/chart-area-demo.js"></script> 
        <script src="../assets/demo/chart-bar-demo.js"></script>  -->
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../datatables-simple-demo.js"></script>
    </body>
</html>
