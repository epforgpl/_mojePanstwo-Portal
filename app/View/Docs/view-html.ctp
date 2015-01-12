<style>
	.container {
		width: 100% !important;
		padding: 0 !important;
		margin: 0 !important;
	}
	.htmlexDoc #docsToolbar {display: none;}
</style>
<?
	
	$this->Combinator->add_libs('css', $this->Less->css('htmlexDocMain_v2'));
	$this->Combinator->add_libs('css', $this->Less->css('doc'));

	echo $this->Element('Dane.docsBrowser/doc', array(
	    'document' => $document,
	    'documentPackage' => $documentPackage,
	));