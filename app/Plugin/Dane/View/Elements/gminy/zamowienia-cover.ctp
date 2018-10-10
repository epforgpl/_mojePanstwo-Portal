<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>
<div class="col-md-12">
    <div class="blocks">

		<? if (@$dataBrowser['aggs']['procurements']['announcements']['pln']['histogram']['buckets']) { ?>
            <div class="block block-simple nobg block-size-sm col-xs-12">
                <header>Rozstrzygnięcia zamówień publicznych:</header>
                <section>
                    <?= $this->element('Dane.zamowienia_publiczne', array(
                        'histogram' => $dataBrowser['aggs']['procurements']['announcements']['pln']['histogram']['buckets'],
                        'request' => array(
	                        'gmina_id' => $object->getId(),
                        ),
                        /*
                        'more' => array(
                        	'url' => $object->getUrl() . '/zamowienia?q',
                        	'convert' => true,
                        ),
                        */
                        'aggs' => array(
                        	'stats' => array(),
                        	'wykonawcy' => array(),
                        ),
                        'mode' => 'medium',
                    )); ?>
                </section>
            </div>
        <? } ?>

    </div>
</div>
