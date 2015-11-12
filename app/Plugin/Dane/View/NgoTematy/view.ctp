<?

echo $this->Element('dataobject/pageBegin');

$this->Combinator->add_libs('css', $this->Less->css('temat', array('plugin' => 'Ngo')));
$this->Combinator->add_libs('js', 'Ngo.temat');

?>

    <div class="col-xs-12 col-md-9 objectMain">
        <div class="object">

            
        </div>        
    </div>   

	<div class="col-xs-12 col-md-3 objectSide">
	    
	
	    <? if (!$object->getData('wykreslony')) {
	        $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
	
	        echo $this->element('tools/krs_odpis', array(
	            'href' => '/dane/krs_podmioty/' . $object->getId() . '/odpis',
	        ));
	
	        $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
	        $this->Combinator->add_libs('js', 'Pisma.pisma-button');
	        echo $this->element('tools/pismo', array(
	            'href' => '/dane/krs_podmioty/' . $object->getId() . '/odpis',
	        ));
	
	        $page = $object->getLayer('page');
	        if (!$page['moderated'])
	            echo $this->element('tools/admin', array(
	                'href' => '/dane/krs_podmioty/' . $object->getId() . '/odpis',
	            ));
	
	    } ?>
	
	    
	</div>
	
	

<?= $this->Element('dataobject/pageEnd'); ?>
