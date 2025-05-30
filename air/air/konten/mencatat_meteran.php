<?php
$username = $meter_akhir = $meter_awal = $pemakaian = $tgl = $waktu = "";
?>
<head>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
 
</style>
</head>

<body>

<?php
if(isset($_POST['tombol'])) {
    $t=$_POST['tombol'];
    if($t=="meter_add") {
        $username=$_POST['username'];
        $meter_awal= $_POST['meter_awal'];
        $meter_akhir= $_POST['meter_akhir'];
        $kd_tarif = $air->user_to_idtarif($username); // kd_tarif dari tipe
        $tarif = $air->kdtarif_to_tarif($kd_tarif);   // nilai tarif dari kd_tarif
        $pemakaian = $meter_akhir - $meter_awal;
        $tagihan = $tarif * $pemakaian;
        if($pemakaian < 0) {
            echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Meter Akhir</strong> harus lebih besar dari meter awal
                </div>";
        } else {
            mysqli_query($koneksi, "INSERT INTO pemakaian (username,meter_awal,meter_akhir,pemakaian,tgl,waktu,kd_tarif,tagihan,status) VALUES ('$username','$meter_awal','$meter_akhir','$pemakaian',CURRENT_DATE(),CURRENT_TIME(),'$kd_tarif','$tagihan','BLM LUNAS')");
            if(mysqli_affected_rows($koneksi) > 0) {
                echo"<div class='alert alert-success alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Tarif</strong> Berhasil dimasukan
                </div>";
            }
            else {
                echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Tarif</strong> Gagal Dimasukan
                </div>";
            }
        }
    } elseif($t== "meter_edit") {
    $no = $_POST['no'];
    $meter_awal = $_POST['meter_awal'];
    $meter_akhir = $_POST['meter_akhir'];

    // Ambil kd_tarif berdasarkan no
    $q = mysqli_query($koneksi, "SELECT kd_tarif FROM pemakaian WHERE no='$no'");
    $d = mysqli_fetch_assoc($q);
    $kd_tarif = $d['kd_tarif'];

    // Hitung tarif berdasarkan kd_tarif
    $tarif = $air->kdtarif_to_tarif($kd_tarif);

    // Hitung ulang
    $pemakaian = $meter_akhir - $meter_awal;
    if ($pemakaian < 0) {
        echo "<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Meter Akhir</strong> harus lebih besar dari meter awal
              </div>";
    } else {
        $tagihan = $tarif * $pemakaian;
        $sql = "UPDATE pemakaian SET meter_awal='$meter_awal', meter_akhir='$meter_akhir', pemakaian='$pemakaian', tagihan='$tagihan' WHERE no='$no'";
        $q = mysqli_query($koneksi, $sql);

        if ($q && mysqli_affected_rows($koneksi) > 0) {
            echo "<div class='alert alert-success alert-dismissible fade show'>
                    <button type=button class=btn-close data-bs-dismiss=alert></button>
                    <strong>Data</strong> berhasil diupdate
                  </div>";
        } else {
            echo "<div class='alert alert-warning alert-dismissible fade show'>
                    <button type=button class=btn-close data-bs-dismiss=alert></button>
                    <strong>Data</strong> tidak ada perubahan
                  </div>";
        }
    }
    }elseif($t== "meter_hapus") {
        $no = $_POST['no'];
        $query = "DELETE FROM pemakaian WHERE no='$no'";
        mysqli_query($koneksi, $query);
        if (mysqli_affected_rows($koneksi) > 0) {
            echo "<div class='alert alert-success alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Data</strong> berhasil dihapus
                </div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Data</strong> gagal dihapus
                </div>";
        }
    }
} elseif (isset($_GET['p'])) {
    $p = $_GET['p'];
    if (isset($_GET['p']) && $_GET['p'] == "meter_edit") {
        $no = $_GET['no'];
        $q = mysqli_query($koneksi, "SELECT username, meter_awal, meter_akhir FROM pemakaian WHERE no='$no'");
        $d = mysqli_fetch_row($q);
        $username = $d[0];
        $meter_awal = $d[1];
        $meter_akhir = $d[2];
    }
}
?>
<div class="card mb-4" id="meter_add">
    <div class="card-header">
        <i class="fa-solid fa-user-plus text-success"></i>
        Tarif
    </div>
    <div class="card-body">
        <form method="post" class="needs-validation" id= "meter_form">
            <div class="mb-3 mt-3">
                <label for="username" class="form-label">Nama Warga</label>
                <select name="username" class="form-select" required>
                    <option value="" name="username">Nama Warga</option>
                    <?php
                    $qw = mysqli_query($koneksi, "SELECT username, nama FROM akun WHERE level='warga'");
                    while ($dw = mysqli_fetch_row($qw)) {
                        if ($username == $dw[0]) $sel = "SELECTED";
                        else $sel = "";
                        echo "<option value=$dw[0] $sel>$dw[1]</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="meter_awal" class="form-label">Meter_awal (m <sup>3</sup>):</label>
                <input type="text" class="form-control" id="meter_awal" placeholder="Enter meter awal" name="meter_awal" value="<?php echo $meter_awal ?>" required>
            </div>
            <div class="mb-3">
                <label for="meter_akhir" class="form-label">Meter_akhir (m <sup>3</sup>):</label>
                <input type="text" class="form-control" id="meter_akhir" placeholder="Enter meter akhir" name="meter_akhir" value="<?php echo $meter_akhir ?>" required>
            </div>
            <input type="hidden" name="no" value="<?php echo $no ?>">
            <button type="submit" class="btn btn-primary" name="tombol" value="meter_add" id="btn-simpan">Simpan</button>
        </form>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi Hapus Meteran</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <form method="post">
            <button type="submit" name="tombol" value="meter_hapus"  class="btn btn-danger" data-bs-dismiss="modal">Ya</button>
        </form>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tidak</button>
      </div>

    </div>
  </div>
</div>



<div class="card mb-4" id="meter_list">
    <div class="card-header">
        <i class="fa-solid fa-users-gear text-warning"></i>
        Data Tarif
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Nama Warga</th>
                    <th>Tanggal & Waktu</th>
                    <th>Meter Awal</th>
                    <th>Meter Akhir</th>
                    <th>Pemakaian</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT no,username,meter_awal,meter_akhir,pemakaian,tgl,waktu,tagihan FROM pemakaian ORDER BY tgl DESC, username ASC");
                while($d = mysqli_fetch_row($q)) {
                    $no = $d[0];
                    $dt_user2 = $air->dt_user($d[1]);
                    $nama = $dt_user2[0];
                    $meter_awal = $d[2];
                    $meter_akhir = $d[3];
                    $pemakaian = $d[4];
                    $tgl = $d[5];
                    $waktu = $d[6];
                    $tagihan = $d[7];
                    $pembayaran = "Rp " . number_format($tagihan, 0, ',', '.');
                    $tgl_tabel = date_create($d[5]);
                    $tgl_sekarang=date_create();
                    $diff = date_diff($tgl_tabel, $tgl_sekarang);
                    $selisih = $diff->days;
                    echo"
                    <tr>
                        <td>$nama</td>
                        <td>$tgl $waktu | " . date("Y-m-d") . " $selisih hari</td>
                        <td>$meter_awal</td>
                        <td>$meter_akhir</td>
                        <td>$pemakaian</td>";
                    if($selisih <= 30) {
                        echo"
                        <td>
                            <a href='index.php?p=meter_edit&no=$no'> <button type='button' class='btn btn-outline-success btn-sm'>Ubah</button></a>
                            <button type='button' class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#myModal' data-no='$no'>Hapus</button>
                        </td>
                        ";
                    } else {
                        echo"<td></td>";
                    }   
                    echo"</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
    uri=window.location.href;
    e=uri.split("=");
    console.log("URI: "+uri+"e[1]:"+e[1]);
    if(e[1]=="mencatat_meter_warga") {
        $("#meter_add").hide();
        $("#meter_list").show();
        $(".datatable-dropdown").append("<button type=button class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-square-plus fa-beat'></i> Meter</button>");
        $(".datatable-dropdown button").click(function () {
            console.log("tombol diklik");
            $("#meter_list").hide();
            $("#meter_add").show();
        });

        $("button[data-bs-toggle='modal']").click(function(){
            console.log("tombol hapus di klik");
            nama=$(this).attr('data-no');
            $("#myModal .modal-body").text("yakin hapus data meteran: "+nama);
            $(".modal-footer form").append("<input type=hidden name=no value="+nama+">");
        });

    }else if (e[1].startsWith("meter_edit")) { 
        $("#meter_add").show();
        $("#meter_list").hide();
        $("#meter_form button").val('meter_edit');
        $("#meter_form input[name='no']").attr("disabled", true);
        $("#meter_form").append("<input type='hidden' name='no' value='" + e[2] + "'>");
        $("#meter_form").append("<input type='hidden' name='mode' value='edit'>");

        $("#meter_form select[name='username']").attr("disabled", true);
    }

    

    $("#btn-simpan").click(function (e) {
        $("#meter_add").hide();
        $("#meter_list").show();
        $("#alert-success").fadeIn().delay(2000).fadeOut();
        });
    });

</script>
<script>
  console.log("meter_add exists?", document.querySelector("#meter_add"));
</script>
<style>
    td.edit {
    text-align: center;
    vertical-align: middle;
}
</style>
</body>
