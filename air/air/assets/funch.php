<?php
class klas_air
{
    function koneksi()
    {
        $koneksi = mysqli_connect("localhost", "tkbmyid_user_air", "#Us3r_A1r_2025#", "tkbmyid_air_gentara");
        return $koneksi;
    }

    function dt_user($sesi_user)
     {
        $q=mysqli_query($this->koneksi(),"SELECT nama, kota, level FROM akun WHERE username='$sesi_user'");
        $d=mysqli_fetch_row($q);
        return$d;
    }

    function user_to_idtarif($username)
     {
        $koneksi = $this->koneksi();
        $username = mysqli_real_escape_string($koneksi, $username);
        $q = mysqli_query($koneksi, "SELECT tipe FROM akun WHERE username='$username'");
        
        if(mysqli_num_rows($q) > 0) {
            $d = mysqli_fetch_row($q);
            $tipe = $d[0];
            return $this->tipe_to_kdtarif($tipe);
        } else {
            return false; // atau handle error sesuai kebutuhan
        }
    }

    function tipe_to_kdtarif($tipe)
    {
        $koneksi = $this->koneksi();
        $tipe = mysqli_real_escape_string($koneksi, $tipe);
        $q = mysqli_query($koneksi, "SELECT kd_tarif FROM tarif WHERE tipe='$tipe'");
        
        if(mysqli_num_rows($q) > 0) {
            $d = mysqli_fetch_row($q);
            return $d[0];
        } else {
            return 0; // atau throw exception
        }
    }
    function kdtarif_to_tarif($kd_tarif)
     {
        $koneksi = $this->koneksi();
        $kd_tarif = mysqli_real_escape_string($koneksi, $kd_tarif);
        $q = mysqli_query($koneksi, "SELECT tarif FROM tarif WHERE kd_tarif='$kd_tarif'");
        
        if(mysqli_num_rows($q) > 0) {
            $d = mysqli_fetch_row($q);
            return $d[0];
        } else {
            return 0; // atau throw exception
        }
    }

    function tipe_user($username)
    {
        $koneksi = $this->koneksi();
        $username = mysqli_real_escape_string($koneksi, $username);
        $q = mysqli_query($koneksi, "SELECT tipe FROM akun WHERE username='$username'");
        if(mysqli_num_rows($q) > 0) {
            $d = mysqli_fetch_row($q);
            return $d[0];
        } else {
            return "Tidak Diketahui";
        }
    }

    function bln($no) 
    {
        if ($no == 1) $bln = "Januari";
        elseif ($no == 2) $bln = "Februari";
        elseif ($no == 3) $bln = "Maret";
        elseif ($no == 4) $bln = "April";
        elseif ($no == 5) $bln = "Mei";
        elseif ($no == 6) $bln = "Juni";
        elseif ($no == 7) $bln = "Juli";
        elseif ($no == 8) $bln = "Agustus";
        elseif ($no == 9) $bln = "September";
        elseif ($no == 10) $bln = "Oktokber";
        elseif ($no == 11) $bln = "November";
        else $bln = "Desember";
        return $bln;
    }
}
?>