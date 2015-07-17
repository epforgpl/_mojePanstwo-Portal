<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$odpisy = $object->getLayer('odpisy');

?>
<div class="container">
    <div class="krsPodmioty">
        
        <div class="row">
	        <div class="col-xs-10 col-xs-offset-1">
        
			    <p class="row margin-top-30">Część danych na profilu Twojej organizacji pochodzi z odpisów, pobieranych z <a href="https://ems.ms.gov.pl/krs/wyszukiwaniepodmiotu?t:lb=t" target="_blank"> Centralnej Informacji Krajowego Rejestru Sądowego</a>. Te dane są stale aktualizowane, jednak jeśli są one nieaktualne, możesz poprosić o pobranie nowego odpisu i zaktualizowanie informacji.</p>
			    
			    <div class="row">
			    
			        <div class="block block-simple col-md-12">
				        <header>
				            <div class="sm">Pobrane odpisy</div>
				        </header>
				
				        <section class="content">		        
					        
					        <div class="row">
						        <div class="col-md-8">
							        
							        <? if(@count($odpisy)) { ?>
					                <div class="list-group">
					                    <? foreach($odpisy as $odpis) { ?>
					                        <li class="list-group-item">
					                            <p class="list-group-item-text">
					                                <a href="<?= $object->getUrl() ?>/odpisy/">
					                                <?= $this->Czas->dataSlownie(
					                                    date('Y-m-d', strtotime($odpis['complete_ts']))
					                                ); ?> 
					                                <?= date('H:i:s', strtotime($odpis['complete_ts'])); ?>
					                                </a>
					                            </p>
					                        </li>
					                    <? } ?>
						            <? } ?>
							        </div>
			
							        
						        </div><div class="col-md-4">

                                    <form action="<?= $object->getUrl(); ?>.json" method="post">
                                        <input type="hidden" name="_action" value="pobierz_nowy_odpis"/>
                                        <button type="submit" class="btn btnUpdate btn-primary btn-icon auto-width">
                                            <i class="icon glyphicon glyphicon-refresh"></i> Poproś o nowy odpis
                                        </button>
                                    </form>
							        
						        </div>
					        </div>
												
				        </section>
				    </div>
					    
			    </div>
	        
	        </div>
        </div>
			         

    </div>
</div>