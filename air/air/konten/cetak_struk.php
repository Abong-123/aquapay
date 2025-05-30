<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('../fpdf186/fpdf.php');
include '../assets/funch.php'; // koneksi ke database

$air = new klas_air();
$koneksi = $air->koneksi();

$no = $_GET['no'];
$q = mysqli_query($koneksi, "SELECT * FROM pemakaian WHERE no='$no'");
$d = mysqli_fetch_assoc($q);


// ambil data user
session_start();
$dt_user = $air->dt_user($d['username']);
$nama = $dt_user[0];

$pdf = new FPDF('P', 'mm', array(80, 140)); // 80mm thermal receipt size
$pdf->AddPage();

// Logo - pastikan logo PNG 1:1 (misal: 'logo.png') berada di folder yang bisa diakses
$pdf->Image('../../assets/img/logo.png', 30, 5, 20); // x=30 agar di tengah
$pdf->Ln(20);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0, 5, 'AquaPay', 0, 1, 'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(0, 5, 'Struk Pembayaran Air', 0, 1, 'C');

$pdf->Ln(2);
$pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
$pdf->Ln(3);

// Konten data
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,5,'Nama',0,0);         $pdf->Cell(2,5,':',0,0); $pdf->Cell(40,5,$nama,0,1);
$pdf->Cell(30,5,'Tanggal',0,0);      $pdf->Cell(2,5,':',0,0); $pdf->Cell(40,5,$d['tgl'].' '.$d['waktu'],0,1);
$pdf->Cell(30,5,'Meter Awal',0,0);   $pdf->Cell(2,5,':',0,0); $pdf->Cell(40,5,$d['meter_awal'],0,1);
$pdf->Cell(30,5,'Meter Akhir',0,0);  $pdf->Cell(2,5,':',0,0); $pdf->Cell(40,5,$d['meter_akhir'],0,1);
$pdf->Cell(30,5,'Pemakaian',0,0);    $pdf->Cell(2,5,':',0,0); $pdf->Cell(40,5,$d['pemakaian'].' m3',0,1);
$pdf->Cell(30,5,'Tagihan',0,0);      $pdf->Cell(2,5,':',0,0); $pdf->Cell(40,5,'Rp '.number_format($d['tagihan'], 0, ',', '.'),0,1);
$pdf->Cell(30,5,'Status',0,0);       $pdf->Cell(2,5,':',0,0); $pdf->Cell(40,5,$d['status'],0,1);

$pdf->Ln(3);
$pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
$pdf->Ln(3);

// Pesan penutup
$pdf->SetFont('Arial','I',8);
$pdf->MultiCell(0, 5, "Terima kasih telah melakukan pembayaran.\nAquaPay menyatakan struk ini sebagai bukti pembayaran yang sah.", 0, 'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0, 5, '** Simpan struk ini sebagai bukti pembayaran **', 0, 1, 'C');

$pdf->Output('I', 'struk_pembayaran_'.$no.'.pdf');
?>