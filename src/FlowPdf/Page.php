<?php

namespace FlowPdf;

class Page {

	protected $elements = [];

	public function __construct() {
		
	}

	function addElement($element) {
		$this->elements[] = $element;
	}

	function elements() {
		return $this->elements;
	}

}
