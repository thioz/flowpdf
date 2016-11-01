<?php

$txt='Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus egestas, enim ultricies ullamcorper scelerisque, dolor nisi convallis velit, in aliquet erat lorem in nisl. Phasellus et lectus eros. Proin non vehicula nibh. Proin ipsum dui, auctor a mattis pharetra, convallis eu sem. Ut in posuere eros. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris lorem mi, eleifend pharetra libero ut, ornare imperdiet eros. Duis semper rhoncus sapien sed sagittis. Morbi mattis quis nisi vitae finibus. Pellentesque dui eros, rhoncus at pellentesque ac, ullamcorper ac quam. Maecenas in bibendum mi. Aenean ornare nulla vitae velit sollicitudin ultricies. Nunc libero arcu, cursus sit amet nisl vitae, sollicitudin vehicula risus. Nam dapibus et justo ac luctus. Aenean rhoncus, erat convallis maximus cursus, nisl velit commodo quam, id viverra nibh erat at tortor. Etiam consequat finibus placerat. Nullam ut mattis ante, at pellentesque ipsum. Phasellus congue, velit in consequat feugiat, ex nulla tempor felis, id suscipit metus tellus at odio. Ut faucibus suscipit nibh vitae vulputate. In gravida justo in magna consectetur volutpat. Donec id ligula id mauris ultrices gravida. Mauris iaculis leo erat, et commodo dolor lacinia in. Vivamus malesuada purus in auctor vulputate. Fusce imperdiet nulla nec nibh ullamcorper, at laoreet tellus interdum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris pharetra sapien a fringilla accumsan. Duis ut ipsum neque. Suspendisse porttitor placerat facilisis. Morbi auctor, augue aliquet pulvinar fermentum, eros sapien pellentesque eros, vitae lacinia ipsum elit sed enim. Cras in elit quis augue pharetra rutrum semper ac orci. Aliquam eu augue eget elit hendrerit tempus vitae vel risus. Aliquam at aliquet erat, non dapibus eros. Nullam vestibulum et est eget tincidunt. Cras sit amet odio eu ligula accumsan rhoncus sit amet in quam. Maecenas tincidunt ultricies dolor, vitae convallis ligula ullamcorper vitae. In condimentum aliquet hendrerit. Phasellus eleifend felis tellus, ut feugiat turpis fermentum at. Nullam malesuada libero mauris, in dignissim odio blandit viverra. Etiam porta ex eu euismod tincidunt. Duis ultricies elit in facilisis iaculis., vitae convallis ligula ullamcorper vitae. In condimentum aliquet hendrerit. Phasellus eleifend felis tellus, ut feugiat turpis fermentum at. Nullam malesuada libero mauris, in dignissim odio blandit viverra. Etiam porta ex eu euismod tincidunt. Duis ultricies elit in facilisis iaculis.';

require 'vendor/autoload.php';



ini_set('display_errors', true);
error_reporting(E_ALL);

$pdf = new PdfFlow\Pdf();
$page = $pdf->addPage();

$cols=new \PdfFlow\PageElement\TextColumns($txt);
$cols->setNumColumns(3);
$cols->setLh(6);
$cols->setX(10);
$cols->setY(40);
$cols->setColWidth(50);
$cols->setColHeight(null);
$page->addElement($cols);
$img=new \PdfFlow\PageElement\Image(__DIR__.'/files/pic.jpg');
$img->setX(5);
$img->setY(5);
$img->setW(50);
$page->addElement($img);
$out = $pdf->render();


if (php_sapi_name() == 'cli') {
	$out->Output('F', __DIR__ . '/out/flow2.pdf');
	die();
}

$out->Output();
