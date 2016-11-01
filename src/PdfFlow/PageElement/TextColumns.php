<?php

namespace PdfFlow\PageElement;

class TextColumns extends \PdfFlow\PageElement {

	protected $columns = [];
	protected $numcols = 1;
	protected $colw = 40;
	protected $colspacing=null;
	protected $colh = 100;
	protected $txt = '';
	protected $cellstyles = [ 'textcolor' => [0, 0, 0]];

	public function __construct($txt) {
		$this->txt = $txt;
	}

	function setCellStyle($attr, $val) {
		$this->cellstyles[$attr] = $val;
	}

	function setNumColumns($n) {
		$this->numcols = $n;
	}

	function setColWidth($w) {
		$this->colw = $w;
	}
	function setColSpacing($w) {
		$this->colspacing = $w;
	}
	function setColHeight($h) {
		$this->colh = $h;
	}

	function getElements($pdf) {
		$elements = [];
		if($this->colh===null){
			$this->colh= 250 - $this->y;
		}
		if($this->colspacing===null){
			$w=210-$this->x;
			$w-=$this->numcols*$this->colw;
			$this->colspacing = $w/($this->numcols);
			
		}
		$y = $this->y;
		$cols = [];
		$words = explode(' ', $this->txt);
		$sent = '';
		$cols[0] = ['txts' => []];
		$h = 0;
		$c = 0;
		foreach ($words as $w) {
			$sw = $pdf->GetStringWidth($sent . ' ' . $w);
			if ($sw > $this->colw) {
				$cols[$c]['txts'][]=$sent;
				$h+=$this->lh;
				if ($h > $this->colh) {
					$c++;
					$h = 0;
					$cols[$c] = ['txts' => []];
				}

				$sent = $w;
			}
			else {
				$sent.=' ' . $w;
			}
		}
		if($sent!=''){
			$cols[$c]['txts'][]=$sent;
		}
		
		$cx = $this->x;
		foreach ($cols as $i => $col) {
			$opts = [];
			$opts+=$this->cellstyles;
			$y = $this->y;
			foreach ($col['txts'] as $txt) {
				$y+=$this->lh;
				$element = [

					'type' => 'cell', 'y' => $y, 'x' => $cx, 'txt' => $txt, 'h' => $this->lh,
					'border' => 0,
					'fill' => 0,
					'align' => 'L',
					'opts' => $opts
				];
				$elements[] = $element;
			}
			$cx+=$this->colspacing + $this->colw;
		}

		return $elements;
	}

	

}
