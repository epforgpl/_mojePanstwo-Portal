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
    'object' => $dzielnica,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    )
));

?>

    <div class="krsOsoba row">

		<div class="col-lg-3 objectSide">
			<div class="objectSideInner rrs">


				<div class="block">

					<div class="block-header">
						<h2 class="label">Rada dzielnicy</h2>
					</div>

					<ul class="dataHighlights side">

						<li class="dataHighlight">
							<a href="<?= $dzielnica->getUrl() ?>/radni"><span class="icon icon-moon">&#xe617;</span>Radni
								<span class="glyphicon glyphicon-chevron-right"></a>
						</li>

						<li class="dataHighlight">
							<a href="<?= $dzielnica->getUrl() ?>/rada_posiedzenia"><span
									class="icon icon-moon">&#xe615;</span>Posiedzenia <span
									class="glyphicon glyphicon-chevron-right"></a>
						</li>

						<li class="dataHighlight">
							<a href="<?= $object->getUrl() ?>/rada_uchwaly"><span class="icon icon-moon">&#xe614;</span>Uchwały
								<span class="glyphicon glyphicon-chevron-right"></span></a>
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

		</div>

	</div>

<? echo $this->Element('dataobject/pageEnd');