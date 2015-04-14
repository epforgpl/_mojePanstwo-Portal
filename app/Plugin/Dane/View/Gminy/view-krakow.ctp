<?php $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>

<?php $this->Combinator->add_libs('js', 'jquery-tags-cloud-min'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-gminy'); ?>

<?php if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.exp', array('block' => 'scriptBlock'));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow');
} ?>

<? echo $this->Element('dataobject/pageBegin'); ?>

<div class="gminy">
    <div class="col-md-3 objectSide">
        <div class="objectSideInner rrs">
            <div class="block">
                <ul class="dataHighlights side">
                    <li class="dataHighlight big">
                        <p class="_label">Liczba ludności</p>

                        <div>
                            <p class="_value"><?= number_format_h($object->getData('liczba_ludnosci')); ?></p>
                        </div>
                    </li>

                    <li class="dataHighlight big">
                        <p class="_label">Powierzchnia</p>

                        <div>
                            <p class="_value"><?= number_format($object->getData('powierzchnia'), 0); ?> km<sup>2</sup>
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="block">
                <ul class="dataHighlights side">
                    <li class="dataHighlight">
                        <a target="_blank" href="https://www.bip.krakow.pl/">
                            <span class="glyphicon glyphicon-link"></span>Oficjalny BIP Krakowa<span
                                class="glyphicon glyphicon-chevron-right">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="block">
                <ul class="dataHighlights side">
                    <li class="dataHighlight">
                        <p class="_label">Dochody roczne gminy</p>

                        <div>
                            <p class="_value"><?= number_format_h($object->getData('dochody_roczne')); ?> PLN</p>
                        </div>
                    </li>

                    <li class="dataHighlight">
                        <p class="_label">Wydatki roczne gminy</p>

                        <div>
                            <p class="_value"><?= number_format_h($object->getData('wydatki_roczne')); ?> PLN</p>
                        </div>
                    </li>

                    <li class="dataHighlight">
                        <p class="_label">Nadwyżka budżetowa</p>

                        <div>
                            <p class="_value"><?= number_format_h(-$object->getData('zadluzenie_roczne')); ?> PLN</p>
                        </div>
                    </li>
                </ul>

                <ul class="dataHighlights side hide">
                    <li class="dataHighlight">
                        <p class="_label">Kod TERYT</p>

                        <div>
                            <p class="_value"><?= $object->getData('teryt'); ?></p>
                        </div>
                    </li>

                    <li class="dataHighlight">
                        <p class="_label">Kod NTS</p>

                        <div>
                            <p class="_value"><?= $object->getData('nts'); ?></p>
                        </div>
                    </li>

                    <li class="dataHighlight topborder">
                        <p class="_label">Biuletyn Informacji Publicznej</p>

                        <div>
                            <p class="_value"><?= $object->getData('bip_www'); ?></p>
                        </div>
                    </li>

                </ul>

                <p style="display: none;" class="text-center showHideSide">
                    <a class="a-more">Więcej &darr;</a>
                    <a class="a-less hide">Mniej &uarr;</a>
                </p>

            </div>
        </div>
    </div>

    <div class="col-md-9 objectMain">
        <? /*<div class="objectSearch">
            <div class="input-group">
                <form method="get" action="/dane/gminy/<?= $object->getId() ?>/szukaj">
                    <input type="text" placeholder="Szukaj w Przejrzystym Krakowie..." autocomplete="off"
                           class="form-control ui-autocomplete-input" name="q">
                    <input type="submit" style="display: none;" name="submit" value="search">
                    <span class="input-group-btn">
                        <button data-icon="" type="submit" class="btn btn-success btn-lg"></button>
                    </span>
                </form>
            </div>
        </div>*/ ?>

        <div class="object">
            <div class="block-group">
                <?php /* if (($object->getId() == '903') && ($posiedzenie = $object->getLayer('ostatnie_posiedzenie')) && !empty($posiedzenie['data']) && !empty($posiedzenie['terms'])) { ?>
    <div id="prawo" class="block">
        <div class="block-header">
            <h2 class="pull-left label">Tematy na <a
                    href="/dane/gminy/903/posiedzenia/<?= $posiedzenie['data']['id'] ?>">ostatnim posiedzeniu Rady
                    Miasta</a></h2>
            <a class="btn btn-default btn-sm pull-right"
               href="<?= Router::url(array('action' => 'posiedzenia', 'id' => $object->getId())) ?>">
                Wszystkie posiedzenia</a>
        </div>

        <div class="content">
            <ul class="objectTagsCloud row">
                <?
                $font = array(
                    'min' => 15,
                    'max' => 100,
                );
                $font['diff'] = $font['max'] - $font['min'];
                $terms = $posiedzenie['terms'];
                foreach ($terms as &$term) {
                    $term['size'] = $font['min'] + $font['diff'] * $term['norm_score'];
                }
                shuffle($terms);
                foreach ($terms as $term) {
                    $href = '/dane/gminy/903/posiedzenia/' . $posiedzenie['data']['id'] . '/punkty?q=' . addslashes($term['key']);
                    ?>
                    <li style="font-size: <?= $term['size'] ?>px;"><a href="<?= $href ?>"><?= $term['key'] ?></a></li>
                <? } ?>
            </ul>
        </div>
    </div>
<?php } */ ?>

                <div class="block">
                    <div class="block-header">
                        <h2 class="label">Rada miasta</h2>
                    </div>
                    <div class="content less-bottom-padding">

                        <div class="row separator-bottom">
                            <div class="col-md-12">

                                <div class="pk-funkcje">
                                    <p>Rada składa się z <a href="/dane/gminy/903,krakow/radni">43 radnych</a>,
                                        wybieranych w wyborach powszechnych.</p>
                                </div>

                                <div class="pk-radni jScrollPane">
                                    <? if ($radni = $object->getLayer('radni')) { ?>
                                        <ul>
                                            <? foreach ($radni as $radny) { ?>
                                                <li>
                                                    <a title="<?= $radny['imiona'] . ' ' . $radny['nazwisko'] ?>"
                                                       href="/dane/gminy/903/radni/<?= $radny['id'] ?>"><img
                                                            src="http://resources.sejmometr.pl/avatars/3/<?= $radny['avatar_id'] ?>.jpg"/>
                                                    </a>
                                                </li>
                                            <? } ?>
                                        </ul>
                                    <? } ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <h3>Posiedzenia rady</h3>

                                <div class="text-center">
                                    <a href="/dane/gminy/903,krakow/posiedzenia" title="Posiedzenia Rady Miasta Kraków">
                                        <img class="img-responsive"
                                             src="http://img.youtube.com/vi/AR9UYwp7PQA/mqdefault.jpg"/>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8 nopadding">
                                <h3>Najnowsze uchwały rady</h3>

                                <ul class="docs-list">
                                    <? foreach ($prawo_lokalne as $obj) { ?>
                                        <li>
                                            <a href="<?= $obj->getUrl() ?>">
                                                <img class="img-responsive"
                                                     src="http://docs.sejmometr.pl/thumb/4/<?= $obj->getData('dokument_id') ?>.png"/>
                                            </a>

                                            <div class="inner">
                                                <p class="title">
                                                    <a href="<?= $obj->getUrl() ?>"><?= $this->Text->truncate( $obj->getShortTitle(), 150 ) ?></a>
                                                </p>

                                                <p class="date"><?= $this->Czas->dataSlownie($obj->getDate()) ?></p>
                                            </div>
                                        </li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>

                        <p class="text-center">
                            <a class="btn btn-primary btn-sm" href="/dane/gminy/903,Krakow/rada">Dowiedz się więcej o
                                radzie &raquo;</a>
                        </p>
                    </div>
                </div>

                <div class="block">
                    <div class="block-header">
                        <h2 class="label">Urząd gminy</h2>
                    </div>

                    <div class="content less-bottom-padding">
                        <div class="row">
                            <div class="col-md-4">
                                <? if ($szef = $object->getLayer('szef')) { ?>
                                    <div id="szef" class="dataHighlights">
                                        <div class="dataHighlight big">
                                            <p class="_label"><?= $szef['stanowisko'] ?>:</p>

                                            <p class="_value"><?= $szef['nazwa'] ?></p>
                                        </div>
                                    </div>
                                <? } ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/dane/gminy/903,krakow/urzad">
                                            <img class="img-responsive" src="/dane/img/pk-prezydent.jpg">
                                        </a>
                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 nopadding">
                                <h3>Najnowsze zarządzenia Prezydenta</h3>

                                <ul class="docs-list">
                                    <? foreach ($zarzadzenia as $obj) { ?>
                                        <li>
                                            <a href="<?= $obj->getUrl() ?>">
                                                <img
                                                    src="http://docs.sejmometr.pl/thumb/4/<?= $obj->getData('dokument_id') ?>.png"/>
                                            </a>

                                            <div class="inner">
                                                <p class="title">
                                                    <a href="<?= $obj->getUrl() ?>"><?= $this->Text->truncate( $obj->getShortTitle(), 150 ) ?></a>
                                                </p>

                                                <p class="date"><?= $this->Czas->dataSlownie($obj->getDate()) ?></p>
                                            </div>
                                        </li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>

                        <p class="text-center">
                            <a class="btn btn-primary btn-sm" href="/dane/gminy/903,Krakow/urzad">Dowiedz się więcej o
                                urzędzie &raquo;</a>
                        </p>

                    </div>
                </div>

                <div class="special banner">
                    <a title="Zobacz umowy podpisywane przez Komitet Konkursowy Kraków 2022"
                       href="/dane/krs_podmioty/481129/umowy">
                        <img src="/Dane/img/krakow_special_banner.png" width="885" height="85"/>
                    </a>
                </div>


                <div id="dzielnice" class="block">
                    <div class="block-header">
                        <h2 class="label">Dzielnice</h2>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="content nopadding">
                                <div id="dzielnice_map"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <ul class="pk-dzielnice">
                                <? foreach ($dzielnice as $obj) { ?>
                                    <li><a href="<?= $obj->getUrl() ?>"><?= $obj->getTitle() ?></a></li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="block">
                    <div class="overflow-auto">
                        <div class="col-md-6 nopadding">

                            <div class="block-header">
                                <h2 title="Największe spółki pod względem kapitału zakładowego" class="pull-left label">
                                    Największe spółki</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="<?= Router::url(array('action' => 'organizacje', 'id' => $object->getId())) ?>">Zobacz
                                    wszystkie</a>
                            </div>

                            <div class="content padding">
                                <ul class="raw">
                                    <? foreach ($organizacje as $organizacja) { ?>
                                        <li class="list-group-item"><? if ($organizacja->getData('wartosc_kapital_zakladowy')) { ?>
                                                <span
                                                    class="badge"><?= number_format_h($organizacja->getData('wartosc_kapital_zakladowy')) ?></span><? } ?>
                                            <a href="<?= $organizacja->getUrl() ?>"><?= $this->Text->truncate($organizacja->getShortTitle(), 25); ?></a>
                                        </li>
                                    <? } ?>
                                </ul>

                            </div>

                        </div>

                        <div class="col-md-6 nopadding">
                            <div class="block-header">
                                <h2 title="Organizacje pozarządowe w gminie" class="pull-left label">Organizacje
                                    pozarządowe</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="<?= Router::url(array('action' => 'organizacje', 'id' => $object->getId())) ?>">Zobacz
                                    wszystkie</a>
                            </div>

                            <div class="content padding">
                                <?
                                if (!empty($ngos)) {
                                    ?>
                                    <ul class="raw">
                                        <?
                                        $limit = 5;
                                        $i = 0;

                                        foreach ($ngos as $ngo) {
                                            $i++;
                                            $label = $ngo['label']['buckets'][0]['key'];
                                            ?>

                                            <li class="list-group-item"><span
                                                    class="badge"><?= number_format_h($ngo['doc_count']) ?></span><a
                                                    href="<?= Router::url(array(
                                                        'action' => 'organizacje',
                                                        'id' => $object->getId(),
                                                        '?' => array('forma_prawna_id' => $ngo['key'])
                                                    )) ?>"
                                                    title="<?= addslashes($label) ?>"><?= $this->Text->truncate($label, 25); ?></a>
                                            </li>
                                            <?
                                            if ($i == $limit) {
                                                break;
                                            }
                                        }
                                        ?>
                                    </ul>
                                <?
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>

                <? if ($object->getId() == 903) { ?>

                    <? /*
			    <div id="rada" class="block">
			        <div class="block-header">
			            <h2 class="pull-left label">Posiedzenia rady miasta</h2>
			            <a class="btn btn-default btn-sm pull-right"
			               href="<?= Router::url(array('action' => 'posiedzenia', 'id' => $object->getId())) ?>">Zobacz
			                wszystkie</a>
			        </div>

			        <div class="content">
			            <div class="dataobjectsSliderRow row">
			                <div>
			                    <?php echo $this->dataobjectsSlider->render($rady_posiedzenia, array(
			                        'perGroup' => 3,
			                        'rowNumber' => 1,
			                        'labelMode' => 'none',
			                        'file' => 'rady_posiedzenia-gminy',
			                    )) ?>
			                </div>
			            </div>
			        </div>
			    </div>
			    */
                    ?>

                    <? /*
    <div id="prawo" class="block">
        <div class="block-header">
            <h2 class="pull-left label">Najnowsze uchwały rady miasta</h2>
            <a class="btn btn-default btn-sm pull-right"
               href="<?= Router::url(array('action' => 'rada_uchwaly', 'id' => $object->getId())) ?>">Zobacz
                wszystkie</a>
        </div>

        <div class="content">
            <div class="dataobjectsSliderRow row">
                <div>
                    <?php echo $this->dataobjectsSlider->render($prawo_lokalne, array(
                        'perGroup' => 2,
                        'rowNumber' => 1,
                        'descriptionMode' => 'none',
                    )) ?>
                </div>
            </div>
        </div>
    </div>
    */ ?>

                    <? /*
					            <div id="materialy" class="block">
					                <div class="block-header">
					                    <h2 class="pull-left label">Materiały na posiedzenia rady miasta</h2>
					                    <a class="btn btn-default btn-sm pull-right" href="<?= Router::url(array('action' => 'druki', 'id' => $object->getId())) ?>">Zobacz
					                        wszystkie</a>
					                </div>

					                <div class="content">
					                    <div class="dataobjectsSliderRow row">
					                        <div>
					                            <?php echo $this->dataobjectsSlider->render($rady_druki, array(
					                                'perGroup' => 3,
					                                'rowNumber' => 1,
					                                'labelMode' => 'none',
					                                // 'dfFields' => array('data_publikacji'),
					                            )) ?>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            */
                    ?>


                    <? /*
					            <div class="block">
					            	<div class="row">
						            	<div class="col-lg-6">

						            		<div id="rada">
									            <div class="block-header">
									                <h2 class="label pull-left"><?php echo __d('dane', 'LC_GMINY_WYNIKI_WYBOROW'); ?></h2>
									                <a class="btn btn-default btn-sm pull-right" href="<?= Router::url(array('action' => 'radni', 'id' => $object->getId())) ?>">Zobacz wszystkich radnych</a>
									            </div>

									            <div class="content wynikiWyborow">
									                <?php foreach ($object->getLayer('rada_komitety') as $rada) { ?>
									                    <div class="wynik">
									                        <a href="<?= Router::url(array('action' => 'radni', 'id' => $object->getId(), '?' => array('komitet_id' => $rada['pl_gminy_radni']['komitet_id']))) ?>">
									                            <?php echo $rada['pkw_komitety']['nazwa']; ?>
									                        </a>
									                        <small><?php echo pl_dopelniacz($rada[0]['count'], 'radny', 'radnych', 'radnych'); ?></small>

									                        <div class="progress">
									                            <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="73.3"
									                                 aria-valuemin="0" aria-valuemax="100"
									                                 style="width: <?php echo $rada['percent']; ?>%">
									                            </div>
									                        </div>
									                    </div>
									                <?php } ?>
									            </div>



									        </div>

						            	</div><div class="col-lg-6">



						            	</div>
					            	</div>


					            </div>
					            <? */
                    ?>

                <? } ?>


                <? if (!empty($zamowienia_otwarte)) { ?>
                    <div id="zamowienia_publiczne_otwarte" class="block">
                        <div class="block-header">
                            <h2 class="pull-left label">Najnowsze ogłoszenia o zamówieniach publicznych</h2>
                            <a class="btn btn-default btn-sm pull-right"
                               href="<?= Router::url(array('action' => 'zamowienia', 'id' => $object->getId())) ?>">Zobacz
                                wszystkie</a>
                        </div>

                        <div class="content">
                            <div class="dataobjectsSliderRow row">
                                <div>
                                    <?php echo $this->DataobjectsSlider->render($zamowienia_otwarte, array(
                                        'perGroup' => 2,
                                        'rowNumber' => 1,
                                        'labelMode' => 'none',
                                    )) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>

                <? if (!empty($zamowienia_zamkniete)) { ?>
                    <div id="zamowienia_publiczne_zamkniete" class="block">
                        <div class="block-header">
                            <h2 class="pull-left label">Najnowsze rozstrzygnięcia zamówień publicznych</h2>
                            <a class="btn btn-default btn-sm pull-right"
                               href="<?= Router::url(array('action' => 'zamowienia', 'id' => $object->getId())) ?>">Zobacz
                                wszystkie</a>
                        </div>

                        <div class="content">
                            <div class="dataobjectsSliderRow row">
                                <div>
                                    <?php echo $this->DataobjectsSlider->render($zamowienia_zamkniete, array(
                                        'perGroup' => 2,
                                        'rowNumber' => 1,
                                        'labelMode' => 'none',
                                    )) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>

                <? /*
					        <div id="dotacje_unijne" class="block">
					            <div class="block-header">
					                <h2 class="pull-left label">Dotacje unijne</h2>
					                <a class="btn btn-default btn-sm pull-right" href="<?= Router::url(array('action' => 'dotacje_ue', 'id' => $object->getId())) ?>">Zobacz
					                    wszystkie</a>
					            </div>

					            <div class="content">
					                <div class="dataobjectsSliderRow row">
					                    <div>
					                        <?php echo $this->dataobjectsSlider->render($dotacje_ue, array(
					                            'perGroup' => 2,
					                            'rowNumber' => 1,
					                            'labelMode' => 'none',
					                        )) ?>
					                    </div>
					                </div>
					            </div>
					        </div>
					        */ ?>
            </div>
        </div>
    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
