<?php

class Invoice {

	protected $lines = [];
	protected $adresslines = [];
	protected $senderlines = [];

	public function __construct() {
		;
	}

	function setAddress($lines) {
		$this->adresslines = $lines;
	}

	function setSender($lines) {
		$this->senderlines = $lines;
	}

	function setLines($lines) {
		$this->lines = $lines;
	}

	function make() {
		$pdf = new PdfFlow\Pdf();
		$page = $pdf->addPage();
		$cell = new PdfFlow\PageElement\Cell(implode("\n", $this->adresslines));
		$cell->setCellStyle('font', 'ubuntu');
		$cell->setPosition(20, 40);

		$cell->setCellStyle('fontstyle', 'B');
		$cell->setCellStyle('fontsize', 12);
		$cell->setLh(6);
		$page->addElement($cell);

		$table = new \PdfFlow\PageElement\Table();
		$table->addColumn(' ', 'title', 120);
		$table->addColumn('Amount', 'amount', 50, ['align' => 'R']);
		foreach ($this->lines as $line) {
			$table->addRow(['title' => $line['title'], 'amount' => chr(128) . $line['amount']]);
		}
		$table->addRow(['title' => 'total', 'amount' => chr(128) . '94394'], ['fontstyle' => 'B']);
		$table->setHeaderStyle('fontstyle', '');
		$table->setHeaderStyle('fillcolor', 255);
		$table->setHeaderStyle('textcolor', 0);
		$table->setHeaderStyle('fontsize', 12);
		$table->setHeaderStyle('border', 'B');
		$table->setCellStyle('border', 'T');
		$table->setPosition(10, 60);
		$page->addElement($table);
		$out = $pdf->render();
		return $out;
	}

}
