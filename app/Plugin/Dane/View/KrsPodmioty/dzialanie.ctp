<?
echo $this->Element('dataobject/pageBegin');

////$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty');

?>

<div class="dzialanie">
	
	<div class="row">
		<div class="col-md-12">
			
            <header><h1><?= $dzialanie->getData('tytul'); ?></h1></header>
									
		</div>
	</div>
	    
    <div class="row">
	    <div class="col-md-9">
	        <div class="object">
	            <div class="block block-simple col-xs-12 margin-top-5">
	                
	                <? if( $headline = $dzialanie->getData('podsumowanie') ) {?>
					<div class="headline">
						<?= $headline ?>
					</div>
					<? } ?>
					
					<div class="meta">
						<span class="date">
			                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
			                <?= $this->Czas->dataSlownie(
			                    $dzialanie->getData('data_utworzenia')
			                ); ?>
			            </span>
					</div>
	                
	                <? if($dzialanie->getData('photo') == '1') { ?>
	                    <div class="photo">
	                        <img alt="<?= $dzialanie->getData('tytul'); ?>" src="http://sds.tiktalik.com/portal/1/pages/dzialania/<?= $dzialanie->getData('id'); ?>.jpg"/>
	                    </div>
	                <? } ?>
	
	                <div class="opis">
	                    <?
		                    $output = $dzialanie->getData('opis');
		                    $output = preg_replace_callback('/\{\$dokument (.*?)\}/i', function($matches){
			                    
			                    $dokument_id = false;
			                    preg_match_all('/(.*?)\=\"(.*?)\"/i', $matches[1], $m);
			                    for( $i=0; $i<count($m[0]); $i++ ) {
				                    
				                    if( ($m[1][$i]=='id') && is_numeric($m[2][$i]) )
				                    	$dokument_id = $m[2][$i];
				                    
			                    }
			                    
			                    if( $dokument_id )
			                    	return $this->Document->place($dokument_id);
			                    else
			                    	return '';
			                    			                    			                    
		                    }, $output);

                            $output = preg_replace_callback('/\{\$mailing_button (.*?)\}/i', function($matches){

                                $label = 'Wyślij pismo do posła teraz!';

                                preg_match_all('/(.*?)\=\"(.*?)\"/i', $matches[1], $m);
                                for( $i=0; $i<count($m[0]); $i++ ) {
                                    if( ($m[1][$i]=='label') && isset($m[2][$i]) )
                                        $label = $m[2][$i];
                                }

                                return '<div class="text-center margin-top-10">
                                                <div class="btn mailingBtn auto-width btn-md btn-primary btn-icon">
                                                    <i class="icon glyphicon glyphicon-envelope"></i>
                                                    ' . $label . '
                                                </div>
                                            </div>';

                            }, $output);
		                    
		                    echo $output;
		                ?>
	                </div>
	
	                <? if($features = $dzialanie->getLayer('features')) { ?>
	                    <? if($mailing = @$features['mailings'][0]) { ?>
							
							<?php $this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialanie-mailing'); ?>
	                        <?php echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock')); ?>
	                        <?php $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma'))) ?>
	                        <?php $this->Combinator->add_libs('css', $this->Less->css('naszrzecznik', array('plugin' => 'Pisma'))) ?>
	                        <?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
	                        <?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>
	                        <?php $this->Combinator->add_libs('js', 'Pisma.pisma-button.js') ?>
	
	                        <div class="mailing start naszrzecznik">
	
	                            <form target="_blank" class="letter form-horizontal" action="/pisma" method="post">
	
	                                <h2 class="text-center">Znajdź swojego posła i wyślij pismo teraz!</h2>
	                                <input type="hidden" name="szablon_id" value="<?= $mailing['pismo_szablon_id'] ?>"/>
	
	                                <fieldset>
	                                    <div class="form-group adresaci margin-top-10">
	                                        <label for="adresatSelect" class="col-lg-2 control-label">Adresat</label>
	
	                                        <div class="col-lg-9">
	                                            <div class="suggesterBlockPisma">
	                                                <?= $this->Element('Pisma.searcher', array('q' => '', 'dataset' => 'pisma_adresaci-aktywni_poslowie', 'placeholder' => 'Zacznij pisać aby znaleźć adresata...')) ?>
	                                            </div>
	                                            <span
	                                                class="help-block">Na podstawie wybranego posła, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
	                                        </div>
	
	                                        <input type="hidden" name="adresat_id"<?php if (!empty($pismo['adresat_id'])) {
	                                            echo ' value="' . $pismo['adresat_id'] . '"';
	                                        } ?>>
	
	                                    </div>
	                                </fieldset>
	
	                                <fieldset class="final">
	                                    <div class="form-group">
	                                        <div class="col-lg-10 col-lg-offset-1 text-center">
	                                            <button type="submit" class="createBtn btn auto-width btn-md btn-primary btn-icon"><i
	                                                    class="icon glyphicon glyphicon-pencil"></i>Stwórz pismo
	                                            </button>
	                                        </div>
	                                    </div>
	                                </fieldset>
	
	                                <h2 class="text-center">Nie wiesz kto jest Twoim posłem?</h2>
	
	                                <p class="help-block text-center"><a href="#" id="localizeMe">Zlokalizuj się</a> lub wskaż
	                                    na mapie miejsce zamieszkania:</p>
	
	                                <div class="row">
	                                    <div id="map"></div>
	                                </div>
	
	                            </form>
	
	                        </div>
	
	                        <div data-name="okregi" data-value='<?= json_encode($okregi) ?>'></div>
	
	                        <div class="modal fade" id="wybierzPosla" tabindex="-1" role="dialog" aria-labelledby="wybierzPoslaLabel">
	                            <div class="modal-dialog" role="document">
	                                <div class="modal-content">
	                                    <div class="modal-header"></div>
	                                    <div class="modal-body"></div>
	                                    <div class="modal-footer">
	                                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	
	                    <? } ?>
	                <? } ?>
	            </div>
	        </div>
	    </div><div class="col-md-3">
		    
		    <? if($object_editable) { ?>
		    <div class="margin-top-10">
	            <a href="<?= $object->getUrl() ?>/dzialania/<?= $dzialanie->getData('id') ?>/edytuj">
	                <button class="btn btn-sm btn-primary btn-icon btn-auto-width">
	                    <i class="icon glyphicon glyphicon-pencil"></i>
	                    Edytuj
	                </button>
	            </a>
	        </div>
	        <? } ?>
	        		    
	    </div>
    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>