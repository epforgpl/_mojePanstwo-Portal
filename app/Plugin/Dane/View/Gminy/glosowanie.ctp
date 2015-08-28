<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('krakow_glosowania_votings', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Dane.Krakow_glosowania_votings.js');

$options = array(
    'mode' => 'init',
);

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
?>

<?
echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $glosowanie,
    'objectOptions' => array(
        'bigTitle' => true,
        'truncate' => 1024,
    ),
));
?>

    <div class="dataBrowser">

        <? if (@$aggs['glosy']['top']['hits']['hits']) { ?>
            <div class="row">
                <div class="col-md-8">

                    <div class="block block-default col-xs-12">
                        <header>Wyniki zbiorcze</header>
                        <section>
                            <div class="krakow_glosowania_voting_chart"
                                 data-za="<?= (int)$glosowanie->getData('liczba_glosow_za') ?>"
                                 data-przeciw="<?= (int)$glosowanie->getData('liczba_glosow_przeciw') ?>"
                                 data-nieobecni="<?= (int)$glosowanie->getData('liczba_glosow_nieobecni') ?>"
                                 data-wstrzymanie="<?= (int)$glosowanie->getData('liczba_glosow_wstrzymanie') ?>"></div>
                        </section>
                    </div>

                    <div class="block block-default col-xs-12">
                        <header>Wyniki indywidualne</header>

                        <section class="aggs-init">
                            <div class="dataAggs">
                                <div class="agg agg-Dataobjects">

                                    <ul class="wyniki_glosowania">
                                        <? foreach ($aggs['glosy']['top']['hits']['hits'] as $hit) {
                                            $wynik = $hit['fields']['source'][0]['data'];
                                            ?>

                                            <li class="row">
                                                <div class="col-md-2">
                                                    <a href="/dane/radni_gmin/<?= $wynik['krakow_glosowania_glosy.radny_id'] ?>"
                                                       class="thumb_cont">
                                                        <img
                                                            src="<? if ($wynik['radni_gmin.avatar_id']) { ?>http://resources.sejmometr.pl/avatars/5/<?= $wynik['radni_gmin.avatar_id'] ?>.jpg<? } else { ?>http://resources.sejmometr.pl/avatars/g/m.png<? } ?>"
                                                            class="thumb pull-right">
                                                    </a>
                                                </div>
                                                <div class="col-md-7">
                                                    <p class="title"><a
                                                            href="/dane/radni_gmin/<?= $wynik['krakow_glosowania_glosy.radny_id'] ?>"><?= $wynik['radni_gmin.nazwa'] ?></a>
                                                    </p>

                                                    <p class="desc"><?= $wynik['radni_gmin.komitet'] ?></p>
                                                </div>

                                                <?
                                                $_classes = array(
                                                    '1' => 'success',
                                                    '2' => 'danger',
                                                    '3' => 'primary',
                                                    '4' => 'default'
                                                );
                                                ?>

                                                <div class="col-md-3">
                                                    <p class="label label-<?= $_classes[$wynik['krakow_glosowania_glosy.glos_id']] ?>"><?= $wynik['krakow_glosowania_glosy.glos_str'] ?></p>
                                                </div>
                                            </li>

                                        <? } ?>
                                    </ul>

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        <? } ?>

    </div>


<?
echo $this->Element('dataobject/pageEnd');
?>
