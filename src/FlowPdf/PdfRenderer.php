<?php
namespace FlowPdf;


class PdfRenderer {

	/**
	 *
	 * @var PdfDoc
	 */
	protected $pdf;

	public function __construct($pdf) {
		$this->pdf = $pdf;
	}

	function render($element) {
		if($element instanceof PageElement){
			foreach($element->getElements($this->pdf) as $item){
				$this->renderItem($item);
			}
		}
		return $this->pdf;
	}
	
	function renderItem($item){
		$type = $item['type'];
		$method = 'render' . ucfirst($type);
 
		if (method_exists($this, $method)) {
			call_user_func([$this, $method], $item);
		}
 
		
	}

	function renderCell($options) {
		$options+=[
			'border' => 0,
			'align' => isset($opts['align']) ? $opts['align'] : 'L',
			'fill' => isset($opts['fillcolor']) ? 1 : 0,
			
		];
		$opts=$options['opts'];
		$opts+=[
			'border' => 0,
			'textcolor' => 0,
			'align' => isset($opts['align']) ? $opts['align'] : 'L',
			'fill' => isset($opts['fillcolor']) ? 1 : 0,
		];
		if(isset($options['x'])){
			$this->pdf->SetX($options['x']);
		}
		
		if(isset($options['y'])){

		 
			$this->pdf->SetY($options['y'],false);
		}
	 
		foreach ($opts as $opt => $optval) {
			$method = 'renderOption' . ucfirst($opt);
			if (method_exists($this, $method)) {
				call_user_func([$this, $method], $optval, $opts);
			}
		}

		$cellopts = $options;
		if(!isset($cellopts['w']) || $cellopts['w']==false){
			$cellopts['w'] = $this->pdf->GetStringWidth($cellopts['txt'].' ');
		}
		 
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

		$this->pdf->Image($options['file'],$options['x'],$options['y'],$options['w'],$options['h']);
	}

	function renderOptionFillcolor($val, $opts) {
		if($val instanceof \Closure){
			$val=$val();
		}
		if (!is_array($val)) {
			$val = [$val, $val, $val];
		}
		$this->pdf->SetFillColor($val[0], $val[1], $val[2]);
	}

	function renderOptionFont($val, $opts) {
		$style=isset($opts['fontstyle'])?$opts['fontstyle']:'';
			if(!$this->pdf->hasFont($val,$style)){
			$this->pdf->AddFont($val,$style);
		}
		$this->pdf->SetFont($val,$style);
	}

	function renderOptionFontsize($val, $opts) {

		$this->pdf->SetFontSize($val);
	}

	function renderOptionFontstyle($val, $opts) {
		$fam = $this->pdf->getCurrentFont();
	
			if(!$this->pdf->hasFont($fam,$val)){
	
			$this->pdf->AddFont($fam,$val);
		}
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
		$this->pdf->SetY($val,false);
	}

}

