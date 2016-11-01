<?php

require 'vendor/autoload.php';



ini_set('display_errors', true);
error_reporting(E_ALL);

$pdf = new PdfFlow\Pdf();
$page = $pdf->addPage();
$page->addElement(new \PdfFlow\PageElement\Image(__DIR__ . '/files/logo.jpg'));
$cell=new PdfFlow\PageElement\Cell("lalalalalalall dijdjffhjdhf");
$cell->setCellStyle('font', 'ubuntu');
$cell->setX(30);
$cell->setY(50);
$cell->setCellStyle('fontstyle', 'B');
$cell->setCellStyle('fontsize', 12);
$cell->setLh(6);
$page->addElement($cell);

$table=new \PdfFlow\PageElement\Table();
$table->addColumn('Id', 'id',20);
$table->addColumn(' ', 'title',100);
$table->addColumn('Amount', 'amount',50,['align'=>'R']);
$table->addRow(['id'=>323,'title'=>'Hier komt een titel','amount'=>'23']);
$table->addRow(['id'=>323,'title'=>'Hier komt een titel','amount'=>chr(128) . ' 10,-']);
$table->addRow(['id'=>323,'title'=>'Hier komt een titel','amount'=>chr(128) . ' 10,-']);
$table->addRow(['id'=>'Sub','amount'=>chr(128) . ' 2310,-'],['fontstyle'=>'B']);
$table->addRow(['id'=>'tax','amount'=>chr(128) . ' 233,-'],['fontstyle'=>'B']);
$table->addRow(['id'=>'Total','amount'=>chr(128) . ' 233,-'],['fontstyle'=>'B','fontsize'=>14]);
$table->setHeaderStyle('fontsize', 12);
$table->setHeaderStyle('border', 'B');
$table->setCellStyle('border', 'T');
$table->setHeaderStyle('fillcolor', 255);
$table->setHeaderStyle('textcolor', 0);
$table->setCellStyle('fontsize', 9);
$table->setCellStyle('fontstyle', '');
$cc=3;
//$table->setCellStyle('fillcolor', function() use ($cc){
//	static $i;
//	static $c;
//	$c++;
//	if($c>$cc){
//		$c=0;
//		$i++;
//	}
//	if($i%2==0){
//		return 120;
//	}
//	return 255;
//});
$table->setX(20);
$table->setY(80);
$page->addElement($table);

//$table2=new \PdfFlow\PageElement\Table();
//$table2->setRenderHeader(false);
//$table2->addColumn('Id', 'txt',120);
//$table2->addColumn('Amount', 'amount',50,['align'=>'R']);
//$table2->addRow(['txt'=>'Sub','amount'=>100]);
//$table2->setCellStyle('border', 'T');
//$table2->setCellStyle('fontsize', 9);
//$table2->setCellStyle('fontstyle', '');
//$table2->setX(20);
//$table2->setY('+8');
//$page->addElement($table2);
//$cell=new PdfFlow\PageElement\Cell("dikke footer");
//$cell->setX(10);
//$cell->setW(200);
//$cell->setY(250);
//$cell->setCellStyle('fontsize', 7);
//
//$cell->setCellStyle('align','C');
//$cell->setLh(6);
//$page->addElement($cell);

$out = $pdf->render();


if (php_sapi_name() == 'cli') {
	$out->Output('F', __DIR__ . '/out/poepsdsd.pdf');
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