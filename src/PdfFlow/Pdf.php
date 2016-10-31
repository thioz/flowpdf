<?php
namespace PdfFlow;

class Pdf extends \FPDF{
	protected $prevFontSize;
	
	function getFont(){
		return $this->FontFamily;
	}

	function getFontSize(){
		return $this->FontSize;
	}

	function getPrevFontSize(){
		return $this->prevFontSize;
	}
	
	public function SetFontSize($size) {
		$this->prevFontSize = $this->FontSizePt;
		parent::SetFontSize($size);
	}
	
	public function SetFont($family, $style = '', $size = 0) {
 
		if($size){
 
			$this->prevFontSize=$size;
		}
		parent::SetFont($family, $style, $size);
	}
}