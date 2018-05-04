<?php
	$this->Combinator->add_libs('js', 'pdfViewer');
	$this->Combinator->add_libs('css', $this->Less->css('pdfViewer'));
?>
<div class="pdfViewer" data-document-id="<?php echo $document['Document']['id'] ?>"></div>