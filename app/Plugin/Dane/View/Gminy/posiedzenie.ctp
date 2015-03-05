<?
echo $this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
echo $this->Combinator->add_libs('js', 'Dane.view-gminy-posiedzenie');
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $posiedzenie,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
        'routes' => array(
            'shortTitle' => 'pageTitle'
        ),
    ),
    'back' => array(
        'href' => '/dane/gminy/903,krakow/posiedzenia',
        'title' => 'Wszystkie posiedzenia rady miasta',
    ),
));
?>

    <div class="posiedzenie row">
        <div class="col-md-3 objectSide">
            <div class="objectSideInner">
                <ul class="dataHighlights side">


                    <li class="dataHighlight big">
                        <p class="_label">Liczba punktów porządku dziennego</p>

                        <div>
                            <p class="_value pull-left"><?= $posiedzenie->getData('liczba_punktow'); ?></p>

                            <p class="pull-right nopadding"><a class="btn btn-sm btn-default"
                                                               href="/dane/gminy/903/posiedzenia/<?= $posiedzenie->getId() ?>/punkty">Zobacz &raquo;</a>
                            </p>
                        </div>
                    </li>


                </ul>

            </div>
        </div>


        <div class="col-md-9 objectMain">


            <div class="object mpanel">

                <div class="block-group">


                    <? if ($projekty_za) { ?>
                        <div id="projekty_za" class="block">
                            <div class="block-header">
                                <h2 class="label za pull-left">Projekty, za którymi głosował poseł</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="/dane/poslowie/<?= $object->getId() ?>/prawo_projekty_za">Zobacz wszystkie</a>
                            </div>

                            <div class="content">
                                <div class="dataobjectsSliderRow row">
                                    <div>
                                        <?php echo $this->dataobjectsSlider->render($projekty_za, array(
                                            'perGroup' => 2,
                                            'rowNumber' => 1,
                                            'dfFields' => array('data'),
                                        )) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>

                    <? if ($projekty_przeciw) { ?>
                        <div id="projekty_przeciw" class="block">
                            <div class="block-header">
                                <h2 class="label przeciw pull-left">Projekty, przeciwko którym głosował poseł</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="/dane/poslowie/<?= $object->getId() ?>/prawo_projekty_przeciw">Zobacz
                                    wszystkie</a>
                            </div>

                            <div class="content">
                                <div class="dataobjectsSliderRow row">
                                    <div>
                                        <?php echo $this->dataobjectsSlider->render($projekty_przeciw, array(
                                            'perGroup' => 2,
                                            'rowNumber' => 1,
                                            'dfFields' => array('data'),
                                        )) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>

                    <? if ($projekty_wstrzymania) { ?>
                        <div id="projekty_wstrzymania" class="block">
                            <div class="block-header">
                                <h2 class="label wstrzymanie pull-left">Projekty, nad którymi poseł wstrzymał się od
                                    głosu</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="/dane/poslowie/<?= $object->getId() ?>/prawo_projekty_wstrzymanie">Zobacz
                                    wszystkie</a>
                            </div>

                            <div class="content">
                                <div class="dataobjectsSliderRow row">
                                    <div>
                                        <?php echo $this->dataobjectsSlider->render($projekty_wstrzymania, array(
                                            'perGroup' => 2,
                                            'rowNumber' => 1,
                                            'dfFields' => array('data'),
                                        )) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>

                    <? if ($poslowie_nieobecni) { ?>
                        <div id="projekty_nieobecni" class="block">
                            <div class="block-header">
                                <h2 class="label nieobecnosc pull-left">Projekty, dla których poseł nie przyszedł na
                                    głosowanie</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="/dane/poslowie/<?= $object->getId() ?>/prawo_projekty_nieobecnosc">Zobacz
                                    wszystkie</a>
                            </div>

                            <div class="content">
                                <div class="dataobjectsSliderRow row">
                                    <div>
                                        <?php echo $this->dataobjectsSlider->render($poslowie_nieobecni, array(
                                            'perGroup' => 2,
                                            'rowNumber' => 1,
                                            'dfFields' => array('data'),
                                        )) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>

                    <? if (($terms = $posiedzenie->getLayer('terms')) && !empty($terms)) { ?>
                        <div class="block">
                            <div class="block-header">
                                <h2 class="label">Tematy posiedzenia</h2>
                            </div>

                            <ul class="objectTagsCloud row">
                                <?

                                $font = array(
                                    'min' => 15,
                                    'max' => 100,
                                );
                                $font['diff'] = $font['max'] - $font['min'];


                                foreach ($terms as &$term) {
                                    $term['size'] = $font['min'] + $font['diff'] * $term['norm_score'];
                                }


                                shuffle($terms);


                                foreach ($terms as $term) {
                                    $href = '/dane/gminy/903/posiedzenia/' . $posiedzenie->getId() . '/punkty?q=' . addslashes($term['key']);
                                    ?>
                                    <li style="font-size: <?= $term['size'] ?>px;"><a
                                            href="<?= $href ?>"><?= $term['key'] ?></a></li>
                                <? } ?>
                            </ul>

                        </div>
                    <? } ?>



                    <? /*
	            	<? if ($wystapienia) { ?>
                    <div id="wystapienia" class="block">
                        <div class="block-header">
                            <h2 class="label pull-left">Wystąpienia w Sejmie</h2>
                            <a class="btn btn-default btn-sm pull-right"
                               href="/dane/poslowie/<?= $object->getId() ?>/wystapienia">Zobacz wszystkie</a>
                        </div>

                        <div class="content">
                            <div class="dataobjectsSliderRow row">
                                <div>
                                    <?php echo $this->dataobjectsSlider->render($wystapienia, array(
                                        'perGroup' => 3,
                                        'rowNumber' => 1,
                                        'labelMode' => 'none',
                                        'dfFields' => array('data'),
                                    )) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>

                <? if ($interpelacje) { ?>
                    <div id="interpelacje" class="block">
                        <div class="block-header">
                            <h2 class="label pull-left">Interpelacje</h2>
                            <a class="btn btn-default btn-sm pull-right"
                               href="/dane/poslowie/<?= $object->getId() ?>/interpelacje">Zobacz wszystkie</a>
                        </div>

                        <div class="content">
                            <div class="dataobjectsSliderRow row">
                                <div>
                                    <?php echo $this->dataobjectsSlider->render($interpelacje, array(
                                        'perGroup' => 3,
                                        'rowNumber' => 1,
                                        'labelMode' => 'none',
                                        'dfFields' => array('data_wplywu'),
                                    )) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>

                <? if ($projekty_ustaw) { ?>
                    <div id="wystapienia" class="block">
                        <div class="block-header">
                            <h2 class="label pull-left">Podpisane projekty ustaw</h2>
                            <a class="btn btn-default btn-sm pull-right"
                               href="/dane/poslowie/<?= $object->getId() ?>/projekty_ustaw">Zobacz wszystkie</a>
                        </div>

                        <div class="content">
                            <div class="dataobjectsSliderRow row">
                                <div>
                                    <?php echo $this->dataobjectsSlider->render($projekty_ustaw, array(
                                        'perGroup' => 3,
                                        'rowNumber' => 1,
                                        'labelMode' => 'none',
                                        'dfFields' => array('data'),
                                    )) ?>
                                </div>
                            </div>
                        </div>

                    </div>
                <? } ?>

                <? if ($glosowania) { ?>
                    <div id="glosowania" class="block">
                        <div class="block-header">
                            <h2 class="label pull-left">Wyniki głosowań</h2>
                            <a class="btn btn-default btn-sm pull-right"
                               href="/dane/poslowie/<?= $object->getId() ?>/glosowania">Zobacz wszystkie</a>
                        </div>

                        <div class="content">
                            <div class="dataobjectsSliderRow row">
                                <div>
                                    <?php echo $this->dataobjectsSlider->render($glosowania, array(
                                        'perGroup' => 3,
                                        'rowNumber' => 1,
                                        'labelMode' => 'none',
                                        'dfFields' => array('sejm_glosowania.czas'),
                                        'file' => 'poslowie_glosy-poslowie',
                                    )) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
                <? */
                    ?>

                </div>


            </div>
            <div class="objectSearch">
                <div class="input-group">
                    <form method="get" action="/dane/poslowie/<?= $object->getId() ?>/wystapienia">
                        <input type="text"
                               placeholder="Szukaj w posiedzeniu...<?= $object->getData('dopelniacz'); ?>..."
                               autocomplete="off" class="form-control ui-autocomplete-input" name="q">
                        <input type="submit" style="display: none;" name="submit" value="search">
				            <span class="input-group-btn">
				                <button data-icon="" type="button" class="btn btn-success btn-lg"></button>
				            </span>
                    </form>
                </div>
            </div>

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');