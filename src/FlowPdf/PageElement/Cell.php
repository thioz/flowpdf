<?php

namespace FlowPdf\PageElement;

class Cell extends \FlowPdf\PageElement {

	protected $lh = 5;
	protected $txt = '';
	protected $cellstyles = [ 'textcolor' => [0, 0, 0]];

	public function __construct($txt) {
		$this->txt = $txt;
	}
	
	function setCellStyle($attr,$val){
		$this->cellstyles[$attr]=$val;
	}

	function getElements($pdf) {
		$elements = [];
		$lines = $this->getLines();

		$opts=$this->cellstyles;
		$cY = $this->y;
		foreach ($lines as $l => $line) {

			$pattern = '/(\<\/?[a-z0-9\:]+\>)/';
			$parts = preg_split($pattern, $line, -1, PREG_SPLIT_DELIM_CAPTURE);
			$x = $this->x;
			$xset = false;

			foreach ($parts as $i => $part) {

				if (preg_match($pattern, trim($part), $m)) {
					$t = trim($m[0], '<>');
					$this->applyTag($t, $opts);
				}
				else {
					$txt = $part;
					if (($txt) == '') {
						continue;
					}
					$align = isset($opts['align']) ? $opts['align'] : 'L';
//					echo '<pre>';
//					print_r($pdf->GetStringWidth(' '));
//					die();
					$element = ['type' => 'cell',
						'txt' => $part,
						'border' => false,
						'align' => $align,
						'fill' => 0,
						'h' => $this->lh,
						'w' => $this->w,
						'opts' => $opts];
					$element['y'] = $cY;
					if (!$xset) {
						$element['x'] = $this->x;
						$xset = true;
					}
					$elements[] = $element;
				}
			}
			$cY+=$this->lh;
		}
			
			
		return $elements;
	}

	function applyTag($t, &$opts) {
		$add = true;
		if (substr($t, 0, 1) == '/') {
			$add = false;
			$t = substr($t, 1);
		}

		switch ($t) {
			case 'b':
				if ($add) {
					$opts['fontstyle'] = 'B';
				}
				else {
					$opts['fontstyle'] = '';
				}
				break;
			case 'i':
				if ($add) {
					$opts['fontstyle'] = 'I';
				}
				else {
					$opts['fontstyle'] = '';
				}
				break;
		}
	}

	function getLines() {
		$lines = explode("\n", $this->txt);
		return $lines;
	}

}
