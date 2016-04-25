<?

$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('sejm-wyjatki', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $posiedzenie,
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $posiedzenie->getUrl();
?>


<div class="row">
	<div class="col-md-2">
		<div class="dataBrowser">
		<?
			echo $this->Element('Dane.DataBrowser/browser-menu', array(
                'menu' => $_submenu,
                'pills' => isset($pills) ? $pills : null
            ));
        ?>
		</div>
	</div>
	<div class="col-md-10 nocontainer">
		
		<div class="block nobg margin-top-20">
		    <header>Przebieg posiedzenia:</header>
		    <section class="content">
			    
			    <div class="agg agg-Dataobjects">
	                <ul class="dataobjects row margin-top--20">
	                    <? 
		                    foreach( $stenogramy as $doc ) {
	                    ?>
	                    <li class="margin-top-40 col-md-4<? if( $doc['_source']['id'] == $dzien->getId() ) { ?> active<? } ?>">
	                    	<?= $this->Dataobject->render($doc, 'sejm_posiedzenia/dzien'); ?>
	                    </li>
	                    <? } ?>
	                </ul>
	            </div>
			    
		    </section>
		</div>
		
		<div class="block margin-top-20">
			<header>Przebieg posiedzenia w dniu <?= $dzien->getData('tytul') ?></header>
			<section class="content">
				
				<div class="agg agg-Dataobjects">
	                <ul class="dataobjects row debaty">
	                    <? 
		                    foreach( $debaty as $doc ) {
	                    ?>
	                    <li class="">
	                    	<?= $this->Dataobject->render($doc, 'sejm_posiedzenia/dzien-debata'); ?>
	                    </li>
	                    <? } ?>
	                </ul>
	            </div>
				
			</section>
		</div>
	
	</div>
</div>





<?
echo $this->Element('dataobject/pageEnd');