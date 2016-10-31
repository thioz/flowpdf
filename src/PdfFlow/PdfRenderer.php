<?php
namespace PdfFlow;

class PdfRenderer {

	/**
	 *
	 * @var FPDF
	 */
	protected $pdf;

	public function __construct($pdf) {
		$this->pdf = $pdf;
	}

	function render($element) {
		$type = $element['type'];
		$method = 'render' . ucfirst($type);
		if (method_exists($this, $method)) {
			call_user_func([$this, $method], $element);
		}
	}

	function renderCell($options) {
		$options+=[
			'border' => 0,
			'textcolor' => 0,
			'align' => isset($options['align']) ? $options['align'] : 'L',
			'fill' => isset($options['fillcolor']) ? 1 : 0,
			'h' => isset($options['h']) ? $options['h'] : $this->pdf->getFontSize(),
			'w' => isset($options['w']) ? $options['w'] : 10,
		];

		foreach ($options as $opt => $optval) {
			$method = 'renderOption' . ucfirst($opt);
			if (method_exists($this, $method)) {
				call_user_func([$this, $method], $optval, $options);
			}
		}

		$cellopts = $options;
		$this->pdf->Cell($cellopts['w'], $cellopts['h'], $cellopts['txt'], $cellopts['border'], 0, $cellopts['align'], $cellopts['fill']);
	}

	function renderImage($options) {
		$options+=[
		];

		foreach ($options as $opt => $optval) {
			$method = 'renderOption' . ucfirst($opt);
			if (method_exists($this, $method)) {
				call_user_func([$this, $method], $optval, $options);
			}
		}

		$this->pdf->Image($options['file']);
	}

	function renderOptionFillcolor($val, $opts) {
		$this->pdf->SetFillColor($val[0], $val[1], $val[2]);
	}

	function renderOptionFont($val, $opts) {

		$this->pdf->SetFont($val);
	}

	function renderOptionFontsize($val, $opts) {

		$this->pdf->SetFontSize($val);
	}

	function renderOptionFontstyle($val, $opts) {
		$fam = isset($opts['font']) ? $opts['font'] : 'Arial';
		$this->pdf->SetFont($fam, $val);
	}

	function renderOptionTextcolor($val, $opts) {
		if (!is_array($val)) {
			$val = [$val, $val, $val];
		}
		$this->pdf->SetTextColor($val[0], $val[1], $val[2]);
	}

	function renderOptionDrawcolor($val, $opts) {
		if (!is_array($val)) {
			$val = [$val, $val, $val];
		}
		$this->pdf->SetDrawColor($val[0], $val[1], $val[2]);
	}

	function renderOptionX($val, $opts) {
		$this->pdf->SetX($val);
	}

	function renderOptionY($val, $opts) {
		$this->pdf->SetY($val, false);
	}

}

class EzPdf extends FPDF {

	protected $prevFontSize;

	function getFont() {
		return $this->FontFamily;
	}

	function getFontSize() {
		return $this->FontSize;
	}

	function getPrevFontSize() {
		return $this->prevFontSize;
	}

	public function SetFontSize($size) {
		$this->prevFontSize = $this->FontSizePt;
		parent::SetFontSize($size);
	}

	public function SetFont($family, $style = '', $size = 0) {

		if ($size) {

			$this->prevFontSize = $size;
		}
		parent::SetFont($family, $style, $size);
	}

}