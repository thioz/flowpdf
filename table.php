<?php

require 'vendor/autoload.php';



ini_set('display_errors', true);
error_reporting(E_ALL);

//$table = [
//
//	'columns' => [
//		[ 'header' => 'ID', 'w' => 20, 'pdf' => ['fillcolor' => [234, 4, 77], 'type' => 'cell']],
//		[ 'header' => 'title'],
//		[ 'header' => 'amount', 'w' => 30],
//	],
//	'rows' => [
//		[
//			'cells' => [
//				['content' => '43'],
//				['content' => 'Boeie met die toelie'],
//				['content' => '44.34'],
//			]
//		],
//		[
//			'cells' => [
//				['content' => '2'],
//				['content' => 'Vage shit allemaal hier in huis'],
//				['content' => '4.34'],
//			]
//		],
//		[
//			'cells' => [
//				['content' => '323'],
//				['content' => '2fdfdfal hier in huis'],
//				['content' => '32.34'],
//			]
//		],
//	],
//];
//
//$elements = [
//];
//
$pdf = new \EzPdf();
$pdf->SetMargins(0, 0);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);
$pdf->AddFont('ubuntu');

$cfont = 'Arial';
$render = new PdfRenderer($pdf);
//$y = 20;
//$lh = 8;
//$cp = 10;
//$cx = 20;
//$x = 20;
//$cols = $table['columns'];
//foreach ($cols as $i => $col) {
//	if (!isset($col['w'])) {
//		$maxw = -1000;
//		foreach ($table['rows'] as $row) {
//			$cw = $pdf->GetStringWidth($row['cells'][$i]['content']);
//			if ($cw > $maxw) {
//				$maxw = $cw;
//			}
//		}
//		$cols[$i]['w'] = $maxw + 2 * $cp;
//	}
//	$elements[] = [
//		'type' => 'cell', 'fillcolor' => [234, 4, 77], 'textcolor' => [255, 255, 255], 'y' => $y, 'x' => $cx, 'h' => $lh, 'w' => $cols[$i]['w'], 'txt' => $cols[$i]['header']
//	];
//	$cx+=$cols[$i]['w'];
//}
//foreach ($table['rows'] as $row) {
//	$cx = $x;
//	$y+=$lh;
//	foreach ($row['cells'] as $i => $cell) {
//		$elements[] = [
//			'type' => 'cell', 'y' => $y, 'x' => $cx, 'w' => $cols[$i]['w'], 'txt' => $cell['content'], 'h' => $lh, 'drawcolor' => 100,
//		];
//		$cx+=$cols[$i]['w'];
//	}
//}

	$lb = new Template\Builder\ListBuilder();
	$lb->addItem('poep');
	$lb->addItem('in');
	$lb->addItem('js');
	$lb->setX(15)->setY(30);

	$tb = new \Template\Builder\TableBuilder();
	$tb->addColumn('ID', 'id', 20);
	$tb->addColumn('title', 'title', 120);
	$tb->addColumn('Amount', 'amount', 40, ['align' => 'R']);
	$tb->addRow([
		'id' => 2,
		'title' => 'oets',
		'amount' => 23.23,
	]);
	$tb->addRow([
		'id' => 23,
		'title' => 'heooeoeooe',
		'amount' =>   ' 66.23',
	]);
	$tb->addRow([
		'id' => '23',
		'title' => 'heooeoeooe',
		'amount' =>  ' 12.23',
	]);
	$tb->setX(6)->setY(70);

	$elements = $tb->getElements($pdf);
	$elements[] = [
		'type' => 'image', 'file' => __DIR__ . '/files/logo.png', 'x' => 0, 'y' => 0
	];
	$elements[] = [
		'type' => 'cell', 'txt' => 'lalal alala l' . $pdf->GetPageHeight(), 'x' => 0, 'y' => 270, 'fontsize' => 7, 'align' => 'C', 'w' => 210, 'h' => 5
	];




foreach ($elements as $element) {
	$render->render($element);
}


if (php_sapi_name() == 'cli') {
	$pdf->Output('F', __DIR__ . '/out/poepsdsd.pdf');
	die();
}

$pdf->Output();




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