<?php
//  Jumlah + PPN
$total = $row["harga_satuan"] * $row["vol"] +
  11 / 100 * $row["harga_satuan"] * $row["vol"];
echo number_format($total, 0, ',', '.');
