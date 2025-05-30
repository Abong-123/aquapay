<?php
session_start();
include '../assets/funch.php';
$air = new klas_air;
$koneksi = $air->koneksi();
$dt_user=$air->dt_user($_SESSION['user']);
$level = $dt_user[2];
if($level == "admin") {
    if (isset($_POST['p'])) {
        $p=$_POST['p'];
    
        if ($p=="summary") {
            $bln = $_POST['t'];
            $sql1 = mysqli_query($koneksi, "SELECT COUNT(username) as jml_pelanggan FROM akun WHERE level='warga'");
            $d1 = mysqli_fetch_assoc($sql1);
            $data[] = array('jml_pelanggan' => $d1['jml_pelanggan']);
    
            $sql2 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as jml_pemakaian FROM pemakaian WHERE tgl LIKE '$bln%'");
            $d2 = mysqli_fetch_assoc($sql2);
            $data[] = array('pemakaian' => $d2['jml_pemakaian']);
    
            $sql3 = mysqli_query($koneksi, "SELECT COUNT(username) as sdh_dicatat FROM pemakaian WHERE tgl LIKE '$bln%'");
            $d3 = mysqli_fetch_assoc($sql3);
            $data[] = array('tercatat' => $d3['sdh_dicatat']);

            $sql4 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as total_pemakaian FROM pemakaian");
            $d4 = mysqli_fetch_assoc($sql4);
            $data[] = array('total_pemakaian' => $d4['total_pemakaian']);

            $sql5 = mysqli_query($koneksi, "SELECT SUM(tagihan) as total_tagihan FROM pemakaian");
            $d5 = mysqli_fetch_assoc($sql5);
            $data[] = array('total_tagihan' => $d5['total_tagihan']);

            $sql6 = mysqli_query($koneksi, "SELECT SUM(tagihan) as sdh_lunass FROM pemakaian WHERE status='LUNAS'");
            $d6 = mysqli_fetch_assoc($sql6);
            $data[] = array('sdh_lunass' => $d6['sdh_lunass']);
            echo json_encode($data);

        } elseif ($_POST['p'] == "chart_line1") {
            // $user = $_SESSION['user'] ?? 'guest';
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, SUM(pemakaian) as total_pemakaian FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['total_pemakaian'];
            }
            echo json_encode($respon);

        } elseif ($_POST['p'] == "chart_pie") {
            $q = mysqli_query($koneksi, "SELECT tipe, COUNT(*) as jumlah FROM akun WHERE tipe IN ('RT', 'kost') GROUP BY tipe");
            $respon = [];
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = ['tipe' => $d['tipe'], 'jumlah' => (int)$d['jumlah']];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_line2") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, SUM(tagihan) as total_tagihan FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['total_tagihan'];
            }
            echo json_encode($respon);

        } elseif ($_POST['p'] == "chart_line3") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, SUM(tagihan) as total_lunas FROM pemakaian WHERE status = 'LUNAS' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['total_lunas'];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(DISTINCT username) as sdh_dicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['sdh_dicatat'];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar2") {
            $user = $_POST['y'];
            $total_warga_query = mysqli_query($koneksi, "SELECT COUNT(DISTINCT username) as total_warga FROM akun WHERE level = 'warga'");
            $row_total = mysqli_fetch_assoc($total_warga_query);
            $total_warga = (int)$row_total['total_warga'];

            // Sudah mencatat per bulan
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(DISTINCT username) as sdh_dicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            $respon = [];
            while ($d = mysqli_fetch_assoc($q)) {
                $bln = (int)$d['bln'];
                $sdh = (int)$d['sdh_dicatat'];
                $blm = $total_warga - $sdh;
        
                $respon[] = $air->bln($bln);
                $respon[] = strval(max($blm, 0)); 
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar3") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(username) as sdh_lunas FROM pemakaian WHERE status = 'LUNAS' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['sdh_lunas'];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar4") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(username) as sdh_lunas FROM pemakaian WHERE status = 'BLM LUNAS' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['sdh_lunas'];
            }
            echo json_encode($respon);
        }
    }
}elseif($level == "petugas") {
    if (isset($_POST['p'])) {
        $p=$_POST['p'];
    
        if ($p=="summary") {
            $bln = $_POST['t'];
            $sql1 = mysqli_query($koneksi, "SELECT COUNT(username) as jml_pelanggan FROM akun WHERE level='warga'");
            $d1 = mysqli_fetch_assoc($sql1);
            $data[] = array('jml_pelanggan' => $d1['jml_pelanggan']);
    
            $sql2 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as jml_pemakaian FROM pemakaian WHERE tgl LIKE '$bln%'");
            $d2 = mysqli_fetch_assoc($sql2);
            $data[] = array('pemakaian' => $d2['jml_pemakaian']);
    
            $sql3 = mysqli_query($koneksi, "SELECT COUNT(username) as sdh_dicatat FROM pemakaian WHERE tgl LIKE '$bln%'");
            $d3 = mysqli_fetch_assoc($sql3);
            $data[] = array('tercatat' => $d3['sdh_dicatat']);

            $sql4 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as total_pemakaian FROM pemakaian");
            $d4 = mysqli_fetch_assoc($sql4);
            $data[] = array('total_pemakaian' => $d4['total_pemakaian']);

            echo json_encode($data);
        } elseif ($_POST['p'] == "chart_line1") {
            // $user = $_SESSION['user'] ?? 'guest';
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, SUM(pemakaian) as total_pemakaian FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['total_pemakaian'];
            }
            echo json_encode($respon);

        } elseif ($_POST['p'] == "chart_pie") {
            $q = mysqli_query($koneksi, "SELECT tipe, COUNT(*) as jumlah FROM akun WHERE tipe IN ('RT', 'kost') GROUP BY tipe");
            $respon = [];
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = ['tipe' => $d['tipe'], 'jumlah' => (int)$d['jumlah']];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(DISTINCT username) as sdh_dicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['sdh_dicatat'];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar2") {
            $user = $_POST['y'];
            $total_warga_query = mysqli_query($koneksi, "SELECT COUNT(DISTINCT username) as total_warga FROM akun WHERE level = 'warga'");
            $row_total = mysqli_fetch_assoc($total_warga_query);
            $total_warga = (int)$row_total['total_warga'];

            // Sudah mencatat per bulan
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(DISTINCT username) as sdh_dicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            $respon = [];
            while ($d = mysqli_fetch_assoc($q)) {
                $bln = (int)$d['bln'];
                $sdh = (int)$d['sdh_dicatat'];
                $blm = $total_warga - $sdh;
        
                $respon[] = $air->bln($bln);
                $respon[] = strval(max($blm, 0)); 
            }
            echo json_encode($respon);
        } 
    }
}elseif($level == "warga") {
    if (isset($_POST['p'])) {
        $p=$_POST['p'];
        if ($p=="summary") {
            $bln = $_POST['t'];
            $user = $_SESSION['user'];
            $data = [];
            $sql1 = mysqli_query($koneksi, "SELECT waktu as jml_waktu FROM pemakaian WHERE username='$user' AND tgl LIKE '$bln%'");
            $d1 = mysqli_fetch_assoc($sql1);
            $data[] = ['waktu' => $d1['jml_waktu'] ?? 0];
    
            $sql2 = mysqli_query($koneksi, "SELECT pemakaian as jml_pemakaian FROM pemakaian WHERE username='$user' AND tgl LIKE '$bln%'");
            $d2 = mysqli_fetch_assoc($sql2);
            $data[] = ['pemakaian' => $d2['jml_pemakaian'] ?? 0];
    
            $sql3 = mysqli_query($koneksi, "SELECT tagihan as sdh_bayar FROM pemakaian WHERE username='$user' AND tgl LIKE '$bln%'");
            $d3 = mysqli_fetch_assoc($sql3);
            $data[] = ['bayar' => $d3['sdh_bayar'] ?? 0];
    
            $sql4 = mysqli_query($koneksi, "SELECT status as sdh_status FROM pemakaian WHERE username='$user' AND tgl LIKE '$bln%'");
            $d4 = mysqli_fetch_assoc($sql4);
            $data[] = ['status' => $d4['sdh_status'] ?? ''];
    
            $sql5 = mysqli_query($koneksi, "SELECT tgl as jml_tgl FROM pemakaian WHERE username='$user' AND tgl LIKE '$bln%'");
            $d5 = mysqli_fetch_assoc($sql5);
            $hanya_tanggal = isset($d5['jml_tgl']) ? substr($d5['jml_tgl'], -2) : 0;
            $data[] = ['tgl' => $hanya_tanggal];
    
            $sql6 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as total FROM pemakaian WHERE username='$user'");
            $d6 = mysqli_fetch_assoc($sql6);
            $data[] = ['total' => $d6['total'] ?? 0];

            $sql7 = mysqli_query($koneksi, "SELECT SUM(tagihan) as totalan FROM pemakaian WHERE username='$user'");
            $d7 = mysqli_fetch_assoc($sql7);
            $data[] = ['totalan' => $d7['totalan'] ?? 0];

            $sql8 = mysqli_query($koneksi, "SELECT SUM(tagihan) as total_blm_lunas FROM pemakaian WHERE username='$user' AND status = 'BLM LUNAS'");
            $d8 = mysqli_fetch_assoc($sql8);
            $data[] = ['total_blm_lunas' => $d8['total_blm_lunas'] ?? 0];

            echo json_encode($data);
    
        } elseif ($_POST['p'] == "chart_bar") {
            // $user = $_SESSION['user'] ?? 'guest';
            $user = $_POST['y'];
    
            $q=mysqli_query($koneksi, "SELECT MONTH (tgl) as bln, pemakaian FROM pemakaian WHERE username='$user'");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['pemakaian'];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_line") {
            $user = $_POST['y'];
    
            $q=mysqli_query($koneksi, "SELECT MONTH (tgl) as bln, tagihan FROM pemakaian WHERE username='$user'");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['tagihan'];
            }
            echo json_encode($respon);
        }
    }
}elseif($level == "bendahara") {
    if (isset($_POST['p'])) {
        $p=$_POST['p'];
        if ($p=="summary") {
            $bln = $_POST['t'];
            $sql1 = mysqli_query($koneksi, "SELECT COUNT(username) as jml_pelanggan FROM akun WHERE level='warga'");
            $d1 = mysqli_fetch_assoc($sql1);
            $data[] = array('jml_pelanggan' => $d1['jml_pelanggan']);
    
            $sql2 = mysqli_query($koneksi, "SELECT SUM(tagihan) as jml_tagihan FROM pemakaian WHERE tgl LIKE '$bln%' AND status = 'LUNAS'");
            $d2 = mysqli_fetch_assoc($sql2);
            $data[] = array('tagihan' => $d2['jml_tagihan']);

            // Jumlah pemakaian yang LUNAS
            $q3 = mysqli_query($koneksi, "SELECT COUNT(status) as sdh_lunas FROM pemakaian WHERE tgl LIKE '$bln%' AND status = 'LUNAS'");
            $d3 = mysqli_fetch_assoc($q3);
            $data[] = array('sdh_lunas' => $d3['sdh_lunas']);

            $sql4 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as total_pemakaian FROM pemakaian");
            $d4 = mysqli_fetch_assoc($sql4);
            $data[] = array('total_pemakaian' => $d4['total_pemakaian']);

            $sql5 = mysqli_query($koneksi, "SELECT SUM(tagihan) as total_tagihan FROM pemakaian");
            $d5 = mysqli_fetch_assoc($sql5);
            $data[] = array('total_tagihan' => $d5['total_tagihan']);

            $sql6 = mysqli_query($koneksi, "SELECT SUM(tagihan) as sdh_lunass FROM pemakaian WHERE status='LUNAS'");
            $d6 = mysqli_fetch_assoc($sql6);
            $data[] = array('sdh_lunass' => $d6['sdh_lunass']);
            
            echo json_encode($data);
        } elseif ($_POST['p'] == "chart_line1") {
            // $user = $_SESSION['user'] ?? 'guest';
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, SUM(pemakaian) as total_pemakaian FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['total_pemakaian'];
            }
            echo json_encode($respon);

        } elseif ($_POST['p'] == "chart_pie") {
            $q = mysqli_query($koneksi, "SELECT tipe, COUNT(*) as jumlah FROM akun WHERE tipe IN ('RT', 'kost') GROUP BY tipe");
            $respon = [];
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = ['tipe' => $d['tipe'], 'jumlah' => (int)$d['jumlah']];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_line2") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, SUM(tagihan) as total_tagihan FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['total_tagihan'];
            }
            echo json_encode($respon);

        } elseif ($_POST['p'] == "chart_line3") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, SUM(tagihan) as total_lunas FROM pemakaian WHERE status = 'LUNAS' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['total_lunas'];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(DISTINCT username) as sdh_dicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['sdh_dicatat'];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar2") {
            $user = $_POST['y'];
            $total_warga_query = mysqli_query($koneksi, "SELECT COUNT(DISTINCT username) as total_warga FROM akun WHERE level = 'warga'");
            $row_total = mysqli_fetch_assoc($total_warga_query);
            $total_warga = (int)$row_total['total_warga'];

            // Sudah mencatat per bulan
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(DISTINCT username) as sdh_dicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            $respon = [];
            while ($d = mysqli_fetch_assoc($q)) {
                $bln = (int)$d['bln'];
                $sdh = (int)$d['sdh_dicatat'];
                $blm = $total_warga - $sdh;
        
                $respon[] = $air->bln($bln);
                $respon[] = strval(max($blm, 0)); 
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar3") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(username) as sdh_lunas FROM pemakaian WHERE status = 'LUNAS' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['sdh_lunas'];
            }
            echo json_encode($respon);
        } elseif ($_POST['p'] == "chart_bar4") {
            $user = $_POST['y'];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bln, COUNT(username) as sdh_lunas FROM pemakaian WHERE status = 'BLM LUNAS' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl)");
            while ($d = mysqli_fetch_assoc($q)) {
                $respon[] = $air->bln($d ['bln']);
                $respon[] = $d ['sdh_lunas'];
            }
            echo json_encode($respon);
        }
    }
}

?>
