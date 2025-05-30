<?php
$username = $meter_akhir = $meter_awal = $pemakaian = $tgl = $waktu = "";
?>
<head>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

<?php
if (isset($_POST['tombol'])) {
    $t = $_POST['tombol'];
    if ($t == "meter_bayar") {
        $no = $_POST['no'];
        $meter_awal = $_POST['meter_awal'];
        $meter_akhir = $_POST['meter_akhir'];
        $q = mysqli_query($koneksi, "SELECT kd_tarif, username FROM pemakaian WHERE no='$no'");
        $d = mysqli_fetch_assoc($q);
        $kd_tarif = $d['kd_tarif'];
        $username = $d['username'];

        // Hitung tarif berdasarkan kd_tarif
        $tarif = $air->kdtarif_to_tarif($kd_tarif);

        // Hitung ulang
        $pemakaian = $meter_akhir - $meter_awal;
        if ($pemakaian < 0) {
            echo "<div class='alert alert-danger'>Meter akhir harus lebih besar dari meter awal!</div>";
        } else {
            $tagihan = $tarif * $pemakaian;
            $sql = "UPDATE pemakaian SET meter_awal='$meter_awal', meter_akhir='$meter_akhir', pemakaian='$pemakaian', tagihan='$tagihan' WHERE no='$no'";
            $q = mysqli_query($koneksi, $sql);

            echo "<div class='card-body'>
                    <h5 class='mb-3'>Struk Pembayaran</h5>
                    <p><strong>Nama:</strong> $username</p>
                    <p><strong>Meter Awal:</strong> $meter_awal</p>
                    <p><strong>Meter Akhir:</strong> $meter_akhir</p>
                    <p><strong>Pemakaian:</strong> $pemakaian m³</p>
                    <p><strong>Kode Tarif:</strong> $kd_tarif</p>
                    <p><strong>Tarif per m³:</strong> Rp".number_format($tarif,0,',','.')."</p>
                    <p><strong>Total Tagihan:</strong> <span class='text-danger fw-bold'>Rp".number_format($tagihan,0,',','.')."</span></p>
                    <form method='post'>
                        <input type='hidden' name='tombol' value='struk_pembayaran'>
                        <input type='hidden' name='no' value='$no'>
                        <button type='submit' class='btn btn-primary'>Bayar</button>
                    </form>
                  </div>";
        }
    } elseif ($t == "struk_pembayaran") {
        $no = $_POST['no'];
        $q = mysqli_query($koneksi, "SELECT * FROM pemakaian WHERE no='$no'");
        $d = mysqli_fetch_assoc($q);
    
        $username = $d['username'];
        $meter_awal = $d['meter_awal'];
        $meter_akhir = $d['meter_akhir'];
        $pemakaian = $d['pemakaian'];
        $kd_tarif = $d['kd_tarif'];
        $tagihan = $d['tagihan'];
        $tarif = $air->kdtarif_to_tarif($kd_tarif);
         // Panggil API QRIS
            $url = "https://qrisku.my.id/api";
            $data = [
                "amount" => $tagihan,
                "qris_statis" => "00020101021126570011ID.DANA.WWW011893600915323092861102092309286110303UMI51440014ID.CO.QRIS.WWW0215ID10221515668360303UMI5204581253033605802ID5915KANG ADIT STORE6013Kota Semarang6105502346304F790"
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $response = curl_exec($ch);
            $qris_output = "";

            if (curl_errno($ch)) {
                $qris_output = "<p class='text-danger'>Gagal memuat QRIS: " . curl_error($ch) . "</p>";
            } else {
                $response_data = json_decode($response, true);
                if ($response_data['status'] == 'success' && isset($response_data['qris_base64'])) {
                    $qris_base64 = $response_data['qris_base64'];
                    $qris_output = "
                        <h6 class='mt-4'>Scan QRIS untuk Membayar:</h6>
                        <img src='data:image/png;base64,{$qris_base64}' alt='QRIS Image' class='img-fluid' style='max-width:300px;' />
                    ";
                } else {
                    $message = isset($response_data['message']) ? $response_data['message'] : 'QRIS tidak tersedia.';
                    $qris_output = "<p class='text-danger'>Gagal memuat QRIS: {$message}</p>";
                }
            }

            curl_close($ch);
            // Tambahkan tombol konfirmasi pembayaran
            $qris_output .= "
            <form method='post'>
                <input type='hidden' name='tombol' value='bayar_manual'>
                <input type='hidden' name='no' value='$no'>
                <button type='submit' class='btn btn-primary mt-4'>Konfirmasi Pembayaran</button>
            </form>";
            // Tampilkan hasilnya
            echo "
            <div class='card-body text-center'>
                {$qris_output}
                <div class='mt-4'>
                    <a href='index.php' class='btn btn-secondary'>← Kembali</a>
                </div>
            </div>";
    } elseif ($t == "bayar_manual") {
        $no = $_POST['no'];
        mysqli_query($koneksi, "UPDATE pemakaian SET status='LUNAS' WHERE no='$no'");
        header("Location: index.php?p=lihat_pemakaian");
        exit;
    }

} elseif (isset($_GET['p']) && $_GET['p'] == "meter_bayar") {
    $no = $_GET['no'];
    $q = mysqli_query($koneksi, "SELECT username, meter_awal, meter_akhir FROM pemakaian WHERE no='$no'");
    $d = mysqli_fetch_assoc($q);
    $username = $d['username'];
    $meter_awal = $d['meter_awal'];
    $meter_akhir = $d['meter_akhir'];
    echo "
    <form method='post'>
        <input type='hidden' name='no' value='$no'>
        <div class='mb-3'>
            <label class='form-label'>Meter Awal</label>
            <input type='number' name='meter_awal' class='form-control' value='$meter_awal' readonly>
        </div>
        <div class='mb-3'>
            <label class='form-label'>Meter Akhir</label>
            <input type='number' name='meter_akhir' class='form-control' value='$meter_akhir' readonly>
        </div>
        <button type='submit' name='tombol' value='meter_bayar' class='btn btn-success'>Hitung & Bayar</button>
    </form>
    ";
}
?>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi Pembayaran</h4>
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
                    <th>Tanggal & Waktu</th>
                    <th>Kd Tarif</th>
                    <th>Meter Awal</th>
                    <th>Meter Akhir</th>
                    <th>Pemakaian</th>
                    <th>Pembayaran</th>
                    <th>Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT no,username,meter_awal,meter_akhir,pemakaian,tgl,waktu,tagihan,status FROM pemakaian WHERE username='{$_SESSION['user']}' ORDER BY tgl DESC");
                while($d = mysqli_fetch_row($q)) {
                    $no = $d[0];
                    $dt_user2 = $air->dt_user($d[1]);
                    $nama = $dt_user2[0];
                    $meter_awal = $d[2];
                    $meter_akhir = $d[3];
                    $pemakaian = $d[4];

                    $kd_tarif = $air->user_to_idtarif($d[1]);
                    // Ambil nilai tarif berdasarkan kd_tarif
                    $tarif = $air->kdtarif_to_tarif($kd_tarif);

                    
                    $tgl = $d[5];
                    $waktu = $d[6];
                    $tagihan = $d[7];
                    $status = $d[8];
                    $pembayaran = "Rp " . number_format($tagihan, 0, ',', '.');
                    $harga_satuan = "Rp " . number_format($tarif, 0, ',', '.');
                
                    // Cek status
                    $tombol = "";
                    if ($status == 'LUNAS') {
                        $tombol = "<a href='../konten/cetak_struk.php?no=$no' target='_blank'><button type='button' class='btn btn-outline-info btn-sm'>Cetak Struk</button></a>";
                    } else {
                        $tombol = "<a href='index.php?p=meter_bayar&no=$no'><button type='button' class='btn btn-outline-success btn-sm'>Bayar</button></a>";
                    }
                
                    echo "
                    <tr>
                        <td>$tgl $waktu</td>
                        <td>$harga_satuan</td>
                        <td>$meter_awal</td>
                        <td>$meter_akhir</td>
                        <td>$pemakaian</td>
                        <td>$pembayaran</td>
                        <td>$tombol</td> 
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
    if(e[1]=="lihat_pemakaian") {
        $("#meter_add").hide();
        $("#meter_list").show();

    }else if (e[1].startsWith("meter_bayar")) { 
        $("#meter_add").show();
        $("#meter_list").hide();
        $("#meter_form button").val('meter_bayar');
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
<style>
    td.edit {
    text-align: center;
    vertical-align: middle;
}
</style>
</body>
