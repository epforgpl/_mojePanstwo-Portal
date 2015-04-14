<style>
	.dataBrowser .dataCounter {
		display: none;
	}
</style>
<?
	
	echo $this->Element('Dane.DataBrowser/browser-from-app', array(
		'title' => 'Dane, które obserwujesz:',
	));