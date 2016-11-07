<?php

require 'vendor/autoload.php';
require 'src/Invoice.php';
ini_set('display_errors', true);
error_reporting(E_ALL);

$in=new Invoice();
$in->setAddress(['rob','eregns2']);
$in->setLines([
	['title'=>'poep','amount'=>200]
]);
$out=$in->make();
$out->Output();

