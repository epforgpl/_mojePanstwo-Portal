<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array('komitet', 'liczba_glosow', 'procent_glosow_w_okregu'),
        'bigTitle' => true,
    )
));

?>

    <div class="krsOsoba row">

        <div class="col-md-3 objectSide">
            <div class="objectSideInner rrs">

                <? if ($radny->getData('aktywny') == '0') { ?>
                    <div class="block">

                        <ul class="dataHighlights side">

                            <li class="dataHighlight">
                                <span class="label label-danger">Ta osoba nie jest już radnym</span>
                            </li>

                            <? /*
		                <li class="dataHighlight">
		                    <p class="_label">Pozycja na liście</p>
		
		                    <p class="_value"><?= $radny->getData('pozycja'); ?></p>
		                </li>
		
		                <li class="dataHighlight">
		                    <p class="_label">Rok urodzenia</p>
		
		                    <p class="_value"><?= $radny->getData('rok_urodzenia'); ?></p>
		                </li>
		                */ ?>

                        </ul>

                    </div>
                <? } ?>

                <?
                /*

                $details = $radny->getLayer('details');
                $opis = preg_replace('/\<a (.*?)\>(.*?)\<\/a\>/i', '', $details['opis_html']);
                $opis = str_ireplace(array('- <br>'), '<br/>', $opis);

                if( $opis ) {
            ?>
                <div id="info" class="block">

                    <div class="block-header">
                        <h2 class="label">Życiorys</h2>
                    </div>

                    <div class="content">
                        <?= stripslashes($opis) ?>
                    </div>
                </div>
            <? } */ ?>

                <div class="block">

                    <div class="block-header">
                        <h2 class="label">Aktywności</h2>
                    </div>

                    <ul class="dataHighlights side">

                        <? if ($radny->getData('liczba_wystapien')) { ?>
                            <li class="dataHighlight">
                                <a href="<?= $radny->getUrl() ?>/wystapienia"><span
                                        class="icon icon-moon">&#xe615;</span>Wystąpienia <span
                                        class="glyphicon glyphicon-chevron-right"></a>
                            </li>
                        <? } ?>

                        <li class="dataHighlight">
                            <a href="<?= $radny->getUrl() ?>/glosowania"><span class="glyphicon glyphicon-list"></span>Wyniki
                                głosowań <span class="glyphicon glyphicon-chevron-right"></a>
                        </li>

                        <? if ($radny->getData('liczba_interpelacji')) { ?>
                            <li class="dataHighlight">
                                <a href="<?= $radny->getUrl() ?>/interpelacje"><span
                                        class="icon icon-moon">&#xe614;</span>Interpelacje <span
                                        class="glyphicon glyphicon-chevron-right"></a>
                            </li>
                        <? } ?>

                        <li class="dataHighlight">
                            <a href="<?= $radny->getUrl() ?>/komisje"><span class="icon icon-moon">&#xe613;</span>Przynależność
                                do komisji <span class="glyphicon glyphicon-chevron-right"></a>
                        </li>
                        
                        <li class="dataHighlight">
                            <a href="<?= $radny->getUrl() ?>/dyzury"><span class="glyphicon glyphicon-list"></span>Dyżury <span class="glyphicon glyphicon-chevron-right"></a>
                        </li>

                    </ul>

                </div>

                <? if ($radny->getData('liczba_oswiadczen') || $radny->getData('krs_osoba_id')) { ?>

                    <div class="block">

                        <div class="block-header">
                            <h2 class="label">Informacje</h2>
                        </div>

                        <ul class="dataHighlights side">

                            <? if ($radny->getData('liczba_oswiadczen')) { ?>
                                <li class="dataHighlight">
                                    <a href="<?= $radny->getUrl() ?>/oswiadczenia"><span
                                            class="icon icon-moon">&#xe61b;</span>Oświadczenia majątkowe <span
                                            class="glyphicon glyphicon-chevron-right"></a>
                                </li>
                            <? } ?>

                            <? if ($radny->getData('krs_osoba_id')) { ?>
                                <li class="dataHighlight">
                                    <a href="<?= $radny->getUrl() ?>/krs"><span class="icon icon-moon">&#xe611;</span>Powiązania
                                        w KRS <span class="glyphicon glyphicon-chevron-right"></a>
                                </li>
                            <? } ?>

                        </ul>

                    </div>

                <? } ?>

                <div class="block">

                    <ul class="dataHighlights side">

                        <li class="dataHighlight">
                            <a target="_blank" href="<?= $radny->getLayer('bip_url') ?>"><span
                                    class="glyphicon glyphicon-link"></span>Profil radnego w BIP <span
                                    class="glyphicon glyphicon-chevron-right"></a>
                        </li>

                    </ul>

                </div>


            </div>
        </div>

        <div class="col-lg-7 nopadding">
            <div class="object">

                <?= $this->dataobject->feed($feed); ?>

                <? /*
			    <? if ($radny->getData('aktywny') == '0') { ?>
			
			        <div id="rezygnacja" class="block">
			
			            <div class="block-header">
			                <h2 class="label">Data utraty mandatu</h2>
			            </div>
			
			            <div class="content">
			                <p><?= $this->Czas->dataSlownie($radny->getData('data_rezygnacji')) ?></p>
			            </div>
			        </div>
			
			        <div id="rezygnacja" class="block">
			
			            <div class="block-header">
			                <h2 class="label">Przyczyna utraty mandatu</h2>
			            </div>
			
			            <div class="content">
			                <p><?= ucfirst($radny->getData('rezygnacja_podstawa_prawna')) ?></p>
			            </div>
			        </div>
			    <? } ?>
				
				

				
			    <?
			    if ($object->getId() == '903') {
			
			        $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
			
			        
			
			        ?>
			
			        
						
			        <? if ($d = $radny->getLayer('najblizszy_dyzur')) { ?>
			            <script type="text/javascript" src="http://js.addthisevent.com/atemay.js"></script>
			            <? $this->Combinator->add_libs('css', $this->Less->css('view-gminy-dyzury', array('plugin' => 'Dane'))); ?>
			            <div id="dyzury" class="block">
			
			                <div class="block-header">
			                    <h2 class="label pull-left">Najbliższy dyżur</h2>
			                    <a class="btn btn-default btn-sm pull-right"
			                       href="/dane/gminy/<?= $object->getId() ?>/radni/<?= $radny->getId() ?>/dyzury">Zobacz
			                        wszystkie dyżury</a>
			                </div>
			
			                <div class="content">
			                    <ul>
			                        <li style="margin: 15px 0;">
			                            <div class="row">
			                                <div class="col-md-2">
			                                    <b><?= $this->Czas->dataSlownie($d['data']) ?></b>
			                                </div>
			                                <div class="col-md-2">
			                                    <?= $d['godz_str'] ?>
			                                </div>
			                                <div class="col-md-3">
			                                    <?= $d['adres'] ?>
			                                </div>
			                                <div class="col-md-3">
			                                    <?= $d['adres_wiecej'] ?>
			                                </div>
			                                <div class="col-md-2">
			                                    <a href="http://example.com/link-to-your-event"
			                                       title="Dodaj do kalendarza" class="addthisevent">
			                                        Dodaj do kalendarza
			                                        <? if ($d['timestart'] && ($d['timestart'] != '0000-00-00 00:00:00')) { ?>
			                                            <span class="_start"><?= $d['timestart'] ?></span><? } ?>
			                                        <? if ($d['timestop'] && ($d['timestop'] != '0000-00-00 00:00:00')) { ?>
			                                            <span class="_end"><?= $d['timestop'] ?></span><? } ?>
			                                        <span class="_zonecode">41</span>
			                                                    <span
			                                                        class="_summary">Dyżur poselski <?= $radny->getData('nazwa') ?></span>
			                                                    <span class="_description"><?= $d['godz_str'] ?>
			                                                        , <?= $d['adres'] ?></span>
			                                        <span class="_location"><?= $d['adres_wiecej'] ?></span>
			                                        <span class="_organizer"><?= $radny->getData('nazwa') ?></span>
			                                                    <span
			                                                        class="_organizer_email"><?= $radny->getData('email') ?></span>
			                                                    <span
			                                                        class="_all_day_event"><? if ($d['timestart'] && ($d['timestart'] != '0000-00-00 00:00:00') && $d['timestop'] && ($d['timestop'] != '0000-00-00 00:00:00')) { ?>false<? } else { ?>true<? } ?></span>
													    <span class="_date_format"><?
			                                                $parts = explode('-', $d['data']);
			                                                echo $parts[2] . '/' . $parts[1] . '/' . $parts[0];
			                                                ?></span>
			                                    </a>
			                                </div>
			                            </div>
			                        </li>
			                    </ul>
			                </div>
			            </div>
			        <? } ?>
			
			    <? } ?>
			
			
			    
			    <? */ ?>

            </div>
        </div>
        <div class="col-md-2">
			
			<?
				echo $this->element('Dane.object-actions', array(
					'buttons' => array(
						'pismo' => array(
							'adresat_id' => $radny->getDataset() . ':' . $radny->getId(),
							'szablon_id' => 69, // List do radnego
							'nazwa' => 'Wyślij list',
							'opis' => 'Kliknij aby wysłać list do ' . $radny->getTitle(),
						),
					),
					'name' => $radny->getTitle(),
				));
			?>
			<? /*
			<ul class="object-actions-ul">
				<? if( isset( $this->request->query['dev'] ) ) { ?>
				<li>
					<p class="btn_cont">
						<button class="btn btn-success">Obserwuj...</button>
					</p>
					<p class="desc">
						Kliknij, aby otrzymywać powiadomienia o pracy radnego.
					</p>
				</li>
				<? } ?>
				<li>
					<form action="/pisma" method="post">
						<input type="hidden" name="adresat_id" value="radni_gmin:<?= $radny->getId() ?>" />
						<input type="hidden" name="szablon_id" value="69" />
						<p class="btn_cont">
							<button class="btn btn-success">Wyślij pismo...</button>
						</p>
					</form>
					<p class="desc">
						Kliknij, aby wysłać pismo do radnego.
					</p>
				</li>
			</ul>
			*/ ?>
			
			
        </div>

    </div>

<? echo $this->Element('dataobject/pageEnd');