<?php
$pass2 = $pass= $nama = $alamat = $kota = $tlp = $level = $status = $tipe = $user = "";
?>

<body>
<div class="row" id="summary" style="display: none;"> 
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Primary Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Warning Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Success Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Danger Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="chart" style="display:none;">
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Area Chart Example
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Bar Chart Example
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div>
<?php
if(isset($_POST['tombol'])) {
    $t=$_POST['tombol'];
    if($t=="user_add") {
        $user=$_POST['username'];
        $pass=password_hash($_POST['password'], PASSWORD_DEFAULT);
        $pass2= $_POST['password'];
        $nama=$_POST['nama'];
        $alamat=$_POST['alamat'];
        $kota=$_POST['kota'];
        $tlp=$_POST['tlp'];
        $level=$_POST['level'];
        $tipe=$_POST['tipe'];
        $status=$_POST['status'];

        //cek user
        $qc = mysqli_query($koneksi, "SELECT username FROM akun WHERE username='$user'");
        $qj = mysqli_num_rows($qc);
        //echo "hasil cek user: $qj";

        if($qj == 0) {
            mysqli_query($koneksi, "INSERT INTO akun (username,password,nama,alamat,kota,tlp,level,tipe,status) VALUES('$user','$pass',\"$nama\",'$alamat','$kota','$tlp','$level','$tipe','$status')");
            if(mysqli_affected_rows($koneksi) > 0) {
                echo"<div class='alert alert-success alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Data</strong> Berhasil dimasukan
                </div>";
            }
            else {
                echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Data</strong> Gagal Dimasukan
                </div>";
            }
        } else {
            echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Username $user</strong> Sudah ada
                </div>";
        }
    } elseif($t== "user_edit") {
        $user=$_POST['username'];
        $pass=$_POST['password'];
        $nama=$_POST['nama'];
        $alamat=$_POST['alamat'];
        $kota=$_POST['kota'];
        $tlp=$_POST['tlp'];
        $level=$_POST['level'];
        $tipe=$_POST['tipe'];
        $status=$_POST['status'];

        //cek password yang ada di tabel user
        $qcp = mysqli_query($koneksi, "SELECT password FROM akun WHERE username='$user'");
        $dcp = mysqli_fetch_row($qcp);
        $pass_db = $dcp[0];

            if ($pass == $pass_db) {
                // password tidak berubah
                $sql = "UPDATE akun SET nama='$nama', alamat='$alamat', kota='$kota', tlp='$tlp', level='$level', tipe='$tipe', status='$status' WHERE username='$user'";
            } else {
                // password berubah
                $pass2 = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "UPDATE akun SET password='$pass2', nama='$nama', alamat='$alamat', kota='$kota', tlp='$tlp', level='$level', tipe='$tipe', status='$status' WHERE username='$user'";
            }

        $q = mysqli_query($koneksi, $sql);

        //echo "<pre>";
        //print_r($_POST);
        //echo "</pre>";
       
        if($q) {
                echo"<div class='alert alert-success alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Data</strong> Berhasil diupdate
                </div>";
            }
            else {
                echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Data</strong> Gagal diupdate
                </div>";
            }
    }elseif($t== "user_hapus") {
        $user = $_POST['user'];
        mysqli_query($koneksi, "DELETE FROM akun WHERE username='$user'");
        if(mysqli_affected_rows($koneksi) > 0) {
                echo"<div class='alert alert-success alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Data</strong> Berhasil dihapus
                </div>";
            }
            else {
                echo"<div class='alert alert-danger alert-dismissible fade show'>
                <button type=button class=btn-close data-bs-dismiss=alert></button>
                <strong>Data</strong> Gagal Dihapus
                </div>";
            }
    }
} elseif(isset($_GET['p'])) {
    $p = $_GET['p'];
    if ($p == "user_edit") {
        $user = $_GET['user'];
        echo "masuk sini untuk ngedit user: $user";

        $q = mysqli_query($koneksi, "SELECT password,nama,alamat,kota,tlp,level,tipe,status FROM akun WHERE username ='$user'");
        $d = mysqli_fetch_row($q);
        $pass = $d[0];
        $pswd = $d[0];
        $pass2 = password_hash($pass, PASSWORD_DEFAULT);
        $nama = $d[1];
        $alamat = $d[2];
        $kota = $d[3];
        $tlp = $d[4];
        $level = $d[5];
        $tipe = $d[6];
        $status = $d[7];
    }
}
?>
<div class="card mb-4" id="user_add">
    <div class="card-header">
        <i class="fa-solid fa-user-plus text-success"></i>
        User
    </div>
    <div class="card-body">
        <form method="post" class="needs-validation" id= "user_form">
            <div class="mb-3 mt-3">
                <label for="username" class="form-label">Username:</label>
                <input type="username" class="form-control" id="username" placeholder="Enter username" name="username" value="<?php echo $user ?>"  required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" value="<?php echo $pswd ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">nama:</label>
                <input type="nama" class="form-control" id="nama" placeholder="Enter name" name="nama" value="<?php echo $nama ?>" required>
            </div>
            <div class="mb-3">
                <label for="comment">Alamat</label>
                <textarea class="form-control" rows="5" id="alamat" name="alamat"><?php echo $alamat ?></textarea>
            </div>
            <div class="mb-3">
                <label for="kota" class="form-label">Kota:</label>
                <input type="nama" class="form-control" id="kota" placeholder="Enter kota" name="kota" value="<?php echo $kota ?>" required>
            </div>
            <div class="mb-3">
                <label for="tlp" class="form-label">telepon:</label>
                <input type="number" class="form-control" id="tlp" placeholder="Enter telepon" name="tlp" value="<?php echo $tlp ?>" required>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">level:</label>
                <select class="form-select" name="level">
                    <option>Level</option>
                    <?php
                    $lv = array("admin", "bendahara", "petugas", "warga");
                    foreach ($lv as $lv2) {
                        if($level == $lv2) $sel = "SELECTED";
                        else $sel = "";
                        echo " <option value=$lv2 $sel>" .ucwords($lv2)."</option>";
                    }
                    ?>
                </select>
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
            <button type="submit" class="btn btn-primary" name="tombol" value="user_add" id="btn-simpan">Simpan</button>
        </form>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <form method="post">
            <button type="submit" name="tombol" value="user_hapus"  class="btn btn-danger" data-bs-dismiss="modal">Ya</button>
        </form>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tidak</button>
      </div>

    </div>
  </div>
</div>
<div class="card mb-4" id="user_list">
    <div class="card-header">
        <i class="fa-solid fa-users-gear text-warning"></i>
        Data User
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>user</th>
                    <th>nama</th>
                    <th>alamat</th>
                    <th>kota</th>
                    <th>tlp</th>
                    <th>level</th>
                    <th>tipe</th>
                    <th>Status</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT username, nama, alamat, kota, tlp, level, tipe, status FROM akun ORDER BY level ASC");
                while($d = mysqli_fetch_row($q)) {
                    $user= $d[0];
                    $nama = $d[1];
                    $alamat = $d[2];
                    $kota = $d[3];
                    $tlp = $d[4];
                    $level = $d[5];
                    $tipe = $d[6];
                    $status = $d[7];

                    echo"
                    <tr>
                        <td>$user</td>
                        <td>$nama</td>
                        <td>$alamat</td>
                        <td>$kota</td>
                        <td>$tlp</td>
                        <td>$level</td>
                        <td>$tipe</td>
                        <td>$status</td>
                        <td>
                        <a href=index.php?p=user_edit&user=$user><button type=button class='btn btn-outline-success btn-sm'>Ubah</button></a>
                        <button type=button class='btn btn-outline-danger btn-sm' data-bs-toggle=modal data-bs-target=#myModal data-user=$user>Hapus</button>
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
    if(e[1]=="user") {
        $("summary,#chart,#user_add").hide();
        $("#user_list").show();
        $(".datatable-dropdown").append("<button type=button class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-user-plus'></i></button>");
        $(".datatable-dropdown button").click(function () {
            console.log("tombol diklik");
            $("#user_list").hide();
            $("#user_add").show();
        });

        $("button[data-bs-toggle='modal']").click(function(){
            console.log("tombol hapus di klik");
            user=$(this).attr('data-user');
            $("#myModal .modal-body").text("yakin hapus data username: "+user);
            $(".modal-footer form").append("<input type=hidden name=user value="+user+">");
        })

    }else if (e[1].startsWith("user_edit")) { 
        $("summary,#chart,#user_list").hide();
        $("#user_add").show();
        $("#user_form button").val('user_edit');

        //mendisible primary key
        $("#user_form input[name='username']").attr("disabled",true);

        //menambahkan elemen input dengan tipe hidden
        $("#user_form").append( "<input type='hidden' name='username' value='" + e[2] + "'>");
    }

    $("#btn-simpan").click(function (e) {
        $("#user_add").hide();
        $("#user_list").show();
        $("#alert-success").fadeIn().delay(2000).fadeOut();
        });
    });
</script>

</body>