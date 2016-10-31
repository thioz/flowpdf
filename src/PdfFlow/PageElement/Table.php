<?php

namespace PdfFlow\PageElement;

class Table
{
	protected $columns = [];
	protected $headerstyles = [ 'fillcolor' => [234, 4, 77], ];
	protected $cellstyles = [ ];
	protected $rows = [];
	protected $lh = 8;
	
	function getElements($pdf) {
		$elements = [];
		$cx = $this->x;
		$y = $this->y;
		$cols = $this->columns;

		foreach ($cols as $i => $col) {
			
			if (!isset($col['align'])) {
				$cols[$i]['align'] = "L";
			}
			if (!isset($col['w'])) {
				$maxw = -1000;
				foreach ($this->rows as $row) {
					$cw = $pdf->GetStringWidth($row[$i]);
					if ($cw > $maxw) {
						$maxw = $cw;
					}
				}
				$cols[$i]['w'] = $maxw;
			}
			$element=['type' => 'cell', 'border' => 'TLR', 'textcolor' => [255, 255, 255], 'y' => $y, 'x' => $cx, 'h' => $this->lh, 'w' => $cols[$i]['w'], 'txt' => $cols[$i]['label']];
			$element=  array_merge($element, $this->parseStyles($this->headerstyles));
			$elements[] =$element;
			
			$cx+=$cols[$i]['w'];
			$this->h+=$element['h'];
		}
		$y+=$element['h'];			
		foreach ($this->rows as $row) {
			$cx = $this->x;
			$h=$this->lh;
			
			$ccol = 0;
			foreach ($cols as $i => $col) {
				$txt = $row[$i];
				if($txt instanceof \Template\ItemBuilder){
					$txt->setX($cx);
					$txt->setY($y);
					foreach($txt->getElements($pdf) as $el){
						$elements[]=$el;
					}
					$h=$txt->getH();
					$row[$i]='';
					
				}
				$cx+=$cols[$i]['w'];
			}
			
			$cx = $this->x;
			foreach ($cols as $i => $col) {
				$txt = $row[$i];
				$element = [

					'type' => 'cell', 'y' => $y, 'x' => $cx, 'w' => $cols[$i]['w'], 'txt' => $txt, 'h' => $h, 'drawcolor' => 100,
					'align' => $cols[$i]['align'],
					'border' => $ccol < count($cols) - 1 ? 'BL' : 'LBR',
				];
				$element=  array_merge($element,$this->cellstyles);
				$elements[]=$element;
				
				$cx+=$cols[$i]['w'];
				$ccol+=1;
			}
			$y+=$h;
			$this->h+=$element['h'];
		}
		return $elements;
	}

	function addColumn($label, $id, $w = false, $opts = []) {
		$this->columns[$id] = array_merge(['label' => $label, 'w' => $w], $opts);
	}

	function addRow($data) {
		$this->rows[] = $data;
	}
	
}