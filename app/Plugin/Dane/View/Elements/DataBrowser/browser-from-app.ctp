
<div class="container">
<div class="objectsPage">
	<?
		$options = array();
		if( isset($title) )
			$options['title'] = $title;
			
		echo $this->Element('Dane.DataBrowser/browser', $options);
	?>
</div>
</div>