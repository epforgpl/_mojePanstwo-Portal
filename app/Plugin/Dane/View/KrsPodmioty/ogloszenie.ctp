<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $ogloszenie,
    'objectOptions' => array(
        'bigTitle' => true,
        'fromObject' => true,
    )
));

$data = $ogloszenie->getLayer('data');

$html = preg_replace('/([0-9]{11})/', 'XXX', $data['text']);
$html = str_replace("\n", '</p><p>', $html);
if( $html )
	$html = '<p>' . $html . '</p>';

?>


<div class="row">

    <div class="object col-md-9">
        
        <div class="block margin-top-25">
	        <section class="content">
		        
		        <?= $html ?>
		        
	        </section>
        </div>
        
    </div><div class="col-md-3">

        <ul class="dataHighlights overflow-auto margin-top-10">
    		
    		<? if( @$data['sad'] ) {?>
    		<li class="dataHighlight col-xs-12">
	            <p class="_label">Sąd</p>
	            <p class="_value"><?= $data['sad'] ?></p>
	        </li>
	        <? } ?>
	        
	        <? if( @$data['symbol'] ) {?>
	        <li class="dataHighlight col-xs-12">
	            <p class="_label">Symbol sprawy</p>
	            <p class="_value"><?= $data['symbol'] ?></p>
	        </li>
	        <? } ?>
    		
    		<li class="dataHighlight col-xs-12">
	            <p class="_label">Wydanie MSiG</p>
	            <p class="_value"><a href="/dane/msig/<?= $ogloszenie->getData('wydanie_id') ?>"><?= dataSlownie( $ogloszenie->getData('msig.data') ); ?></a></p>
	        </li>
	        
	        <li class="dataHighlight col-xs-12">
	            <p class="_label">Dział MSiG</p>
	            <p class="_value"><a href="/dane/msig/<?= $ogloszenie->getData('wydanie_id') ?>/dzialy/<?= $ogloszenie->getData('dzial_id') ?>"><?= $ogloszenie->getData('msig_dzialy.nazwa') ?></a></p>
	        </li>
	        
	        <li class="dataHighlight col-xs-12">
	            <p class="_label">Pozycja</p>
	            <p class="_value"><?= $ogloszenie->getData('pozycja') ?></p>
	        </li>
		    		    
        </ul>
        
    </div>
        
</div>

<?
echo $this->Element('dataobject/pageEnd');
