<?php
	$this->Combinator->add_libs('js', 'pdfViewer');
	$this->Combinator->add_libs('css', $this->Less->css('pdfViewer'));
?>
<div class="pdfViewer" data-document-id="<?php echo $document['Document']['id'] ?>">
	<div class="loadingPage">
		<div class="spinner_cont">
			<div class="spinner grey">
	            <div class="bounce1"></div>
	            <div class="bounce2"></div>
	            <div class="bounce3"></div>
	        </div>
		</div>
	</div>
</div>