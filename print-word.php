<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location:../../../auth/login");
  exit;
}

require('../../../funct/functions.php');

// SESSION USER LOGIN
if (isset($_SESSION["login"])) {

  $userSession = $_SESSION["username"];
  $resultSession = $conn->query("SELECT * FROM tb_users WHERE username = '$userSession' ");
  $rowSession = mysqli_fetch_assoc($resultSession);
  $idSession = $rowSession["id"];
}
// CEK LEVEL
include("../../../include/check-level.php");
if (($rowSession["level"] === $levelPPK)) {
  header("Location:../../");
  exit;
}
// membaca data dari form
$noBlnAngka = $_POST["no_bln_angka"];
$noTgl = $_POST["no_tgl"];
$noKegiatan = $_POST["no_kegiatan"];
$noBlnRomawi = $_POST["no_bln_romawi"];
$noTahun = $_POST["no_tahun"];
$namaSatker = $_POST["nama_satker"];
$alamatSatker = $_POST["alamat_satker"];
$namaPerusahaan = $_POST["nama_perusahaan"];
$alamatPerusahaan = $_POST["alamat_perusahaan"];
$namaWakilPenyedia = $_POST["nama_wakil_penyedia"];
$jabatan = $_POST["jabatan"];
$namaPekerjaan = $_POST["nama_pekerjaan"];
$tahunAnggaran = $_POST["tahun_anggaran"];
$nomorDipa = $_POST["nomor_dipa"];
$tglBlnThnDipa = $_POST["tgl_bln_thn_dipa"];
$program = $_POST["program"];
$kegiatan = $_POST["kegiatan"];
$output = $_POST["output"];
$subOutput = $_POST["sub_output"];
$komponen = $_POST["komponen"];
$subKomponen = $_POST["sub_komponen"];
$akun = $_POST["akun"];
$rincianPok = $_POST["rincian_pok"];
$fromTgl = $_POST["from_tgl"];
$toTgl = $_POST["to_tgl"];
$range = $_POST["range"];
$rangeSpelling = $_POST["range_spelling"];
$namaTempat = $_POST["nama_tempat"];
$tglSurat = $_POST["tgl_bln_thn"];
$jenisSpesifikasi = $_POST["jenis_spesifikasi"];
$satuan = $_POST["satuan"];
$vol = $_POST["vol"];
$hargaSatuan = $_POST["harga_satuan"];
$totalHarga = $_POST["total_harga"];
$ppn = $_POST["ppn"];
$total = $_POST["total"];
$rounded = $_POST["rounded"];
$roundedSpeeling = $_POST["rounded_spelling"];
$keterangan = $_POST["keterangan"];
$namaPp = $_POST["nama_pp"];
$nip = $_POST["nip"];

// memanggil dan membaca template dokumen yang telah kita buat
$document = file_get_contents("spes.rtf");

// isi dokumen dinyatakan dalam bentuk string
$document = str_replace("%%no_bln_angka%%", $noBlnAngka, $document);
$document = str_replace("%%no_tgl%%", $noTgl, $document);
$document = str_replace("%%no_kegiatan%%", $noKegiatan, $document);
$document = str_replace("%%no_bln_romawi%%", $noBlnRomawi, $document);
$document = str_replace("%%no_tahun%%", $noTahun, $document);
$document = str_replace("%%nama_satker%%", $namaSatker, $document);
$document = str_replace("%%alamat_satker%%", $alamatSatker, $document);
$document = str_replace("%%nama_perusahaan%%", $namaPerusahaan, $document);
$document = str_replace("%%alamat_perusahaan%%", $alamatPerusahaan, $document);
$document = str_replace("%%nama_wakil_penyedia%%", $namaWakilPenyedia, $document);
$document = str_replace("%%jabatan%%", $jabatan, $document);
$document = str_replace("%%nama_pekerjaan%%", $namaPekerjaan, $document);
$document = str_replace("%%tahun_anggaran%%", $tahunAnggaran, $document);
$document = str_replace("%%nomor_dipa%%", $nomorDipa, $document);
$document = str_replace("%%tgl_bln_thn_dipa%%", $tglBlnThnDipa, $document);
$document = str_replace("%%program%%", $program, $document);
$document = str_replace("%%kegiatan%%", $kegiatan, $document);
$document = str_replace("%%output%%", $output, $document);
$document = str_replace("%%sub_output%%", $subOutput, $document);
$document = str_replace("%%komponen%%", $komponen, $document);
$document = str_replace("%%sub_komponen%%", $subKomponen, $document);
$document = str_replace("%%akun%%", $akun, $document);
$document = str_replace("%%rincian_pok%%", $rincianPok, $document);
$document = str_replace("%%from_tgl%%", $fromTgl, $document);
$document = str_replace("%%to_tgl%%", $toTgl, $document);
$document = str_replace("%%range%%", $range, $document);
$document = str_replace("%%range_spelling%%", $rangeSpelling, $document);
$document = str_replace("%%nama_tempat%%", $namaTempat, $document);
$document = str_replace("%%tgl_bln_thn%%", $tglSurat, $document);
$document = str_replace("%%jenis_spesifikasi%%", $jenisSpesifikasi, $document);
$document = str_replace("%%satuan%%", $satuan, $document);
$document = str_replace("%%vol%%", $vol, $document);
$document = str_replace("%%harga_satuan%%", $hargaSatuan, $document);
$document = str_replace("%%total_harga%%", $totalHarga, $document);
$document = str_replace("%%ppn%%", $ppn, $document);
$document = str_replace("%%total%%", $total, $document);
$document = str_replace("%%rounded%%", $rounded, $document);
$document = str_replace("%%rounded_spelling%%", $roundedSpeeling, $document);
$document = str_replace("%%keterangan%%", $keterangan, $document);
$document = str_replace("%%nama_pp%%", $namaPp, $document);
$document = str_replace("%%nip%%", $nip, $document);
// header untuk membuka file output RTF dengan MS. Word
header("Content-type: application/msword");
header("Content-disposition: inline; filename=6_PP_Surat Pesanan.doc");
header("Content-length: " . strlen($document));
echo $document;
