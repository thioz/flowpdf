<?php

namespace PdfFlow\PageElement;

class Image extends \PdfFlow\PageElement {

	protected $lh = 5;
	protected $file;
	protected $cellstyles = [ 'textcolor' => [0, 0, 0]];

	public function __construct($file) {
		$this->file=$file;
	}
	
	function setCellStyle($attr,$val){
		$this->cellstyles[$attr]=$val;
	}

	function getElements($pdf) {
		$elements = [];
		$opts=['w'=>$this->w,'h'=>$this->h];
		$element = ['type' => 'image', 'y' => $this->y, 'x' => $this->x, 
				
				
				  'h' => $opts['h'],
				  'w' => $opts['w'],
			'file' => $this->file, 'opts' => $opts];
		$elements[] =$element;

		return $elements;
	}

	

}
