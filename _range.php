<?php
$fromTgl = strtotime($row["from_tgl"]);
$toTgl = strtotime($row["to_tgl"]);
$difference = $toTgl - $fromTgl;
$TimeDifference = $difference / 60 / 60 / 24 + 1;
echo $TimeDifference;
