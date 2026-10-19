<?php

global $smarty;

$clsTourpackage = new TourPackage();
$listTourpackage = $clsTourpackage->getAll();

$tour_package_id = $_GET["tour_package_id"] ?? 0;
