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
	        <section class="content text-typo">
		        
		        <?= $html ?>
		        
	        </section>
        </div>
       
        
    </div><div class="col-md-3">

        <ul class="dataHighlights overflow-auto margin-top-10">    		
	        
	        <div class="objectRender readed objclass msig">
	            <div class="main_content">
                    <div class="content">
                        <span class="object-icon icon-datasets-msig"></span>
                        <div class="object-icon-side  ">
	                        <p class="title margin-top-5">
                                <a href="/dane/msig/<?= $ogloszenie->getData('wydanie_id') ?>">MSiG <?= $ogloszenie->getData('msig.nr') ?>/<?= $ogloszenie->getData('msig.rocznik') ?></a>
                            </p>
                            <p class="meta meta-desc"><?= dataSlownie($ogloszenie->getData('msig.data'), array('relative' => false)) ?></p>
                        </div>
                    </div>
	            </div>
			</div>
	        		        
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
		    		    
        </ul>
        
        
        
        
    </div>
        
</div>

<?
echo $this->Element('dataobject/pageEnd');
