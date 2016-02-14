<?
	$accessDict = array(
	    'prywatna',
	    'publiczna'
	);
?>
<div class="container">
        

	<header class="collection-header objectRender kolekcje">
	
	    <div class="overflow-auto">
	
	        <div class="content pull-left">
	            <span class="object-icon icon-datasets-kolekcje"></span>
	
	            <div class="object-icon-side">
	                <h1 data-url="">
                        <div contenteditable="true" data-url="/start/collections/setDocumentName/<?= $item->getId() ?>"
                             class="form-control h1-editable"><?= $item->getData('nazwa') ?></div>
	                </h1>
	            </div>
	        </div>
			
			
	
	    </div>
	</header>
	
	<ul class="collection-meta">
	    <li>
	        
	            Kolekcja <?= $accessDict[$item->getData('is_public')] ?>
	    </li>
	    <? if($item->getData('object_id')) { ?>
	        <li>Redakcja: <a href="#">#<?= $item->getData('object_id') ?></a></li>
	    <? } ?>
	</ul>
	
</div>