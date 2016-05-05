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

                <header class="margin-top-15 margin-bottom-15"><h1><?= $dzialanie->getData('tytul'); ?></h1></header>

            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="object">
                    <div class="block block-simple col-xs-12 margin-top-5 margin-bottom-20">
						
						<section class="text-typo margin-bottom-20">
	                        <? if( $headline = $dzialanie->getData('podsumowanie') ) {?>
	                            <div class="headline">
	                                <?= $headline ?>
	                            </div>
	                        <? } ?>
							
	                        <div class="meta margin-sides-20">
							<span class="date">
				                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
	                            <?= $this->Czas->dataSlownie(
	                                $dzialanie->getData('data_utworzenia')
	                            ); ?>
				            </span>
	                        </div>
	
	                        <? if ($dzialanie->getData('photo') == '1') { ?>
	                            <div class="photo">
	                                <img alt="<?= $dzialanie->getData('tytul'); ?>" src="http://sds.tiktalik.com/portal/1/pages/dzialania/<?= $dzialanie->getData('id'); ?>.jpg"/>
	                            </div>
	                        <? } ?>
	
	                        <div class="opis margin-sides-20">
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
	                                                <div class="btn mailingBtn width-auto btn-md btn-primary btn-icon">
	                                                    <span class="icon glyphicon glyphicon-envelope"></span>
	                                                    ' . $label . '
	                                                </div>
	                                            </div>';
	
	                            }, $output);
	
	                            echo $output;
	                            ?>
	                        </div>
                        
						</section>
						
						
						<div class="margin-sides-20">
                        <? if($features = $dzialanie->getLayer('features')) { ?>

                            <? if($dzialanie->getData('zakonczone') == '1') { ?>

                                <div class="alert alert-info text-center margin-top-20" role="alert">
                                    Działanie zostało zakończone
                                </div>

                            <? } else { ?>

                                <? if($mailing = @$features['mailings'][0]) { ?>

                                    <?php switch (Configure::read('Config.language')) {
                                        case 'pol':
                                            $lang = "pl-PL";
                                            break;
                                        case 'eng':
                                            $lang = "en-EN";
                                            break;
                                    }; ?>
                                    <?php echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock')); ?>
                                    <?php $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma'))) ?>
                                    <?php $this->Combinator->add_libs('css', $this->Less->css('naszrzecznik', array('plugin' => 'Pisma'))) ?>
                                    <?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
                                    <?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>
                                    <?php $this->Combinator->add_libs('js', 'Pisma.pisma-button.js') ?>

                                    <div class="mailing start naszrzecznik">

                                        <form target="_blank" class="letter form-horizontal" action="/pisma" method="post">

                                            <h2 class="text-center">Znajdź swojego <? echo $mailing['target'] == '0' ? 'posła' : 'senatora' ?> i wyślij pismo teraz!</h2>
                                            <input id="input_szablon_id" type="hidden" name="szablon_id" value="<?= $mailing['pismo_szablon_id'] ?>"/>

                                            <fieldset>
                                                <div class="form-group adresaci margin-top-10">
                                                    <label for="adresatSelect" class="col-lg-2 control-label">Adresat</label>

                                                    <div class="col-lg-9">
                                                        <div class="suggesterBlockPisma">
                                                            <?
                                                            $dataset = 'pisma_adresaci-aktywni_';
                                                            $dataset .= ($mailing['target'] == '0') ? 'poslowie' : 'senatorowie';
                                                            echo $this->Element('Pisma.searcher', array(
                                                                'q' => '',
                                                                'dataset' =>  $dataset,
                                                                'placeholder' => 'Zacznij pisać aby znaleźć adresata...'
                                                            ));
                                                            ?>
                                                        </div>
                                                        <span class="help-block">Na podstawie wybranego <? echo ($mailing['target'] == '0') ? 'posła' : 'senatora' ?>, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
                                                    </div>

                                                    <input type="hidden" name="adresat_id"<?php if (!empty($pismo['adresat_id'])) {
                                                        echo ' value="' . $pismo['adresat_id'] . '"';
                                                    } ?>>

                                                </div>
                                            </fieldset>

                                            <fieldset class="final">
                                                <div class="form-group">
                                                    <div class="col-lg-10 col-lg-offset-1 text-center">
                                                        <button type="submit"
                                                                class="createBtn btn width-auto btn-md btn-primary btn-icon">
                                                            <i
                                                                class="icon glyphicon glyphicon-pencil"></i>Stwórz pismo
                                                        </button>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <? if($mailing['target'] == '0') { ?>

                                                <?php $this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialanie-mailing'); ?>

                                                <h2 class="text-center">Nie wiesz kto jest Twoim posłem?</h2>

                                                <p class="help-block text-center">
                                                    <a href="#" id="localizeMe">Zlokalizuj się</a>
                                                    lub wskaż na mapie miejsce zamieszkania:
                                                </p>

                                                <div class="row">
                                                    <div id="map"></div>
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

                                            <? } elseif($mailing['target'] == '1') { ?>

                                                <?php $this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialanie-senat'); ?>

                                                <h2 class="text-center">Nie wiesz kto jest Twoim senatorem?</h2>

                                                <p class="help-block text-center">
                                                    <a href="#" id="localizeMe">Zlokalizuj się</a>
                                                    lub wskaż na mapie miejsce zamieszkania:
                                                </p>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="senat" style="height: 500px;"></div>
                                                    </div>
                                                </div>

                                                <div data-name="senat" data-value='<?= json_encode($okregi) ?>'></div>

                                                <div class="modal fade" id="wybierzSenatora" tabindex="-1" role="dialog" aria-labelledby="wybierzSenatoraLabel">
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

                                            </form>

                                        </div>

                                <? } ?>
                            <? } ?>
                        <? } ?>

                        <? if(isset($files) && count($files)) { ?>

                            <h4 class="">Załączniki</h4>

                            <div class="files">
                                <? foreach($files as $file) { ?>
                                    <div class="file">
                                        <a target="_blank" href="<?= $object->getUrl() ?>/zalacznik/<?= $dzialanie->getId() ?>,<?= $file['ActivitiesFiles']['id'] ?>">
                                            <span class="glyphicon glyphicon-download-alt"></span>
                                            <?= $file['ActivitiesFiles']['src_filename'] != '' ? $file['ActivitiesFiles']['src_filename'] : $file['ActivitiesFiles']['filename'] ?>
                                        </a>
                                    </div>
                                <? } ?>
                            </div>

                        <? } ?>
						</div>

                    </div>
                </div>
            </div>
            <div class="col-md-3">

                <? if($object_editable) { ?>
                    <div class="margin-top-10">
                        <a href="<?= $object->getUrl() ?>/dzialania/<?= $dzialanie->getData('id') ?>/edytuj">
                            <button class="btn btn-sm btn-primary btn-icon btn-width-auto">
                                <span class="icon glyphicon glyphicon-pencil"></span>
                                Edytuj
                            </button>
                        </a>
                    </div>
                <? } ?>

            </div>
        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>
