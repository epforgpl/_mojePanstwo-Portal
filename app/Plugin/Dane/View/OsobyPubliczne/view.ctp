<?
echo $this->Element('dataobject/pageBegin');

echo $this->Html->script('Dane.d3/d3', array('block' => 'scriptBlock'));

$this->Combinator->add_libs('css', $this->Less->css('view-krsosoby', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krs-graph', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-osoby_publiczne', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krsosoby');
$this->Combinator->add_libs('js', 'graph-krs');
?>
	
	<div class="row margin-top--20 margin-sides-0 margin-bottom-20">
		<div class="col-sm-12">
		
			<ul class="dataHighlights row">
		        
		        <li class="dataHighlight col-md-2">
		            <p class="_label">Data urodzenia</p>
	                <p class="_value"><?= dataSlownie($object->getData('data_urodzenia')) ?></p>
	            </li>
		        
		        <li class="dataHighlight col-md-2">
		            <p class="_label">Miejsce urodzenia</p>
	                <p class="_value"><?= $object->getData('miejsce_urodzenia') ?></p>
	            </li>		        
		                    
	        </ul>
			
		</div>
	</div>
	
    <div class="col-md-9 objectMain krsOsoby">
        <div class="object">
            
			<? if( isset($wiki_txt) ) {?>
			
				<div class="block">
		            <header>Biografia</header>
		            <section class="content">
			            <p><?= $wiki_txt ?></p>
			            <p><a href="#">Więcej &raquo;</a></p>
		            </section>
		        </div>
				
			<? } ?>
			
            <? if( $nauka = $object->getLayer('naukapolska') ) { $nauka = $nauka['fields']; ?>
            
	            <? if( isset($nauka['Specjalności']) ) {?>
	            <div class="block">
		            <header>Specjalności</header>
		            <section class="content">
			            <?= $nauka['Specjalności'] ?>
		            </section>
		        </div>
	            <? } ?>
	            
	            <? if( isset($nauka['Miejsca pracy']) ) {?>
	            <div class="block">
		            <header>Miejsca pracy</header>
		            <section class="content naukapolska">
			            <?= $nauka['Miejsca pracy'] ?>
		            </section>
		        </div>
	            <? } ?>
	            
	            <? if( isset($nauka['Członkostwo']) ) {?>
	            <div class="block">
		            <header>Członkostwo</header>
		            <section class="content naukapolska">
			            <?= $nauka['Członkostwo'] ?>
		            </section>
		        </div>
	            <? } ?>
	            
	            <? if( isset($nauka['Uzyskany tytuł profesora']) ) {?>
	            <div class="block">
		            <header>Uzyskany tytuł profesora</header>
		            <section class="content naukapolska">
			            <?= $nauka['Uzyskany tytuł profesora'] ?>
		            </section>
		        </div>
	            <? } ?>
	            
	            <? if( isset($nauka['Rozprawa doktorska']) ) {?>
	            <div class="block">
		            <header>Rozprawa doktorska</header>
		            <section class="content naukapolska">
			            <?= $nauka['Rozprawa doktorska'] ?>
		            </section>
		        </div>
	            <? } ?>
	            
	            <? if( isset($nauka['Rozprawa habilitacyjna']) ) {?>
	            <div class="block">
		            <header>Rozprawa habilitacyjna</header>
		            <section class="content naukapolska">
			            <?= $nauka['Rozprawa habilitacyjna'] ?>
		            </section>
		        </div>
	            <? } ?>
	            
	            <? if( isset($nauka['Promotor prac doktorskich']) ) {?>
	            <div class="block">
		            <header>Promotor prac doktorskich</header>
		            <section class="content naukapolska">
			            <?= $nauka['Promotor prac doktorskich'] ?>
		            </section>
		        </div>
	            <? } ?>
	            
	            <? if( isset($nauka['Publikacje']) && ($publikacje = trim(strip_tags( $nauka['Publikacje'] ))) ) {?>
	            <div class="block">
		            <header>Publikacje</header>
		            <section class="content naukapolska">
			            <?= $nauka['Publikacje'] ?>
		            </section>
		        </div>
	            <? } ?>
            	            
            <? } ?>
            
            
            <? if( isset($krs_osoba) ) {?>
            <div class="block-group col-xs-12 col-xs-12">
                <? if ($organizacje = $krs_osoba->getLayer('organizacje')) {
				    echo $this->Element('Dane.objects/krs_osoby/organizacje', array(
				        'organizacje' => $organizacje,
				    ));
				} ?>
            </div>
            <? } ?>
            
        </div>
    </div>
    <div class="col-md-3">
	    
	    <div class="block">
            <header>Narzędzia wyszukiwania</header>
            <section class="content">
	            <ul>
		            <? if($object->getData('wiki_id')) {?><li><a target="_blank" href="https://www.wikiwand.com/pl/<?= $object->getData('wiki_id') ?>">Wikipedia &raquo;</a></li><? } ?>
		            
		            <? if($nauka = $object->getLayer('naukapolska')) {?><li><a target="_blank" href="http://nauka-polska.pl/dhtml/raporty/ludzieNauki?rtype=opis&objectId=<?= $nauka['sid'] ?>&lang=pl">Nauka Polska &raquo;</a></li><? } ?>
		            
		            <li><a target="_blank" href="/krs/osoby?q=<?= $object->getData('nazwisko') ?> <?= $object->getData('imie') ?>">KRS &raquo;</a></li>
		            
		            <li><a target="_blank" href="http://www.google.com/search?q=<?= $object->getData('imie') ?> <?= $object->getData('nazwisko') ?>">Google Search &raquo;</a></li>

		            <li><a target="_blank" href="http://www.google.com/search?q=<?= $object->getData('imie') ?> <?= $object->getData('nazwisko') ?>">Facebook &raquo;</a></li>
		            
		            <li><a target="_blank" href="http://www.google.com/search?q=<?= $object->getData('imie') ?> <?= $object->getData('nazwisko') ?>">Twitter &raquo;</a></li>

	            </ul>
            </section>
        </div>
	    
    </div>


<? if( $object->getData('krs_id') ) {?>
</div></div>

    <div class="powiazania block block-simple col-md-12 margin-bottom-30">
        <section id="connectionGraph" data-id="<?php echo $object->getData('krs_id') ?>" data-url="krs_osoby">
            <div class="spinner grey">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </section>
        <div class="detailInfoWrapper"></div>
    </div>

<div><div>
<? } ?>

<?= $this->Element('dataobject/pageEnd'); ?>
