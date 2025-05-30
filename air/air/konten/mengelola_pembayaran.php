<?php
$kd_tarif = $tarif = $tipe = $status = "";
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
    if($t=="tarif_add") {
        $kd_tarif=$_POST['kd_tarif'];
        $tarif= $_POST['tarif'];
        $tipe= $_POST['tipe'];
        $status=$_POST['status'];

        //cek user
        $qc = mysqli_query($koneksi, "SELECT kd_tarif FROM tarif WHERE kd_tarif='$kd_tarif'");
        $qj = mysqli_num_rows($qc);
        //echo "hasil cek user: $qj";

        if($qj == 0) {
            mysqli_query($koneksi, "INSERT INTO tarif (kd_tarif,tarif,tipe,status) VALUES('$kd_tarif','$tarif','$tipe','$status')");
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
        } else {
            echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Tarif $kd_tarif</strong> Sudah ada
                </div>";
        }
    } elseif($t== "tarif_edit") {
        $kd_tarif=$_POST['kd_tarif'];
        $tarif= $_POST['tarif'];
        $tipe= $_POST['tipe'];
        $status=$_POST['status'];

        $sql = "UPDATE tarif SET tarif='$tarif', tipe='$tipe', status='$status' WHERE kd_tarif='$kd_tarif'";
        $q = mysqli_query($koneksi, $sql);

        //echo "<pre>";
        //print_r($_POST);
        //echo "</pre>";
       
        if($q) {
                echo"<div class='alert alert-success alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Tarif</strong> Berhasil diupdate
                </div>";
            }
            else {
                echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Tarif</strong> Gagal diupdate
                </div>";
            }
    }elseif($t== "tarif_hapus") {
        $kd_tarif = $_POST['kd_tarif'];
        mysqli_query($koneksi, "DELETE FROM tarif WHERE kd_tarif='$kd_tarif'");
        if(mysqli_affected_rows($koneksi) > 0) {
                echo"<div class='alert alert-success alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Tarif</strong> Berhasil dihapus
                </div>";
            }
            else {
                echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Tarif</strong> Gagal Dihapus
                </div>";
            }
    }
} elseif (isset($_GET['p'])) {
    $p = $_GET['p'];
    if ($p == "tarif_edit") {
        $kd_tarif = $_GET['kd_tarif'];
        echo "masuk sini untuk ngedit tarif: $kd_tarif";

        $q = mysqli_query($koneksi, "SELECT tarif, tipe, status FROM tarif WHERE kd_tarif ='$kd_tarif'");
        $d = mysqli_fetch_row($q);

        $tarif = $d[0];
        $tipe = $d[1];
        $status = $d[2];
        // gak perlu $d[3] karena gak ada
    }
}
?>
<div class="card mb-4" id="tarif_add">
    <div class="card-header">
        <i class="fa-solid fa-user-plus text-success"></i>
        Tarif
    </div>
    <div class="card-body">
        <form method="post" class="needs-validation" id= "tarif_form">
            <div class="mb-3 mt-3">
                <label for="kd_tarif" class="form-label">kd_tarif:</label>
                <input type="kd_tarif" class="form-control" id="kd_tarif" placeholder="Enter kd_tarif" value="<?php echo $kd_tarif ?>" name="kd_tarif" required>
            </div>
            <div class="mb-3">
                <label for="tarif" class="form-label">Tarif:</label>
                <input type="number" class="form-control" id="tarif" placeholder="Enter tarif" name="tarif" value="<?php echo $tarif ?>" required>
            </div>
            <div class="mb-3">
                <label for="tipe" class="form-label">tipe:</label>
                <select class="form-select" name="tipe">
                    <option>Tipe</option>
                    <?php
                    $t = array("RT", "kost");
                    foreach($t as $t2) {
                        if($tipe == $t2) $sel = "SELECTED";
                        else $sel = "";
                    echo " <option value=$t2 $sel>" .ucwords($t2)."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">status:</label>
                <select class="form-select" name="status">
                    <option>Status</option>
                    <?php
                    $s = array("AKTIF", "NON-AKTIF");
                    foreach($s as $s2) {
                        if($status == $s2) $sel = "SELECTED";
                        else $sel = "";
                    echo " <option value=$s2 $sel>" .ucwords($s2)."</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="tombol" value="tarif_add" id="btn-simpan">Simpan</button>
        </form>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi Hapus Tarif</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <form method="post">
            <button type="submit" name="tombol" value="tarif_hapus"  class="btn btn-danger" data-bs-dismiss="modal">Ya</button>
        </form>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tidak</button>
      </div>

    </div>
  </div>
</div>
<div class="card mb-4" id="tarif_list">
    <div class="card-header">
        <i class="fa-solid fa-users-gear text-warning"></i>
        Data Tarif
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>ID Tarif</th>
                    <th>Tarif</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Editing</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT kd_tarif,tarif,tipe,status FROM tarif ORDER BY kd_tarif ASC");
                while($d = mysqli_fetch_row($q)) {
                    $kd_tarif= $d[0];
                    $tarif = $d[1];
                    $tipe = $d[2];
                    $status = $d[3];

                    echo"
                    <tr>
                        <td>$kd_tarif</td>
                        <td>$tarif</td>
                        <td>$tipe</td>
                        <td>$status</td>
                        <td class='text-center'>
                        <div class='d-flex justify-content-center gap-2'>
                            <a href='index.php?p=tarif_edit&kd_tarif=$kd_tarif'>
                            <button type='button' class='btn btn-outline-success btn-sm'>Ubah</button>
                            </a>
                            <button type='button' class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#myModal' data-kd_tarif='$kd_tarif'>Hapus</button>
                        </div>
                        </td>
                    </tr>";
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
    if(e[1]=="manajement_tarif") {
        $("#tarif_add").hide();
        $("#tarif_list").show();
        $(".datatable-dropdown").append("<button type=button class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-money-bill-1-wave'></i></button>");
        $(".datatable-dropdown button").click(function () {
            console.log("tombol diklik");
            $("#tarif_list").hide();
            $("#tarif_add").show();
        });

        $("button[data-bs-toggle='modal']").click(function(){
            console.log("tombol hapus di klik");
            tarif=$(this).attr('data-kd_tarif');
            $("#myModal .modal-body").text("yakin hapus data tarif: "+tarif);
            $(".modal-footer form").append("<input type=hidden name=kd_tarif value="+tarif+">");
        })

    }else if (e[1].startsWith("tarif_edit")) { 
        $("summary,#chart,#tarif_list").hide();
        $("#tarif_add").show();
        $("#tarif_form button").val('tarif_edit');

        //mendisible primary key
        $("#tarif_form input[name='kd_tarif']").attr("disabled",true);

        //menambahkan elemen input dengan tipe hidden
        $("#tarif_form").append( "<input type='hidden' name='kd_tarif' value='" + e[2] + "'>");
    }
    $("#btn-simpan").click(function (e) {
        $("#tarif_add").hide();
        $("#tarif_list").show();
        $("#alert-success").fadeIn().delay(2000).fadeOut();
        });
    });
</script>

<style>
    td.edit {
    text-align: center;
    vertical-align: middle;
}
</style>

</body>
