<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>
<div class="col-md-9">

    <div class="blocks">
        
		<? if (@$dataBrowser['aggs']['all']['zamowienia_publiczne_dokumenty']['dni']['buckets']) { ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header>Rozstrzygnięcia zamówień publicznych:</header>
                <section>
                    <?= $this->element('Dane.zamowienia_publiczne', array(
                        'histogram' => $dataBrowser['aggs']['all']['zamowienia_publiczne_dokumenty']['dni']['buckets'],
                        'request' => array(
	                        'zamawiajacy_id' => $object->getId(),
                        ),
                        'more' => $object->getUrl() . '/zamowienia',
                        'aggs' => array(
                        	'stats' => array(), 
                        	'dokumenty' => array(), 
                        ),
                    )); ?>
                </section>
            </div>
        <? } ?>

    </div>

</div>
<div class="col-md-3">
		
	
    <?
    $adres = trim( $object->getData('ulica') . ' ' . $object->getData('dom_numer') . ' ' . $object->getData('mieszkanie_numer') . ' ' . $object->getData('miejscowosc') );
	
    if ($adres) {
        echo $this->element('Dane.adres', array(
            'adres' => $adres . ', Polska',
        ));
    }
    
    $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));

    $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
    $this->Combinator->add_libs('js', 'Pisma.pisma-button');
    echo $this->element('tools/pismo', array());

    $page = $object->getLayer('page');
    if (!$page['moderated'])
        echo $this->element('tools/admin', array());
    
    ?>

</div>