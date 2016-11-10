<?php

namespace FlowPdf\PageElement;

class Pixels extends \FlowPdf\PageElement {

	protected $lh = 5;
	protected $file;
	protected $cellstyles = [ 'textcolor' => [0, 0, 0]];

	public function __construct($file) {
		$this->file = $file;
	}

	function setCellStyle($attr, $val) {
		$this->cellstyles[$attr] = $val;
	}

	function getElements($pdf) {
		$elements = [];
		$opts = ['w' => $this->w, 'h' => $this->h];

		$img = imagecreatefromjpeg($this->file);
		$w = imagesx($img);
		$h = imagesy($img);
		
		$py = $this->y;
		for ($y = 0; $y < $h; $y++) {
			
			$px = $this->x;
			for ($x = 0; $x < $w; $x++) {
				$pxl = imagecolorat($img, $x, $y);

				$r = ($pxl>> 16) & 255; // 255
				$g= ($pxl>> 8) & 255; // 122
				$b = $pxl & 255; // 15
				$opts=['fillcolor' => [$r,$g,$b]];

				
				$elements[]=['type' =>'cell','txt'=>'','align'=>'L','border'=>0,'fill'=>1,'x'=> $px,'y'=> $py,'w'=>.5,'h'=>.5,'opts'=>$opts];
				$px+=.5;
			}
			$py+=.5;
		}

		return $elements;
	}

}
