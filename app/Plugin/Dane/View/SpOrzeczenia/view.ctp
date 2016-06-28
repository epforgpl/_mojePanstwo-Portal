<?php $this->Combinator->add_libs('css', $this->Less->css('view-sporzeczenia', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>

<div class="col-md-10 objectMain">
    <div class="object">
        <?php foreach ($object->getLayer('bloki') as $blok) { ?>
            <div class="block">
                <?php if (isset($blok['tytul']) && $blok['tytul']) { ?>
                    <header><?php echo $blok['tytul']; ?></header>
                <?php } ?>
                <section class="content<? if( (stripos($blok['tytul'], 'wyrok')===0) || (stripos($blok['tytul'], 'postanowienie')===0) ) {?> text-center<? } ?>">
	                <?php echo $blok['wartosc']; ?>
	            </section>
            </div>
        <?php } ?>
    </div>
</div>
<div class="col-md-2">
	
	<? /*
	<ul class="dataHighlights overflow-auto margin-top-0">
		<li class="dataHighlight col-xs-12">
            <p class="_label">Status</p>
            <p class="_value"></p>
        </li>
	</ul>
	*/ ?>
	
	<div class="margin-top-20">
    	<p class="_src text-left"><a href="http://orzeczenia.ms.gov.pl/details/<?= $object->getData('str_ident') ?>" target="_blank"><span class="glyphicon glyphicon-link"></span> Źródło</a></p>
	</div>
</div>
    
<?= $this->Element('dataobject/pageEnd'); ?>