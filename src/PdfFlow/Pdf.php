<?php
namespace PdfFlow;



class Pdf {
	protected $pages=[];
	protected $renderer;
	public function __construct() {
		
	}
	
	function addPage($page=null){
		if(!$page){
			$page = new Page();
			
		}
		$this->pages[] = $page;
		return $page;
	}
	
	function newPdf(){
		$pdf=new PdfDoc();
		$pdf->SetFont('arial', '', 10);
		return $pdf;
	}
	
	function render(){
		$pdf=$this->newPdf();
		$renderer=new PdfRenderer($pdf);
		foreach($this->pages as $page){
			$pdf->AddPage();
			foreach($page->elements() as $element){
				$renderer->render($element);
			}
		}
		return $pdf;
	}
	
}