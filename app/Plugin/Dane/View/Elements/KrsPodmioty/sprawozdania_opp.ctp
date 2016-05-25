<?
	
	$menu = array(
		'items' => array(),
	);
	
	foreach( $dataBrowser['aggs']['sprawozdania']['top']['hits']['hits'] as $h ) {
		
		$menu['items'][] = array(
			'id' => $h['_source']['id'],
			'label' => 'Rok ' . $h['_source']['data']['sprawozdania_opp']['rocznik'],
			'href' => $h['_source']['id'],
		);
		
	}
		
?>
<div class="row">
	<div class="col-md-2">
		<div class="dataBrowser">
		<?
			echo $this->Element('Dane.DataBrowser/browser-menu', array(
                'menu' => $menu,
            ));
        ?>
		</div>
	</div>
	<div class="col-md-10 nocontainer">


	</div>
</div>

