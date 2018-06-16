<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $umowa,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    ),
));
/*
'krakow_contracts.grupa_umow' => null,
'krakow_contracts.data_wprowadzenia' => '2017-08-31',
'krakow_contracts.numer_ksiegowy' => null,
'krakow_contracts.numer_sprawy' => null,
'krakow_contracts.id_pisma' => null,
'krakow_contracts.data_kontroli' => null,
'krakow_contracts.nip' => '8272307768',
'krakow_contracts.id' => '1011',
'krakow_contracts.id_umowy' => '6663818',
'krakow_contracts.st' => 'A',
'krakow_contracts.Uwagi' => null,
'krakow_contracts.do_realizacji' => (int) 387450,
'krakow_contracts.dokumenty' => (int) 0,
'krakow_contracts.kwota' => (int) 387450,
'krakow_contracts.an' => null,
'krakow_contracts.obowiazuje_od' => '2017-11-30',
*/
?>
<style>
	#umowa {
		margin-top: 20px;
	}
	#umowa .dataHighlights {
		padding-top: 10px;
	}
	#umowa .dataHighlights li {
		display: flex;
	}
	#umowa .dataHighlights li ._label {
		float: none;
		order: 1;
		width: 30%;
		text-align: right;
		margin-right: 10px;
	}
	#umowa .dataHighlights li ._value {
		order: 2;
		width: 70%;
		margin: 0;
	}
</style>
<div class="row" id="umowa">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="block block-simple col-xs-12">
            <section class="aggs-init margin-sides-10">
                <ul class="dataHighlights oneline">
                    
                    <? if($umowa->getData('data_zawarcia')) {?>
                    <li class="dataHighlight">
                        <p class="_label">Data zawarcia</p>
                        <p class="_value"><?= dataSlownie($umowa->getData('data_zawarcia')) ?></p>
                    </li>
                    <? } ?>
                    
                    <? if($umowa->getData('kontrahent')) {?>
                    <li class="dataHighlight">
                        <p class="_label">Kontrahent</p>
                        <p class="_value"><?= $umowa->getData('kontrahent') ?><? if($umowa->getData('nip')) {?><br/>NIP: <?= $umowa->getData('nip') ?><? } ?></p>
                    </li>
                    <? } ?>
                    
                   
                    
                    <? if($umowa->getData('kwota_netto')) {?>
                    <li class="dataHighlight">
                        <p class="_label">Kwota netto</p>
                        <p class="_value"><?= _currency($umowa->getData('kwota_netto')) ?></p>
                    </li>
                    <? } ?>
                    
                    <? if($umowa->getData('kwota_uzupelnienia')) {?>
                    <li class="dataHighlight">
                        <p class="_label">Kwota uzupełnienia</p>
                        <p class="_value"><?= _currency($umowa->getData('kwota_uzupelnienia')) ?></p>
                    </li>
                    <? } ?>
                                        
                    <? if($umowa->getData('jednostka_realizująca_rozwiniecie')) {?>
                    <li class="dataHighlight">
                        <p class="_label">Jednostka realizująca</p>
                        <p class="_value"><?= $umowa->getData('jednostka_realizująca_rozwiniecie') ?></p>
                    </li>
                    <? } ?>
                    
                    <? if($umowa->getData('tryb')) {?>
                    <li class="dataHighlight">
                        <p class="_label">Tryb</p>
                        <p class="_value"><?= $umowa->getData('tryb') ?></p>
                    </li>
                    <? } ?>
                    
                    <? if($umowa->getData('wytlumaczenie')) {?>
                    <li class="dataHighlight">
                        <p class="_label">Rodzaj</p>
                        <p class="_value"><?= $umowa->getData('wytlumaczenie') ?></p>
                    </li>
                    <? } ?>
                    
                </ul>
            </section>
        </div>
    </div>
</div>
<?
echo $this->Element('dataobject/pageEnd');
