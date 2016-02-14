<?

	$this->Combinator->add_libs('js', 'Start.collections-view.js');
	$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));
	$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
	
	/* tinymce */
	echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));

	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
	
?>


<div class="app-content-wrap">
    <div class="objectsPage">		
		
		<?= $this->element('collections/header') ?>
		
		<?= $this->element('Dane.DataBrowser/browser-content', array(
			'displayAggs' => false,
			'app_chapters' => false,
			'forceHideAggs' => true,
			'noResultsPhrase' => 'Kolekcja jest pusta',
			'paginatorPhrases' => array('dokument', 'dokumenty', 'dokumentów'),
			'manage' => true,
		)); ?>
		
    </div>
</div>