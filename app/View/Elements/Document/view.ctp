<?php $this->Combinator->add_libs('js', 'toolbar');

$this->Combinator->add_libs('css', $this->Less->css('htmlexDocMain_v2'));
$this->Combinator->add_libs('css', $this->Less->css('htmlexDoc', array('plugin' => 'Dane')));

echo $this->Html->css('http://docs.mojepanstwo.pl/htmlex/' . $document['Document']['id'] . '/' . $document['Document']['id'] . '.css');
?>

<div class="htmlexDoc" data-packages="<?php echo $document['Document']['packages_count']; ?>"
     data-current-package="1"
     data-pages="<?php echo $document['Document']['pages_count']; ?>"
     data-document-id="<?php echo $document['Document']['id'] ?>">
	 
	
    <? echo $this->Element('toolbar', array(
		'document' => $document['Document'],
	)); ?>

    <div class="document">
	    <div class="canvas">
	        <?php echo $document['Package'] ?>
	    </div>
	    <div class="loadMoreDocumentContent <?php if ($document['Document']['packages_count'] > 1) {
	        echo 'show';
	    } else {
	        echo 'hide';
	    } ?>">
	    </div>
    </div>
</div>