<?php

require 'vendor/autoload.php';

ini_set('display_errors', true);
error_reporting(E_ALL);

$pdf = new PdfFlow\Pdf();
$page = $pdf->addPage();

$pxls = new PdfFlow\PageElement\Pixels(__DIR__.'/files/doge.jpg');
$page->addElement($pxls);


$out = $pdf->render();


if (php_sapi_name() == 'cli') {
	$out->Output('F', __DIR__ . '/out/img.pdf');
	die();
}

$out->Output();




//
//$data=[
//	'items' =>[
//		'poep',
//		'in ',
//		'je hoofd',
//	]
//];
//$view = new View();
//echo $view->render(__DIR__.'/files/template.html',$data);