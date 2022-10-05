<?php
// Bulatkan Hasil Penjumlahan antara (Jumlah + PPN) nilai < 999999 
if ($total < 999999) {
  $jumlahBulatan =  substr(number_format($total, 0, ',', '.'), 0, 3);
  $jumlahBulatanTerbilang =  $jumlahBulatan . "." . "000";

  // clear simbol TITIK(.)
  $jumlahBulatanTerbilang = preg_replace("/[^0-9]/", "", $jumlahBulatanTerbilang);
  echo terbilang($jumlahBulatanTerbilang);
}

// // Bulatkan Hasil Penjumlahan antara (Jumlah + PPN) nilai < 9999999 
if ($total > 1000000 and  $total < 9999999) {
  $jumlahBulatan =  substr(number_format($total, 0, ',', '.'), 0, 5);
  $jumlahBulatanTerbilang = $jumlahBulatan . "." . "000";

  // clear simbol TITIK(.)
  $jumlahBulatanTerbilang = preg_replace("/[^0-9]/", "", $jumlahBulatanTerbilang);
  echo terbilang($jumlahBulatanTerbilang);
}

// Bulatkan Hasil Penjumlahan antara (Jumlah + PPN) > 1000000
if ($total > 10000000) {
  $jumlahBulatan =  substr(number_format($total, 0, ',', '.'), 0, 6);
  $jumlahBulatanTerbilang = $jumlahBulatan . "." . "000";

  // clear simbol TITIK(.)
  $jumlahBulatanTerbilang = preg_replace("/[^0-9]/", "", $jumlahBulatanTerbilang);
  echo terbilang($jumlahBulatanTerbilang);
}
