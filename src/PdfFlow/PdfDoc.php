<?php

namespace PdfFlow;

use FPDF;

class PdfDoc extends FPDF {

	protected $cFontSize = 10;
	protected $cFontStyle = '';

	function hasFont($family, $style = '') {
		$family = strtolower($family);
		$style = strtoupper($style);
		$fontkey = $family . $style;
		return isset($this->fonts[$fontkey]);
	}

	function getCurrentFont() {
		return $this->FontFamily;
	}

	function getCurrentFontSize() {
		return $this->cFontSize;
	}

	function getCurrentFontStyle() {
		return $this->FontStyle;
	}

	function setCurrentFont($cFont) {
		$this->FontFamily = $cFont;
	}

	function setCurrentFontSize($cFontSize) {
		$this->cFontSize = $cFontSize;
	}

	function setCurrentFontStyle($cFontStyle) {
		$this->FontStyle = $cFontStyle;
	}

}
