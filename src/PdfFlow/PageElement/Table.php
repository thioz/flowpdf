<?php

namespace PdfFlow\PageElement;

class Table extends \PdfFlow\PageElement {

	protected $columns = [];
	protected $headerstyles = [ 'fillcolor' => [128, 128, 128], 'textcolor' => [255, 255, 255]];
	protected $cellstyles = [ 'textcolor' => [0, 0, 0], 'drawcolor' => 100];
	protected $rows = [];
	protected $renderHeader = true;

	function setCellStyle($attr, $val) {
		$this->cellstyles[$attr] = $val;
	}

	function setHeaderStyle($attr, $val) {
		$this->headerstyles[$attr] = $val;
	}

	function setRenderHeader($f) {
		$this->renderHeader = $f;
	}

	function getElements($pdf) {
		$elements = [];
		$cx = $this->x;
		$posY = $this->y;
		if (is_string($posY)) {

			if (substr($posY, 0, 1) == '-') {
				$y = -1 * intval(substr($posY, 1));
			}
			if (substr($posY, 0, 1) == '+') {
				$y = intval(substr($posY, 1));
			}
			$y = $pdf->GetY() + $y;
		}
		else {
			$y = $posY;
		
			
		}
		$this->setColumnWidths($pdf);
		$cols = $this->columns;
		if ($this->renderHeader) {
			foreach ($cols as $i => $col) {

				$opts = $col['opts'];
				$opts+=$this->headerstyles;

				$border = isset($opts['border']) ? $opts['border'] : 'BTLR';
				$align = isset($opts['align']) ? $opts['align'] : 'L';
				$element = ['type' => 'cell', 'y' => $y, 'x' => $cx, 'border' => $border,
					'fill' => 1,
					'align' => $align,
					'h' => $this->lh, 'w' => $opts['w'], 'txt' => $cols[$i]['txt'], 'opts' => $opts];

				$elements[] = $element;

				$cx+=$opts['w'];
				$this->h+=$element['h'];
			}
		
			$y+=$element['h'];
		}

		foreach ($this->rows as $row) {
			$cx = $this->x;
			$h = $this->lh;

			foreach ($cols as $i => $col) {
				$opts = array_merge($col['opts'],$row['opts']);
				$opts+=$this->cellstyles;
				$txt = isset($row['data'][$i])?$row['data'][$i]:'';
				$border = isset($opts['border']) ? $opts['border'] : 'BLR';
				$align = isset($opts['align']) ? $opts['align'] : 'L';
				$element = [

					'type' => 'cell', 'y' => $y, 'x' => $cx, 'w' => $opts['w'], 'txt' => $txt, 'h' => $h,
					'border' => $border,
					'align' => $align,
					'fill' => isset($opts['fillcolor']) ? 1 : 0,
					'opts' => $opts
				];
				$elements[] = $element;

				$cx+= $opts['w'];
			}
			$y+=$h;
			$this->h+=$element['h'];
		}
		return $elements;
	}

	function setColumnWidths($pdf) {
		foreach ($this->columns as $i => $col) {

			if (!isset($col['opts']['w'])) {
				$maxw = -1000;
				foreach ($this->rows as $row) {
					$cw = $pdf->GetStringWidth($row[$i]);
					if ($cw > $maxw) {
						$maxw = $cw;
					}
				}
				$this->columns[$i]['opts']['w'] = $maxw;
			}
		}
	}

	function addColumn($label, $id, $w = false, $opts = []) {
		if (!isset($opts['w'])) {
			$opts['w'] = $w;
		}
		$col = ['opts' => $opts, 'txt' => $label];
		$this->columns[$id] = $col;
	}

	function addRow($data,$opts=[]) {
		$this->rows[] = ['data'=>$data,'opts'=>$opts];
	}

	function setRows($data) {
		$this->rows = $data;
	}

	function rowCount() {
		return count($this->rows);
	}

}
