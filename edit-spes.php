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

	// QUERY TABLE USER (LEVEL PP & PPK)
	$resultUsersLevelPP = query("SELECT * FROM tb_users WHERE level = 'pp' ");
	$resultUsersLevelPPK = query("SELECT * FROM tb_users WHERE level = 'ppk' ");
}

// ============================================
// query table Spes berdasarkan URL [0]
// ============================================
if (isset($_GET["id_spes"])) {
	$idSpes = $_GET["id_spes"];
	$queryIdSpes = query("SELECT * FROM tb_spes WHERE id = '$idSpes' ")[0];
}

// check empty account
if (empty($rowSession["id"])) {
	header("Location:../../../auth/logout");
	exit;
}



// query table satker
$resultSatker = query("SELECT * FROM tb_satker");

// === PAGU ANGGARAN ===
// query table program
$resultProgram = query("SELECT * FROM tb_pa_program");

// query table kegiatan
$resultKegiatan = query("SELECT * FROM tb_pa_kegiatan");

// query table output
$resultOutput = query("SELECT * FROM tb_pa_output");

// query table sub output
$resultSubOutput = query("SELECT * FROM tb_pa_sub_output");

// query table komponen
$resultKomponen = query("SELECT * FROM tb_pa_komponen");

// query table sub komponen
$resultSubKomponen = query("SELECT * FROM tb_pa_sub_komponen");

// query table akun
$resultAkun = query("SELECT * FROM tb_pa_akun");

// CEK LEVEL
include("../../../include/check-level.php");

if (($rowSession["level"] === $levelPPK)) {
	header("Location:../../");
	exit;
}

// SET DATE
date_default_timezone_set('Asia/Makassar');

// === RUMUS MEMBUAT HARI, TANGGAL, BULAN, TAHUN (MENJADI TEXT) ===
$day = date("l");
$tglTxt = date("d");
$blnTxt = date("m");
$thnText = date("Y");

// tanggal, bulan, tahun
$tbh = date("d M Y");

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
	<title>Edit Surat Pesanan - SiKuDa BaJa</title>
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

	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="../../../node_modules/bootstrap-icons/font/bootstrap-icons.css" class="css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="../../assets/css/demo.css">

	<!-- My Style Css -->
	<link rel="stylesheet" href="../../../assets/css/style.min.css?v=<?= time(); ?>" class="css">
	<link rel="stylesheet" href="../../../assets/css/skb.min.css?v=<?= time(); ?>" class="css">
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
						<h4 class="page-title">Edit Surat Pesanan</h4>
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
								<a href="spes">Data Surat Pesanan</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Edit SPes</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card card-form">
								<form action="spes" method="post" class="user" enctype="multipart/form-data">
									<input type="text" hidden name="id" value="<?= $queryIdSpes["id"]; ?>">
									<input type="hidden" name="id_user" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["id"]))))))))); ?>">
									<br>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<label for="tgl_surat"><i class="bi bi-calendar2-date-fill"></i> Tanggal Surat</label>
											<input id="tgl_surat" name="tgl_surat" type="date" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["tgl_surat"]; ?>">
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="no_kegiatan" name="no_kegiatan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["no_kegiatan"]; ?>">
											<label for="no_kegiatan" class="placeholder"><i class="bi bi-grid-1x2-fill"></i> Kegiatan</label>
										</div>
									</div>


									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input list="nama_satker" name="nama_satker" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('nama_satker harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off" value="<?= $queryIdSpes["nama_satker"]; ?>">
											<label for="nama_satker" class="placeholder"><i class="bi bi-pin-map-fill"></i> Nama Satker</label>
											<datalist id="nama_satker">
												<?php foreach ($resultSatker as $row) : ?>
													<option value="<?= $row["uraian_satker"]; ?>">
														<?= $row["kode_satker"]; ?>
													</option>
												<?php endforeach; ?>
											</datalist>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="alamat_satker" name="alamat_satker" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["alamat_satker"]; ?>">
											<label for="alamat_satker" class="placeholder"><i class="bi bi-geo-alt-fill"></i> Alamat Satker</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="nama_perusahaan" name="nama_perusahaan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["nama_perusahaan"]; ?>">
											<label for="nama_perusahaan" class="placeholder"><i class="bi bi-building"></i> Nama Perusahaan</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="alamat_perusahaan" name="alamat_perusahaan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["alamat_perusahaan"]; ?>">
											<label for="alamat_perusahaan" class="placeholder"><i class="bi bi-geo-alt-fill"></i> Alamat Perusahaan</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="nama_wakil_penyedia" name="nama_wakil_penyedia" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["nama_wakil_penyedia"]; ?>">
											<label for="nama_wakil_penyedia" class="placeholder"><i class="bi bi-person-fill"></i> Nama Wakil Penyedia</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="jabatan" name="jabatan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["jabatan"]; ?>">
											<label for="jabatan" class="placeholder"><i class="bi bi-award-fill"></i> Jabatan</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="nama_pekerjaan" name="nama_pekerjaan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["nama_pekerjaan"]; ?>">
											<label for="nama_pekerjaan" class="placeholder"><i class="bi bi-person-video3"></i> Nama Pekerjaan Pengadaan</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="tahun_anggaran" name="tahun_anggaran" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["tahun_anggaran"]; ?>">
											<label for="tahun_anggaran" class="placeholder"><i class="bi bi-calendar-event-fill"></i> Tahun Anggaran</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="nomor_dipa" name="nomor_dipa" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["nomor_dipa"]; ?>">
											<label for="nomor_dipa" class="placeholder"><i class="bi bi-2-square-fill"></i> Nomor DIPA</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<label for="tgl_bln_thn_dipa"><i class="bi bi-card-text"></i> Tanggal DIPA</label>
											<input id="tgl_bln_thn_dipa" name="tgl_bln_thn_dipa" type="date" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["tgl_bln_thn_dipa"]; ?>">
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input list="program" name="program" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Program harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off" value="<?= $queryIdSpes["program"]; ?>">
											<label for="program" class="placeholder"><i class="bi bi-folder-fill mb-2"></i> Program</label>
											<datalist id="program">
												<?php foreach ($resultProgram as $row) : ?>
													<option value="(<?= $row["kode"]; ?>) <?= $row["uraian"]; ?>">
														<?= $row["kode"]; ?>
													</option>
												<?php endforeach; ?>
											</datalist>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input list="kegiatan" name="kegiatan" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Kegiatan harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off" value="<?= $queryIdSpes["kegiatan"]; ?>">
											<label for="kegiatan" class="placeholder"><i class="bi bi-folder-fill mb-2"></i> Kegiatan</label>
											<datalist id="kegiatan">
												<?php foreach ($resultKegiatan as $row) : ?>
													<option value="(<?= $row["kode"]; ?>) <?= $row["uraian"]; ?>">
														<?= $row["kode"]; ?>
													</option>
												<?php endforeach; ?>
											</datalist>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input list="output" name="output" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Output harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off" value="<?= $queryIdSpes["output"]; ?>">
											<label for="output" class="placeholder"><i class="bi bi-box-arrow-up mb-2"></i> Output</label>
											<datalist id="output">
												<?php foreach ($resultOutput as $row) : ?>
													<option value="(<?= $row["kode"]; ?>) <?= $row["uraian"]; ?>">
														<?= $row["kode"]; ?>
													</option>
												<?php endforeach; ?>
											</datalist>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input list="sub_output" name="sub_output" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Sub Output harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off" value="<?= $queryIdSpes["sub_output"]; ?>">
											<label for="sub_output" class="placeholder"><i class="bi bi-box-arrow-up-right mb-2"></i> Sub Output</label>
											<datalist id="sub_output">
												<?php foreach ($resultSubOutput as $row) : ?>
													<option value="(<?= $row["kode"]; ?>) <?= $row["uraian"]; ?>">
														<?= $row["kode"]; ?>
													</option>
												<?php endforeach; ?>
											</datalist>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input list="komponen" name="komponen" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Komponen harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off" value="<?= $queryIdSpes["komponen"]; ?>">
											<label for="komponen" class="placeholder"><i class="bi bi-gear-fill mb-2"></i> Komponen</label>
											<datalist id="komponen">
												<?php foreach ($resultKomponen as $row) : ?>
													<option value="(<?= $row["kode"]; ?>) <?= $row["uraian"]; ?>">
														<?= $row["kode"]; ?>
													</option>
												<?php endforeach; ?>
											</datalist>
										</div>
									</div>


									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input list="sub_komponen" name="sub_komponen" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Sub Komponen harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off" value="<?= $queryIdSpes["sub_output"]; ?>">
											<label for="sub_komponen" class="placeholder"><i class="bi bi-gear mb-2"></i> Sub Komponen</label>
											<datalist id="sub_komponen">
												<?php foreach ($resultSubKomponen as $row) : ?>
													<option value="(<?= $row["kode"]; ?>) <?= $row["uraian"]; ?>">
														<?= $row["kode"]; ?>
													</option>
												<?php endforeach; ?>
											</datalist>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input list="akun" name="akun" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Akun harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off" value="<?= $queryIdSpes["akun"]; ?>">
											<label for="akun" class="placeholder"><i class="bi bi-person-lines-fill mb-2"></i> Akun</label>
											<datalist id="akun">
												<?php foreach ($resultAkun as $row) : ?>
													<option value="(<?= $row["kode"]; ?>) <?= $row["uraian"]; ?>">
														<?= $row["kode"]; ?>
													</option>
												<?php endforeach; ?>
											</datalist>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="rincian_pok" name="rincian_pok" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["rincian_pok"]; ?>">
											<label for="rincian_pok" class="placeholder"><i class="bi bi-card-list"></i> Rincian POK</label>
										</div>
									</div>


									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<label for="tgl_bln_thn"><i class="bi bi-calendar2-date-fill"></i> Waktu Penyelesaian (Tanggal sd Tanggal)</label>
											<br>
											<input id="tgl_bln_thn" name="from_tgl" type="date" class=" input-border-bottom" required="" title="Dari Tanggal" value="<?= $queryIdSpes["from_tgl"]; ?>">
											<labe><strong>S/D</strong></labe>
											<input id="tgl_bln_thn" name="to_tgl" type="date" class=" input-border-bottom" required="" title="Sampai Tanggal" value="<?= $queryIdSpes["to_tgl"]; ?>">
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="nama_tempat" name="nama_tempat" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["nama_tempat"]; ?>">
											<label for="nama_tempat" class="placeholder"><i class="bi bi-card-list"></i> Nama Tempat</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="jenis_spesifikasi" name="jenis_spesifikasi" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["jenis_spesifikasi"]; ?>">
											<label for="jenis_spesifikasi" class="placeholder"><i class="bi bi-list-columns-reverse"></i> Jenis/Spesifikasi</label>
										</div>
									</div>


									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="satuan" name="satuan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["satuan"]; ?>">
											<label for="satuan" class="placeholder"><i class="bi bi-box2"></i> Satuan</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="vol" name="vol" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["vol"]; ?>">
											<label for="vol" class="placeholder"><i class="bi bi-hdd"></i> VOL</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="jmlh_penawaran" name="harga_satuan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["harga_satuan"]; ?>">
											<label for="jmlh_penawaran" class="placeholder"><i class="bi bi-cash-stack"></i> Harga Satuan</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<br>
											<select id="ppn" name="ppn" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('PPN harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off">
												<option value="<?= $queryIdSpes["ppn"]; ?>">
													<?php if ($queryIdSpes["ppn"] === "1") : ?>
														Tambahkan PPN
													<?php endif; ?>
													<?php if ($queryIdSpes["ppn"] === "0") : ?>
														Tidak Ditambahkan PPN
													<?php endif; ?>
												</option>
												<option value="1">Tambahkan PPN</option>
												<option value="0">Tidak Ditambahkan PPN</option>
											</select>
											<label for="ppn" class="placeholder"><i class="bi bi-percent mb-2"></i> PILIH PPN</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<input id="keterangan" name="keterangan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSpes["keterangan"]; ?>">
											<label for="keterangan" class="placeholder"><i class="bi bi-card-list"></i> Keterangan</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<select name="nama_pp" id="nama_pp" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Bidang ini harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off">
												<option value="<?= $queryIdSpes["nama_pp"]; ?>"><?= $queryIdSpes["nama_pp"]; ?></option>
												<?php foreach ($resultUsersLevelPP as $row) : ?>
													<option value="<?= $row["first_name"]; ?> <?= $row["last_name"]; ?>">
														<?= $row["first_name"]; ?> <?= $row["last_name"]; ?>
													</option>
												<?php endforeach; ?>
											</select>
											<label for="nama_pp" class="placeholder"><i class="bi bi-person-fill"></i> Nama PP</label>
										</div>
									</div>

									<div class="form-add">
										<div class="form-group form-floating-label col-sm-6 mb-2 mb-sm-0">
											<select name="nip" id="nip" class="form-control input-border-bottom" required oninvalid="this.setCustomValidity('Bidang ini harus diisi!')" oninput="setCustomValidity('')" placeholder=" " autocomplete="off">
												<option value="<?= $queryIdSpes["nip"]; ?>">
													<?= $queryIdSpes["nip"]; ?>
												</option>
												<?php foreach ($resultUsersLevelPP as $row) : ?>
													<option value="<?= $row["nip"]; ?>">
														<?= $row["nip"]; ?>
													</option>
												<?php endforeach; ?>
											</select>
											<label for="nama_ppk" class="placeholder"><i class="bi bi-person-fill"></i> NIP <sup>PP</sup></label>
										</div>
									</div>

									<input type="hidden" name="tgl_buat" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($tbh))))))))); ?>">

									<div class="card-body row">
										<div class="form-group btn-form form-floating-label col-sm-6 mb-3 mb-sm-0">
											<button type="submit" name="edit_spes" class="btn bg-skb-3">SIMPAN <i class="fa fa-save"></i></button>
											<button type="reset" class="btn bg-skb-1">RESET <i class="fa fa-times"></i></button>
											<a href="javascript:window.history.go(-1);" class="btn bg-skb-6">BATAL</a>
										</div>
									</div>

								</form>
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

		<!-- === BOTTOM MENU === -->
		<?php include("../../../include/bottom-menu.php"); ?>


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

	<!-- Format Rupiah -->
	<script src="../../../assets/js/rupiah-format.js"></script>

</body>

</html>