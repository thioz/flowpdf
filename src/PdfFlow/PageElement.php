<?php

namespace PdfFlow;

class PageElement {

	protected $x = 0;
	protected $y = 0;
	protected $h = 0;
	protected $w = 0;
	protected $lh = 8;
	protected $defaultOpts = [];

	function getLh() {
		return $this->lh;
	}

	function setLh($lh) {
		$this->lh = $lh;
	}

	function getX() {
		return $this->x;
	}

	function getY() {
		return $this->y;
	}

	function getH() {
		return $this->h;
	}

	function setPosition($x, $y) {
		$this->x = $x;
		$this->y = $y;
	}

	function setX($x) {
		$this->x = $x;
	}

	function setY($y) {
		$this->y = $y;
	}

	function setH($h) {
		$this->h = $h;
	}

	function setW($h) {
		$this->w = $h;
	}

}
