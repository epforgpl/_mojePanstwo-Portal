<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>
<div class="col-md-9">
	
    <div class="blocks">
		
		<?
			if( $adres = $object->getData('adres_str') ) {
				$adres = str_ireplace('ul.', '<br/>ul.', $adres) . ', Polska';
				echo $this->element('Dane.adres', array(
					'adres' => $adres,
				));
			}
		?>
						
        <? if (@$dataBrowser['aggs']['all']['prawo']['top']['hits']['hits']) { ?>
            <div class="block block-default block-size-sm col-xs-12">
                <header>Najnowsze akty prawne:</header>

                <section class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits'] as $doc) { ?>
                                        <li>
                                            <?
                                            echo $this->Dataobject->render($doc, 'default');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                                <div class="buttons">
                                    <a href="#" class="btn btn-primary btn-xs">Zobacz więcej</a>
                                </div>
                            <? } ?>

                        </div>
                    </div>

                </section>
            </div>
        <? } ?>


        <? if (@$dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits']) { ?>
            <div class="block block-default block-size-sm col-xs-12">
                <header>Najnowsze pozycje w dzienniku urzędowym:</header>

                <section class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits'] as $doc) { ?>
                                        <li>
                                            <?
                                            echo $this->Dataobject->render($doc, 'default');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                                <div class="buttons">
                                    <a href="#" class="btn btn-primary btn-xs">Zobacz więcej</a>
                                </div>
                            <? } ?>

                        </div>
                    </div>

                </section>
            </div>
        <? } ?>


        <? if (@$dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits']) { ?>
            <div class="block block-default block-size-sm col-xs-12">
                <header>Zamówienia publiczne:</header>
				<section>
	                <?= $this->element('Dane.zamowienia_publiczne', array(
	                	'url' => $object->getUrl() . '/mp_zamowienia.json',
	                )); ?>
				</section>
            </div>
        <? } ?>

    </div>

</div>