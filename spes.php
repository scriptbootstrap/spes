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

	// Count data table
	include("../../../include/count-data-table.php");
}

// query table Spes
$querySpes = query("SELECT * FROM tb_spes");

// check empty account
if (empty($rowSession["id"])) {
	header("Location:../../../auth/logout");
	exit;
}

// CEK LEVEL
include("../../../include/check-level.php");

if (($rowSession["level"] === $levelPPK)) {
	header("Location:../../");
	exit;
}

// SET DATE
date_default_timezone_set('Asia/Makassar');

// tanggal, bulan, tahun
$tbh = date("d M Y");

// Format Romawi Month
include("../../../include/romawi-month.php");

// Format Tanggal Indonesia
include("../../../include/tgl-indo.php");

// Fungsi Terbilang
include("../../../include/fungsi-terbilang.php");

// Konfigurasi SEO
include("../../../include/seo.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="<?= $metaDescription; ?>">
	<meta name="keywords" content="<?= $metaKeywords; ?>">
	<meta name="author" content="<?= $metaAuthor; ?>">
	<title>Data Surat Pesanan - SiKuDa BaJa</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../../assets/img/Logo_BPS.png?v=<?= time(); ?>" type="image/x-icon" />

	<!-- Fonts and icons -->
	<script src="../../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Lato:300,400,700,900"]
			},
			custom: {
				"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
				urls: ['../../assets/css/fonts.min.css']
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/atlantis.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="../../assets/css/demo.css">

	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="../../../node_modules/bootstrap-icons/font/bootstrap-icons.css" class="css">

	<!-- My Style Css  -->
	<link rel="stylesheet" href="../../../assets/css/skb.min.css?v=<?= time(); ?>" class="css">
	<link rel="stylesheet" href="../../../assets/css/style.min.css?v=<?= time(); ?>" class="css">
	<link rel="stylesheet" href="../../../assets/css/responsive.min.css?v=<?= time(); ?>" class="css">

	<!-- Style Dashboard -->
	<link rel="stylesheet" href="../../../assets/css/dashboard.min.css?v=<?= time(); ?>" class="css">


</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header bg-skb-1">

				<a href="../../" class="logo text-white">
					<img src="../../assets/img/Logo_BPS.png?v=<?= time(); ?>" alt="SiKuDa BaJa" width="40"> SiKuDa BaJa
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<?php include("../../../include/navbar.php"); ?>
			<!-- End Navbar -->

		</div>

		<!-- Sidebar -->
		<?php include("../../../include/sidebar.php"); ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Data Surat Pesanan</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="../">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Barang & Jasa < 50JT</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Data Surat Pesanan</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<a href="add-spes" class="btn bg-skb-3 text-white btn-round"><i class="fa fa-plus"></i> Buat SPes</a>
										<h4 class="card-title ml-auto"><?php echo "{$resultSPes["jmlhSPes"]}"; ?> Data SPes</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th style="width: 10%">Opsi</th>
													<th>Nomor</th>
													<th>Nama Satker</th>
													<th>Alamat Satker</th>
													<th>Nama Perusahaan</th>
													<th>Alamat Perusahaan</th>
													<th>
														Nama Wakil Penyedia
														<hr>
														Jabatan
													</th>
													<th>Nama Pekerjaan Pengadaan</th>
													<th>Tahun Anggaran</th>
													<th>Nomor DIPA</th>
													<th>Tanggal DIPA</th>
													<th>Program</th>
													<th>Kegiatan</th>
													<th>Output</th>
													<th>Sub Output</th>
													<th>Komponen</th>
													<th>Sub Komponen</th>
													<th>Akun</th>
													<th>Rincian POK</th>
													<th>Waktu Penyelesaian Pekerjaan</th>
													<th>
														Nama Tempat
														<hr>
														Tanggal Surat
													</th>
													<th>Jenis/Spesifikasi</th>
													<th>Satuan</th>
													<th>Vol</th>
													<th>Harga Satuan</th>
													<th>Total Harga</th>
													<th>Jumlah</th>
													<th>PPN</th>
													<th>Total</th>
													<th>Dibulatkan</th>
													<th>Keterangan</th>
													<th>
														Nama PP
														<hr>
														NIP
													</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>#</th>
													<th style="width: 10%">Opsi</th>
													<th>Nomor</th>
													<th>Nama Satker</th>
													<th>Alamat Satker</th>
													<th>Nama Perusahaan</th>
													<th>Alamat Perusahaan</th>
													<th>
														Nama Wakil Penyedia
														<hr>
														Jabatan
													</th>
													<th>Nama Pekerjaan Pengadaan</th>
													<th>Tahun Anggaran</th>
													<th>Nomor DIPA</th>
													<th>Tanggal DIPA</th>
													<th>Program</th>
													<th>Kegiatan</th>
													<th>Output</th>
													<th>Sub Output</th>
													<th>Komponen</th>
													<th>Sub Komponen</th>
													<th>Akun</th>
													<th>Rincian POK</th>
													<th>Waktu Penyelesaian Pekerjaan</th>
													<th>
														Nama Tempat
														<hr>
														Tanggal Surat
													</th>
													<th>Jenis/Spesifikasi</th>
													<th>Satuan</th>
													<th>Vol</th>
													<th>Harga Satuan</th>
													<th>Total Harga</th>
													<th>Jumlah</th>
													<th>PPN</th>
													<th>Total</th>
													<th>Dibulatkan</th>
													<th>Keterangan</th>
													<th>
														Nama PP
														<hr>
														NIP
													</th>
												</tr>
											</tfoot>
											<tbody>
												<?php $noTable = 1; ?>
												<?php foreach ($querySpes as $row) : ?>
													<tr>
														<td><?= $noTable; ?></td>
														<td>
															<div class="form-button-action">
																<div class="dropdown show">
																	<a class="show-opsi bg-skb-3 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		Opsi
																	</a>

																	<div class="dropdown-menu dropdown-menu-opsi" aria-labelledby="dropdownMenuLink">
																		<a class="dropdown-item text-light bg-skb-3" href="edit-spes?id_spes=<?= $row["id"]; ?>"><i class="fa fa-edit"></i> Edit</a>

																		<!-- CEK JIKA USER TIDAK MEMILIH PPN -->
																		<?php if ($row["ppn"] === "0") : ?>
																			<form action="print-word-no-ppn" method="post">
																				<input type="text" hidden name="no_bln_angka" value="<?= substr($row["tgl_surat"], -5, 2); ?>">
																				<input type="text" hidden name="no_tgl" value="<?= substr($row["tgl_surat"], -2, 2); ?>">
																				<input type="text" hidden name="no_kegiatan" value="<?= $row["no_kegiatan"]; ?>">
																				<input type="text" hidden name="no_bln_romawi" value="<?php if ($month01 === substr($row["tgl_surat"], -5, 2)) : ?><?php endif; ?><?php if ($month02 === substr($row["tgl_surat"], -5, 2)) : ?>II<?php endif; ?><?php if ($month03 === substr($row["tgl_surat"], -5, 2)) : ?>III<?php endif; ?><?php if ($month04 === substr($row["tgl_surat"], -5, 2)) : ?>IV<?php endif; ?><?php if ($month05 === substr($row["tgl_surat"], -5, 2)) : ?>V<?php endif; ?><?php if ($month06 === substr($row["tgl_surat"], -5, 2)) : ?>VI<?php endif; ?><?php if ($month07 === substr($row["tgl_surat"], -5, 2)) : ?>VII<?php endif; ?><?php if ($month08 === substr($row["tgl_surat"], -5, 2)) : ?>VIII<?php endif; ?><?php if ($month09 === substr($row["tgl_surat"], -5, 2)) : ?>IX<?php endif; ?><?php if ($month10 === substr($row["tgl_surat"], -5, 2)) : ?>X<?php endif; ?><?php if ($month11 === substr($row["tgl_surat"], -5, 2)) : ?>XI<?php endif; ?><?php if ($month12 === substr($row["tgl_surat"], -5, 2)) : ?>XII<?php endif; ?>">
																				<input type="text" hidden name="no_tahun" value="<?= substr($row["tgl_surat"], 0, 4); ?>">

																				<input type="text" hidden name="nama_satker" value="<?= $row["nama_satker"]; ?>">
																				<input type="text" hidden name="alamat_satker" value="<?= $row["alamat_satker"]; ?>">
																				<input type="text" hidden name="nama_perusahaan" value="<?= $row["nama_perusahaan"]; ?>">
																				<input type="text" hidden name="alamat_perusahaan" value="<?= $row["alamat_perusahaan"]; ?>">
																				<input type="text" hidden name="nama_wakil_penyedia" value="<?= $row["nama_wakil_penyedia"]; ?>">
																				<input type="text" hidden name="jabatan" value="<?= $row["jabatan"]; ?>">
																				<input type="text" hidden name="nama_pekerjaan" value="<?= $row["nama_pekerjaan"]; ?>">
																				<input type="text" hidden name="tahun_anggaran" value="<?= $row["tahun_anggaran"]; ?>">
																				<input type="text" hidden name="nomor_dipa" value="<?= $row["nomor_dipa"]; ?>">
																				<input type="text" hidden name="tgl_bln_thn_dipa" value="<?= tgl_indo(date($row["tgl_bln_thn_dipa"])); ?>">
																				<input type="text" hidden name="program" value="<?= $row["program"]; ?>">
																				<input type="text" hidden name="kegiatan" value="<?= $row["kegiatan"]; ?>">
																				<input type="text" hidden name="output" value="<?= $row["output"]; ?>">
																				<input type="text" hidden name="sub_output" value="<?= $row["sub_output"]; ?>">
																				<input type="text" hidden name="komponen" value="<?= $row["komponen"]; ?>">
																				<input type="text" hidden name="sub_komponen" value="<?= $row["sub_komponen"]; ?>">
																				<input type="text" hidden name="akun" value="<?= $row["akun"]; ?>">
																				<input type="text" hidden name="rincian_pok" value="<?= $row["rincian_pok"]; ?>">
																				<input type="text" hidden name="from_tgl" value="<?= substr($row["from_tgl"], -2, 3); ?>">
																				<input type="text" hidden name="to_tgl" value="<?= tgl_indo(date($row["to_tgl"])); ?>">
																				<input type="text" hidden name="range" value="<?php include("_range.php") ?>">
																				<input type="text" hidden name="range_spelling" value="<?php include("_range_spelling.php") ?>">
																				<input type="text" hidden name="nama_tempat" value="<?= $row["nama_tempat"]; ?>">
																				<input type="text" hidden name="tgl_bln_thn" value="<?= tgl_indo(date($row["tgl_surat"])); ?>">
																				<input type="text" hidden name="jenis_spesifikasi" value="<?= $row["jenis_spesifikasi"]; ?>">
																				<input type="text" hidden name="satuan" value="<?= $row["satuan"]; ?>">
																				<input type="text" hidden name="vol" value="<?= $row["vol"]; ?>">
																				<input type="text" hidden name="harga_satuan" value="<?= number_format($row["harga_satuan"], 0, ',', '.'); ?>">
																				<input type="text" hidden name="total_harga" value="<?= number_format($row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?>">

																				<input type="text" hidden name="total_harga_terbilang" value="<?= terbilang($row["harga_satuan"] * $row["vol"]); ?>">

																				<input type="text" hidden name="keterangan" value="<?= $row["keterangan"]; ?>">

																				<input type="text" hidden name="nama_pp" value="<?= $row["nama_pp"]; ?>">

																				<input type="text" hidden name="nip" value="<?= $row["nip"]; ?>">


																				<button type="submit" value="print" class="btn-opsi bg-skb-1"><i class="fa fa-print"></i> Cetak Word</button>
																			</form>
																		<?php endif; ?>

																		<!-- CEK JIKA USER MEMILIH PPN -->
																		<?php if ($row["ppn"] === "1") : ?>
																			<form action="print-word" method="post">
																				<input type="text" hidden name="no_bln_angka" value="<?= substr($row["tgl_surat"], -5, 2); ?>">
																				<input type="text" hidden name="no_tgl" value="<?= substr($row["tgl_surat"], -2, 2); ?>">
																				<input type="text" hidden name="no_kegiatan" value="<?= $row["no_kegiatan"]; ?>">
																				<input type="text" hidden name="no_bln_romawi" value="<?php if ($month01 === substr($row["tgl_surat"], -5, 2)) : ?><?php endif; ?><?php if ($month02 === substr($row["tgl_surat"], -5, 2)) : ?>II<?php endif; ?><?php if ($month03 === substr($row["tgl_surat"], -5, 2)) : ?>III<?php endif; ?><?php if ($month04 === substr($row["tgl_surat"], -5, 2)) : ?>IV<?php endif; ?><?php if ($month05 === substr($row["tgl_surat"], -5, 2)) : ?>V<?php endif; ?><?php if ($month06 === substr($row["tgl_surat"], -5, 2)) : ?>VI<?php endif; ?><?php if ($month07 === substr($row["tgl_surat"], -5, 2)) : ?>VII<?php endif; ?><?php if ($month08 === substr($row["tgl_surat"], -5, 2)) : ?>VIII<?php endif; ?><?php if ($month09 === substr($row["tgl_surat"], -5, 2)) : ?>IX<?php endif; ?><?php if ($month10 === substr($row["tgl_surat"], -5, 2)) : ?>X<?php endif; ?><?php if ($month11 === substr($row["tgl_surat"], -5, 2)) : ?>XI<?php endif; ?><?php if ($month12 === substr($row["tgl_surat"], -5, 2)) : ?>XII<?php endif; ?>">
																				<input type="text" hidden name="no_tahun" value="<?= substr($row["tgl_surat"], 0, 4); ?>">

																				<input type="text" hidden name="nama_satker" value="<?= $row["nama_satker"]; ?>">
																				<input type="text" hidden name="alamat_satker" value="<?= $row["alamat_satker"]; ?>">
																				<input type="text" hidden name="nama_perusahaan" value="<?= $row["nama_perusahaan"]; ?>">
																				<input type="text" hidden name="alamat_perusahaan" value="<?= $row["alamat_perusahaan"]; ?>">
																				<input type="text" hidden name="nama_wakil_penyedia" value="<?= $row["nama_wakil_penyedia"]; ?>">
																				<input type="text" hidden name="jabatan" value="<?= $row["jabatan"]; ?>">
																				<input type="text" hidden name="nama_pekerjaan" value="<?= $row["nama_pekerjaan"]; ?>">
																				<input type="text" hidden name="tahun_anggaran" value="<?= $row["tahun_anggaran"]; ?>">
																				<input type="text" hidden name="nomor_dipa" value="<?= $row["nomor_dipa"]; ?>">
																				<input type="text" hidden name="tgl_bln_thn_dipa" value="<?= tgl_indo(date($row["tgl_bln_thn_dipa"])); ?>">
																				<input type="text" hidden name="program" value="<?= $row["program"]; ?>">
																				<input type="text" hidden name="kegiatan" value="<?= $row["kegiatan"]; ?>">
																				<input type="text" hidden name="output" value="<?= $row["output"]; ?>">
																				<input type="text" hidden name="sub_output" value="<?= $row["sub_output"]; ?>">
																				<input type="text" hidden name="komponen" value="<?= $row["komponen"]; ?>">
																				<input type="text" hidden name="sub_komponen" value="<?= $row["sub_komponen"]; ?>">
																				<input type="text" hidden name="akun" value="<?= $row["akun"]; ?>">
																				<input type="text" hidden name="rincian_pok" value="<?= $row["rincian_pok"]; ?>">
																				<input type="text" hidden name="from_tgl" value="<?= substr($row["from_tgl"], -2, 3); ?>">
																				<input type="text" hidden name="to_tgl" value="<?= tgl_indo(date($row["to_tgl"])); ?>">
																				<input type="text" hidden name="range" value="<?php include("_range.php") ?>">
																				<input type="text" hidden name="range_spelling" value="<?php include("_range_spelling.php") ?>">
																				<input type="text" hidden name="nama_tempat" value="<?= $row["nama_tempat"]; ?>">
																				<input type="text" hidden name="tgl_bln_thn" value="<?= tgl_indo(date($row["tgl_surat"])); ?>">
																				<input type="text" hidden name="jenis_spesifikasi" value="<?= $row["jenis_spesifikasi"]; ?>">
																				<input type="text" hidden name="satuan" value="<?= $row["satuan"]; ?>">
																				<input type="text" hidden name="vol" value="<?= $row["vol"]; ?>">
																				<input type="text" hidden name="harga_satuan" value="<?= number_format($row["harga_satuan"], 0, ',', '.'); ?>">
																				<input type="text" hidden name="total_harga" value="<?= number_format($row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?>">

																				<input type="text" hidden name="ppn" value="<?= number_format(11 / 100 * $row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?>">
																				<input type="text" hidden name="total" value="<?php
																																											//  Jumlah + PPN
																																											$total = $row["harga_satuan"] * $row["vol"] +
																																												11 / 100 * $row["harga_satuan"] * $row["vol"];
																																											echo number_format($total, 0, ',', '.');
																																											?>">
																				<input type="text" hidden name="rounded" value="<?php include("_rounded.php"); ?>">

																				<input type="text" hidden name="rounded_spelling" value="<?php include("_rounded_spelling.php"); ?>">

																				<input type="text" hidden name="keterangan" value="<?= $row["keterangan"]; ?>">

																				<input type="text" hidden name="nama_pp" value="<?= $row["nama_pp"]; ?>">

																				<input type="text" hidden name="nip" value="<?= $row["nip"]; ?>">


																				<button type="submit" value="print" class="btn-opsi bg-skb-1"><i class="fa fa-print"></i> Cetak Word</button>
																			</form>
																		<?php endif; ?>

																		<a class="dropdown-item text-light bg-skb-6" href="#" data-toggle="modal" data-target="#delete-spes<?= $row["id"]; ?>"><i class=" fa fa-trash"></i> Hapus</a>

																	</div>
																</div>
															</div>
														</td>
														<td>
															<?= substr($row["tgl_surat"], -5, 2); ?>.<?= substr($row["tgl_surat"], -2, 2); ?>/SPes/<?= $row["no_kegiatan"]; ?>/PP/<?php if ($month01 === substr($row["tgl_surat"], -5, 2)) : ?><?php endif; ?><?php if ($month02 === substr($row["tgl_surat"], -5, 2)) : ?>II<?php endif; ?><?php if ($month03 === substr($row["tgl_surat"], -5, 2)) : ?>III<?php endif; ?><?php if ($month04 === substr($row["tgl_surat"], -5, 2)) : ?>IV<?php endif; ?><?php if ($month05 === substr($row["tgl_surat"], -5, 2)) : ?>V<?php endif; ?><?php if ($month06 === substr($row["tgl_surat"], -5, 2)) : ?>VI<?php endif; ?><?php if ($month07 === substr($row["tgl_surat"], -5, 2)) : ?>VII<?php endif; ?><?php if ($month08 === substr($row["tgl_surat"], -5, 2)) : ?>VIII<?php endif; ?><?php if ($month09 === substr($row["tgl_surat"], -5, 2)) : ?>IX<?php endif; ?><?php if ($month10 === substr($row["tgl_surat"], -5, 2)) : ?>X<?php endif; ?><?php if ($month11 === substr($row["tgl_surat"], -5, 2)) : ?>XI<?php endif; ?><?php if ($month12 === substr($row["tgl_surat"], -5, 2)) : ?>XII<?php endif; ?>/<?= substr($row["tgl_surat"], 0, 4); ?>
														</td>
														<td><?= $row["nama_satker"]; ?></td>
														<td><?= $row["alamat_satker"]; ?></td>
														<td><?= $row["nama_perusahaan"]; ?></td>
														<td><?= $row["alamat_perusahaan"]; ?></td>
														<td>
															<?= $row["nama_wakil_penyedia"]; ?>
															<hr>
															<?= $row["jabatan"]; ?>
														</td>
														<td><?= $row["nama_pekerjaan"]; ?></td>
														<td><?= $row["tahun_anggaran"]; ?></td>
														<td><?= $row["nomor_dipa"]; ?></td>
														<td><?= tgl_indo(date($row["tgl_bln_thn_dipa"])); ?></td>
														<td><?= $row["program"]; ?></td>
														<td><?= $row["kegiatan"]; ?></td>
														<td><?= $row["output"]; ?></td>
														<td><?= $row["sub_output"]; ?></td>
														<td><?= $row["komponen"]; ?></td>
														<td><?= $row["sub_komponen"]; ?></td>
														<td><?= $row["akun"]; ?></td>
														<td><?= $row["rincian_pok"]; ?></td>
														<td>
															<?= substr($row["from_tgl"], -2, 3); ?> <strong>sd</strong> <?= tgl_indo(date($row["to_tgl"])); ?>
															<hr>
															<?php include("_range.php"); ?>
															(<?php include("_range_spelling.php"); ?>) hari
														</td>
														<td>
															<?= $row["nama_tempat"]; ?>
															<hr>
															<?= tgl_indo(date($row["tgl_surat"])); ?>
														</td>
														<td><?= $row["jenis_spesifikasi"]; ?></td>
														<td><?= $row["satuan"]; ?></td>
														<td><?= $row["vol"]; ?></td>
														<td>
															Rp. <?= number_format($row["harga_satuan"], 0, ',', '.'); ?>
														</td>
														<td>
															Rp. <?= number_format($row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?>
														</td>
														<td>
															<!-- Mencari sebuah nilai dari 11% -->
															Rp. <?= number_format($row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?>
															<?php if ($row["ppn"] === "0") : ?>
																<hr>
																<?= terbilang($row["harga_satuan"] * $row["vol"]); ?>
															<?php endif; ?>
														</td>

														<!-- PPN -->
														<td>
															<?php if ($row["ppn"] === "0") : ?>
																-
															<?php endif; ?>
															<?php if ($row["ppn"] === "1") : ?>
																<!-- Mencari nilai dari (PPN) -->
																Rp. <?= number_format(11 / 100 * $row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?>
															<?php endif; ?>
														</td>
														<td>
															<?php if ($row["ppn"] === "0") : ?>
																-
															<?php endif; ?>
															<?php if ($row["ppn"] === "1") : ?>
																<!--  Jumlah + PPN -->
																Rp. <?php include("_total.php"); ?>
															<?php endif; ?>
														</td>

														<td>
															<?php if ($row["ppn"] === "0") : ?>
																-
															<?php endif; ?>

															<?php if ($row["ppn"] === "1") : ?>
																Rp. <?php include("_total.php"); ?>
																<hr>
															<?php endif; ?>
															<?php if ($row["ppn"] === "1") : ?>
																<!-- Total Dari Hasil Nilai Yang Dibulatkan (Terbilang) -->
																<?php include("_rounded_spelling.php"); ?> Rupiah
															<?php endif; ?>
														</td>

														<td><?= $row["keterangan"]; ?></td>
														<td>
															<?= $row["nama_pp"]; ?>
															<hr>
															<?= $row["nip"]; ?>
														</td>
													</tr>
													<?php $noTable++; ?>
												<?php endforeach; ?>

											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include("../../../include/footer.php"); ?>
		</div>


		<!-- Logout Modal-->
		<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Siap untuk keluar?</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">Pilih "Keluar" jika anda yakin ingin mengakhiri sesi anda saat ini.</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
						<a class="btn btn-primary" href="../../../auth/logout">Keluar</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Delete spes -->
		<?php foreach ($querySpes as $row) : ?>
			<div class="modal fade" id="delete-spes<?= $row["id"]; ?>" tabindex=" -1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Hapus SPes?</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<table>
								<tr>
									<td>Nomor</td>
									<td>:
										<?= substr($row["tgl_surat"], -5, 2); ?>.<?= substr($row["tgl_surat"], -2, 2); ?>/SPes/<?= $row["no_kegiatan"]; ?>/PP/<?php if ($month01 === substr($row["tgl_surat"], -5, 2)) : ?><?php endif; ?><?php if ($month02 === substr($row["tgl_surat"], -5, 2)) : ?>II<?php endif; ?><?php if ($month03 === substr($row["tgl_surat"], -5, 2)) : ?>III<?php endif; ?><?php if ($month04 === substr($row["tgl_surat"], -5, 2)) : ?>IV<?php endif; ?><?php if ($month05 === substr($row["tgl_surat"], -5, 2)) : ?>V<?php endif; ?><?php if ($month06 === substr($row["tgl_surat"], -5, 2)) : ?>VI<?php endif; ?><?php if ($month07 === substr($row["tgl_surat"], -5, 2)) : ?>VII<?php endif; ?><?php if ($month08 === substr($row["tgl_surat"], -5, 2)) : ?>VIII<?php endif; ?><?php if ($month09 === substr($row["tgl_surat"], -5, 2)) : ?>IX<?php endif; ?><?php if ($month10 === substr($row["tgl_surat"], -5, 2)) : ?>X<?php endif; ?><?php if ($month11 === substr($row["tgl_surat"], -5, 2)) : ?>XI<?php endif; ?><?php if ($month12 === substr($row["tgl_surat"], -5, 2)) : ?>XII<?php endif; ?>/<?= substr($row["tgl_surat"], 0, 4); ?>
									</td>
								</tr>
								<tr>
									<td>Nama Satker</td>
									<td>: <?= $row["nama_satker"]; ?></td>
								</tr>
								<tr>
									<td>Alamat Satker</td>
									<td>: <?= $row["alamat_satker"]; ?></td>
								</tr>
								<tr>
									<td>Nama Perusahaan</td>
									<td>: <?= $row["nama_perusahaan"]; ?></td>
								</tr>
								<tr>
									<td>Alamat Perusahaan</td>
									<td>: <?= $row["alamat_perusahaan"]; ?></td>
								</tr>
								<tr>
									<td>Nama Wakil Penyedia</td>
									<td>: <?= $row["nama_wakil_penyedia"]; ?></td>
								</tr>
								<tr>
									<td>Jabatan</td>
									<td>: <?= $row["jabatan"]; ?></td>
								</tr>
								<tr>
									<td>Nama Pekerjaan Pengadaan</td>
									<td>: <?= $row["nama_pekerjaan"]; ?></td>
								</tr>
								<tr>
									<td>Tahun Anggaran</td>
									<td>: <?= $row["tahun_anggaran"]; ?></td>
								</tr>
								<tr>
									<td>Nomor DIPA</td>
									<td>: <?= $row["nomor_dipa"]; ?></td>
								</tr>
								<tr>
									<td>Tanggal DIPA</td>
									<td>: <?= tgl_indo(date($row["tgl_bln_thn_dipa"])); ?></td>
								</tr>
								<tr>
									<td>Program</td>
									<td>: <?= $row["program"]; ?></td>
								</tr>
								<tr>
									<td>Kegiatan</td>
									<td>: <?= $row["kegiatan"]; ?></td>
								</tr>
								<tr>
									<td>Output</td>
									<td>: <?= $row["output"]; ?></td>
								</tr>
								<tr>
									<td>Sub Output</td>
									<td>: <?= $row["sub_output"]; ?></td>
								</tr>
								<tr>
									<td>Komponen</td>
									<td>: <?= $row["komponen"]; ?></td>
								</tr>
								<tr>
									<td>Sub Komponen</td>
									<td>: <?= $row["sub_komponen"]; ?></td>
								</tr>
								<tr>
									<td>Akun</td>
									<td>: <?= $row["akun"]; ?></td>
								</tr>
								<tr>
									<td>Rincian POK</td>
									<td>: <?= $row["rincian_pok"]; ?></td>
								</tr>
								<tr>
									<td>Waktu Penyelesaian Pekerjaan</td>
									<td>:
										<?= substr($row["from_tgl"], -2, 3); ?> <strong>sd</strong> <?= tgl_indo(date($row["to_tgl"])); ?>
										<br>
										<?php include("_range.php"); ?>
										(<?php include("_range_spelling.php"); ?>) hari
									</td>
								</tr>
								<tr>
									<td>Nama Tempat</td>
									<td>: <?= $row["nama_tempat"]; ?></td>
								<tr>
									<td>Tanggal Surat</td>
									<td>: <?= tgl_indo(date($row["tgl_surat"])); ?></td>
								</tr>
								<tr>
									<td>Jenis/Spesifikasi</td>
									<td>: <?= $row["jenis_spesifikasi"]; ?></td>
								</tr>
								<tr>
									<td>Satuan</td>
									<td>: <?= $row["satuan"]; ?></td>
								</tr>
								<tr>
									<td>Vol</td>
									<td>: <?= $row["vol"]; ?></td>
								</tr>
								<tr>
									<td>Harga Satuan</td>
									<td>: Rp. <?= number_format($row["harga_satuan"], 0, ',', '.'); ?></td>
								</tr>
								<tr>
									<td>Total Harga</td>
									<td>: Rp. <?= number_format($row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?></td>
								</tr>
								<tr>
									<td>Jumlah</td>
									<td>: Rp.
										<!-- Mencari sebuah nilai dari 11% -->
										<?= number_format($row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?>
									</td>
								</tr>

								<?php if ($row["ppn"] === "1") : ?>
									<tr>
										<td>PPN</td>
										<td>: Rp.
											<?= number_format(11 / 100 * $row["harga_satuan"] * $row["vol"], 0, ',', '.'); ?>
										</td>
									</tr>
									<tr>
										<td>Total</td>
										<td>: Rp.
											<?php include("_total.php"); ?>
										</td>
									</tr>
									<tr>
										<td>Dibulatkan</td>
										<td>: Rp.
											<?php include("_rounded.php"); ?>
										</td>
									</tr>
								<?php endif; ?>

								<tr>
									<td>Terbilang</td>
									<td>:
										<?php if ($row["ppn"] === "0") : ?>
											<?= terbilang($row["harga_satuan"] * $row["vol"]); ?>
										<?php endif; ?>

										<?php if ($row["ppn"] === "1") : ?>
											<?php include("_rounded_spelling.php"); ?> Rupiah
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>: <?= $row["keterangan"]; ?></td>
								</tr>
								<tr>
									<td>Nama PP</td>
									<td>: <?= $row["nama_pp"]; ?></td>
								<tr>
									<td>NIP</td>
									<td>: <?= $row["nip"]; ?></td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn bg-skb-3 text-white" data-dismiss="modal">Batal</button>
							<a href="delete-spes?id_del_spes=<?= $row["id"]; ?>" type="button" class="btn bg-skb-1 text-white">Hapus</a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

		<!-- === BOTTOM MENU === -->
		<?php include("../../../include/bottom-menu.php"); ?>


		<!-- BUTTON OTOMATIS CLICK -->
		<button class="btn-onlick" id="clickBtn" hidden></button>


	</div>
	<!--   Core JS Files   -->
	<script src="../../assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="../../assets/js/core/popper.min.js"></script>
	<script src="../../assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="../../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="../../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Chart JS -->
	<script src="../../assets/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="../../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="../../assets/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="../../assets/js/plugin/datatables/datatables.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="../../assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="../../assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

	<!-- Sweet Alert -->
	<script src="../../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="../../assets/js/atlantis.min.js"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="../../assets/js/setting-demo.js"></script>
	<script src="../../assets/js/demo.js"></script>

	<script>
		$(document).ready(function() {
			$('#basic-datatables').DataTable({});

			$('#multi-filter-select').DataTable({
				"pageLength": 5,
				initComplete: function() {
					this.api().columns().every(function() {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
							.appendTo($(column.footer()).empty())
							.on('change', function() {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);

								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});

						column.data().unique().sort().each(function(d, j) {
							select.append('<option value="' + d + '">' + d + '</option>')
						});
					});
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
				]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>


	<!-- === SUCCESS CLICK BUTTON === -->
	<script type="text/javascript">
		$(document).ready(function() {
			$('.btn-onlick').trigger('click');
		})
	</script>

	<?php if (isset($_POST["spes"])) : ?>
		<?php if (addSPes($_POST) > 0) : ?>
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
			<script>
				const clickBtn = document.getElementById('clickBtn')

				clickBtn.onclick = () => {
					Swal.fire({ //displays a pop up with sweetalert
						icon: 'success',
						title: 'Data berhasil ditambahkan!',
						showConfirmButton: false,
						window: 'index',
						timer: 2000
					});
					setTimeout(function() {
						window.location.href = ('spes');
					}, 2000);
				}
			</script>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (isset($_POST["edit_spes"])) : ?>
		<?php if (editSPes($_POST) > 0) : ?>
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
			<script>
				const clickBtn = document.getElementById('clickBtn')

				clickBtn.onclick = () => {
					Swal.fire({ //displays a pop up with sweetalert
						icon: 'success',
						title: 'Data berhasil diubah!',
						showConfirmButton: false,
						window: 'index',
						timer: 2000
					});
					setTimeout(function() {
						window.location.href = ('spes');
					}, 2000);
				}
			</script>
		<?php endif; ?>
	<?php endif; ?>


</body>

</html>