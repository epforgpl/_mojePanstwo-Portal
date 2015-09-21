<?
$this->Combinator->add_libs('css', $this->Less->css('view-instytucje-komunikat', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
?>

<?
echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $komunikat,
    'objectOptions' => array(
        'truncate' => 1000,
        'mode' => 'subobject',
        
    ),
));
?>
<div class="row komunikat">
	
	<? if( $html = $komunikat->getLayer('html') ) {?>
	<div class="col-sm-8">
		<div class="text"><?= $html ?></div>	    
	</div>
	<? } ?>
	
	<? if( $komunikat->data['img'] ) { ?>
	<div class="col-sm-4">
        <img class="pull-right" src="http://resources.sejmometr.pl/sejm_komunikaty/img/<?= $komunikat->data['id'] ?>.jpg" />
	</div>
    <? } ?>
    
</div>

<?
echo $this->Element('dataobject/pageEnd');