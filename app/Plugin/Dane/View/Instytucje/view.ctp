<?
$this->Combinator->add_libs('css', $this->Less->css('view-administracjapubliczna', array('plugin' => 'Dane')));
// $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-administracjapubliczna');
?>
<? echo $this->Element('dataobject/pageBegin'); ?>

    <div class="administracjaPubliczna row">

        <? if ($object->getData('file') == '1') { ?>

            <div class="col-md-3 objectSide">
                <div class="objectSideInner">

                    <? if ($object->getData('budzet_plan')) { ?>
                        <div class="block">

                            <ul class="dataHighlights side">

                                <? if ($object->getData('budzet_plan')) { ?>
                                    <li class="dataHighlight big">
                                        <p class="_label" data-toggle="tooltip" data-placement="top"
                                           title="Budżet roczny organizacji, finansowany z budżetu państwa">Budżet
                                            roczny</p>

                                        <div>
                                            <p class="_value pull-left"><?= number_format_h($object->getData('budzet_plan') * 1000) ?>
                                                PLN</p>

                                            <p class="pull-right nopadding"><a class="btn btn-sm btn-default"
                                                                               href="/dane/instytucje/<?= $object->getId() ?>/budzet">Szczegóły &raquo;</a>
                                            </p>
                                        </div>
                                    </li>
                                <? } ?>

                            </ul>

                        </div>
                    <? } ?>

                    <? if (
                        ($nadrzedna = $object->getLayer('instytucja_nadrzedna')) ||
                        $object->getData('liczba_instytucji')
                    ) { ?>
                        <div class="block">

                            <ul class="dataHighlights side">

                                <? if ($nadrzedna = $object->getLayer('instytucja_nadrzedna')) { ?>
                                    <li class="dataHighlight">
                                        <p class="_label">Instytucja nadrzędna</p>

                                        <p class="_value pull-left"><a
                                                href="/dane/instytucje/<?= $nadrzedna['id'] ?><? if ($nadrzedna['slug']) { ?>,<?= $nadrzedna['slug'] ?><? } ?>"><?= $nadrzedna['nazwa'] ?></a>
                                        </p>
                                    </li>
                                <? } ?>

                                

                                <? if ($object->getData('liczba_instytucji')) { ?>
                                    <li class="dataHighlight">
                                        <a href="<?= $object->getUrl() ?>/instytucje"><span class="icon icon-moon">&#xe611;</span>Instytucje
                                            nadzorowane <span class="glyphicon glyphicon-chevron-right"></span></a>
                                    </li>
                                <? } ?>

                                <li class="dataHighlight">
                                    <a href="<?= $object->getUrl() ?>/urzednicy">
                                        <span class="icon icon-moon">&#xe611;</span>Urzędnicy
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </li>

                            </ul>

                        </div>
                    <? } ?>



                    <div class="block">

                        <ul class="dataHighlights side">

                            <li class="dataHighlight">
                                <a href="<?= $object->getUrl() ?>/zamowienia"><span
                                        class="icon icon-moon">&#xe61a;</span>Zamówienia publiczne <span
                                        class="glyphicon glyphicon-chevron-right"></span></a>
                            </li>

                            <li class="dataHighlight">
                                <a href="<?= $object->getUrl() ?>/prawo"><span class="glyphicon glyphicon-book"></span>Akty
                                    prawne <span class="glyphicon glyphicon-chevron-right"></span></a>
                            </li>

                            <? if ($object->getData('twitter_account_id')) { ?>
                                <li class="dataHighlight">
                                    <a href="<?= $object->getUrl() ?>/tweety"><span
                                            class="icon icon-moon">&#xe61d;</span>Tweety <span
                                            class="glyphicon glyphicon-chevron-right"></span></a>
                                </li>
                            <? } ?>

                        </ul>

                    </div>


                    <div class="block">

                        <ul class="dataHighlights side">


                            <?
                            if ($www = $object->getData('www')) {
                                $url = (stripos($www, 'http') === false) ? 'http://' . $www : $www;
                                ?>
                                <li class="dataHighlight">
                                    <p class="_label">Adres WWW</p>

                                    <p class="_value"><a target="_blank" title="<?= addslashes($object->getTitle()) ?>"
                                                         href="<?= $url ?>"><?= $www; ?></a></p>
                                </li>
                            <? } ?>
                        </ul>


                        <ul class="dataHighlights side" style="display: none;">
                            <? if ($email = $object->getData('email')) { ?>
                                <li class="dataHighlight">
                                    <p class="_label">Adres e-mail</p>

                                    <p class="_value"><a target="_blank" href="mailto:<?= $email ?>"><?= $email; ?></a>
                                    </p>
                                </li>
                            <? } ?>

                            <? if ($object->getData('phone')) { ?>
                                <li class="dataHighlight">
                                    <p class="_label">Telefon</p>

                                    <p class="_value"><?= $object->getData('phone'); ?></p>
                                </li>
                            <? } ?>

                            <? if ($object->getData('fax')) { ?>
                                <li class="dataHighlight">
                                    <p class="_label">Fax</p>

                                    <p class="_value"><?= $object->getData('fax'); ?></p>
                                </li>
                            <? } ?>


                        </ul>

                    </div>


                </div>
            </div>

            <div class="col-md-7 nopadding">

                <div class="object">
                    <?= $this->dataobject->feed($feed); ?>
                </div>
            </div>
            <div class="col-md-2">
				
				<?
					echo $this->element('Dane.object-actions', array(
						'buttons' => array(
							'obserwuj' => array(
								'id' => $object->getGlobalId(),
							),
							'pismo' => array(
								'adresat_id' => $object->getDataset() . ':' . $object->getId(),
								'szablon_id' => 35,
								'nazwa' => 'Wyślij wniosek o udostępnienie informacji publicznej',
								'opis' => 'Masz pytania do ' . $object->getTitle() . '? Klijnij aby wysłać odpowiedni wniosek.',
							),
							'pisma' => array(
								'adresat_id' => $object->getDataset() . ':' . $object->getId(),
							),
						),
						'name' => $object->getTitle(),
					));
				?>				
				
            </div>

            <? /*
        <div class="col-md-9 objectMain">
            <div class="object">
                <?
                $adres = $object->getData('adres_str');
                $re = "/^([0-9][0-9][-][0-9][0-9][0-9])/";

                if (preg_match($re, $adres, $matches)) {
                    $adres_map = substr($adres, 7);
                } else {
                    $adres_map = $adres;
                }
                ?>
                <?php if (!empty($adres_map)) { ?>

                    <div class="block">
                        <div class="block-header">
                            <h2 class="label">Adres</h2>

                            <div class="mapsOptions pull-right">
                                <button
                                    class="googleMap btn btn-sm btn-default"><?= __d('dane', 'LC_DANE_VIEW_KRSPODMIOTY_OTWORZ_MAPE') ?></button>
                                <button
                                    class="streetView btn btn-sm btn-default"><?= __d('dane', 'LC_DANE_VIEW_KRSPODMIOTY_OTWORZ_MAPE_STREET') ?></button>
                            </div>
                        </div>

                        <div class="profile_baner" data-adres="<?= urlencode($adres) ?>">
                            <div class="bg">
                                <img
                                    src="http://maps.googleapis.com/maps/api/staticmap?center=<?= urlencode($adres_map) ?>&markers=<?= urlencode($adres_map) ?>&zoom=15&sensor=false&size=640x155&scale=2&feature:road"/>

                                <div class="content">
                                    <p><?= $object->getData('adres_str') ?></p>
                                </div>
                            </div>
                            <div class="googleView">
                                <script>
                                    var googleMapAdres = '<?= $adres ?>';
                                </script>
                                <div id="googleMap"></div>
                                <div id="streetView"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="block-group">

                    <? if (isset($info['opis_html']) && $info['opis_html']) { ?>
                        <div class="block">
                            <div class="block-header">
                                <h2 class="label">Informacje</h2>
                            </div>
                            <div class="content opis">
                                <?= $info['opis_html'] ?>
                            </div>
                        </div>
                    <? } ?>


                    <? if (
                        ($tree = $object->getLayer('tree')) &&
                        ($items = $tree['items'])
                    ) {
                        ?>
                        <div class="block">
                            <div class="block-header">

                                <h2 class="label">Podległe instytucje</h2>

                            </div>
                            <div class="content nopadding">

                                <div class="tree">
                                    <ul>
                                        <li>
                                            <?
                                            echo $this->Element('Dane.objects/instytucje/list', array(
                                                'items' => $items,
                                                'i' => 0,
                                            ));
                                            ?>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    <? } ?>

                </div>


            </div>
        </div>
        <? */ ?>

        <? } else { ?>

            <div class="col-md-9 col-md-offset-1">
                <div class="">

                    <div class="block-group">

                        <? if (isset($info['opis_html']) && $info['opis_html']) { ?>
                            <div class="block">
                                <div class="block-header">
                                    <h2 class="label">Informacje</h2>
                                </div>
                                <div class="content opis">
                                    <?= $info['opis_html'] ?>
                                </div>
                            </div>
                        <? } ?>


                        <? if (
                            ($tree = $object->getLayer('tree')) &&
                            ($items = $tree['items'])
                        ) {
                            ?>
                            <div class="block">
                                <div class="block-header">

                                    <h2 class="label">Podległe instytucje</h2>

                                </div>
                                <div class="content nopadding">

                                    <div class="tree">
                                        <ul>
                                            <li>
                                                <?
                                                echo $this->Element('Dane.objects/instytucje/list', array(
                                                    'items' => $items,
                                                    'i' => 0,
                                                ));
                                                ?>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        <? } ?>

                    </div>

                </div>
            </div>

        <? } ?>

    </div>

<?= $this->Element('dataobject/pageEnd'); ?>