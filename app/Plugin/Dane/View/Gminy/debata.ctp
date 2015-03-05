<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

$this->Combinator->add_libs('css', $this->Less->css('view-radygmindebaty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-radygmindebaty');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));


echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $debata,
    'objectOptions' => array(
        'hlFields' => array('rady_gmin_posiedzenia.numer', 'numer_punktu'),
        'bigTitle' => true,
    ),
    'back' => array(
        'href' => '/dane/gminy/903,krakow/posiedzenia/' . $debata->getData('krakow_posiedzenia.id'),
        'title' => 'Wszystkie punkty podczas posiedzenia nr ' . $debata->getData('krakow_posiedzenia.numer') . ', sesja ' . $debata->getData('krakow_sesje.str_numer'),
    ),
));
?>

<? if ($debata->getData('yt_video_id')) { ?>
    <div id="ytVideoCont" class="row">
        <div class="<? if ($wystapienia) { ?>col-md-7 text-right<? } else { ?>col-md-9 col-md-offset-3<? } ?>">
            <div id="ytVideo" class="row">
                <div id="player" data-youtube="<?php echo $debata->getData('yt_video_id'); ?>"></div>
            </div>
        </div>

        <? if ($wystapienia) { ?>
            <div class="col-md-5 wystapienia">

                <div class="block">

                    <div class="block-header">
                        <h2 class="label"><?php echo __d('dane', 'LC_RADYGMINDEBATY_WYSTAPIENIA'); ?></h2>
                    </div>

                    <div class="content nopadding">
                        <ul class="nav nav-pills nav-stacked">
                            <?php foreach ($wystapienia as $id => $wystapienie) { ?>
                                <li>
                                    <a data-video-position="<?php echo $wystapienie['video_start']; ?>"
                                       href="#<?php echo $wystapienie['id']; ?>">
                                        <span><?php echo (date('H', $wystapienie['video_start']) - 1) . date(':i:s', $wystapienie['video_start']); ?></span> <?php echo $wystapienie['mowca_str']; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <? } ?>

    </div>
<? } ?>


    <div class="gminy">
        <div class="col-md-3 objectSide">

            <div class="objectSideInner">

                <ul class="dataHighlights side">


                    <? if ($debata->getData('krakow_glosowania.wynik_str')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Wynik głosowania</p>

                            <?
                            $class = 'default';
                            if ($debata->getData('krakow_glosowania.wynik_id') == 1) {
                                $class = 'success';
                            } elseif ($debata->getData('krakow_glosowania.wynik_id') == 2) {
                                $class = 'danger';
                            }
                            ?>

                            <div>
                                <p class="_value"><span
                                        class="label label-<?= $class ?>"><?= $debata->getData('krakow_glosowania.wynik_str') ?></span>
                                </p>
                            </div>
                        </li>
                    <? } ?>




                    <? if ($debata->getData('krakow_glosowania.liczba_glosow_za')) { ?>
                        <li class="dataHighlight big topborder">
                            <p class="_label">Liczba głosów "Za"</p>

                            <div>
                                <p class="_value"><?= $debata->getData('krakow_glosowania.liczba_glosow_za') ?></p>
                            </div>
                        </li>
                    <? } ?>

                    <? if ($debata->getData('krakow_glosowania.liczba_glosow_przeciw')) { ?>
                        <li class="dataHighlight big">
                            <p class="_label">Liczba głosów "Przeciw"</p>

                            <div>
                                <p class="_value"><?= $debata->getData('krakow_glosowania.liczba_glosow_przeciw') ?></p>
                            </div>
                        </li>
                    <? } ?>

                    <? if ($debata->getData('krakow_glosowania.liczba_glosow_wstrzymanie')) { ?>
                        <li class="dataHighlight big">
                            <p class="_label">Liczba wstrzymań od głosowania</p>

                            <div>
                                <p class="_value"><?= $debata->getData('krakow_glosowania.liczba_glosow_wstrzymanie') ?></p>
                            </div>
                        </li>
                    <? } ?>

                    <? if ($debata->getData('krakow_glosowania.liczba_nieobecni')) { ?>
                        <li class="dataHighlight big">
                            <p class="_label">Liczba nieobecnych</p>

                            <div>
                                <p class="_value"><?= $debata->getData('krakow_glosowania.liczba_nieobecni') ?></p>
                            </div>
                        </li>
                    <? } ?>

                    <? if ($debata->getData('krakow_glosowania.liczba_nieglosowali')) { ?>
                        <li class="dataHighlight big topborder">
                            <p class="_label">Liczba radnych, którzy nie głosowali</p>

                            <div>
                                <p class="_value"><?= $debata->getData('krakow_glosowania.liczba_nieglosowali') ?></p>
                            </div>
                        </li>
                    <? } ?>



                    <? if ($debata->getData('krakow_glosowania.typ_str')) { ?>
                        <li class="dataHighlight topborder">
                            <p class="_label">Typ głosowania</p>

                            <div>
                                <p class="_value"><?= $debata->getData('krakow_glosowania.typ_str') ?></p>
                            </div>
                        </li>
                    <? } ?>

                    <? if ($debata->getData('krakow_glosowania.rodzaj_str')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Rodzaj głosowania</p>

                            <div>
                                <p class="_value"><?= $debata->getData('krakow_glosowania.rodzaj_str') ?></p>
                            </div>
                        </li>
                    <? } ?>


                    <? if ($debata->getData('href')) { ?>
                        <li class="dataHighlight">
                            <p class="_value" id="sources"><a href="<?= $debata->getData('href') ?>">Źródło</a></p>
                        </li>
                    <? } ?>


                </ul>

            </div>
        </div>


        <div class="col-md-9 objectMain">
            <div class="object">


                <div class="block-group">

                    <? if ($debata->getData('druk_id')) { ?>

                        <div class="block">
                            <div class="block-header">
                                <h2 class="label"><? if ($debata->getData('glosowanie_id')) { ?>Przedmiot głosowania<? } else { ?>Przedmiot obrad<? } ?></h2>
                            </div>

                            <div class="content padding">

                                <div class="objectRender">
                                    <div class="row">
                                        <div class="formatDate col-xs-2 col-lg-1 dimmed">
                                            <span>18</span>

                                            <p>Mar 2014</p></div>
                                        <div class="data col-xs-10 col-lg-11">
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-3 attachment col-md-2 text-center">
                                                    <a href="/dane/rady_druki/<?= $debata->getData('rady_druki.id') ?>"
                                                       class="thumb_cont">
                                                        <img
                                                            src="http://docs.sejmometr.pl/thumb/1/<?= $debata->getData('rady_druki.dokument_id') ?>.png"
                                                            onerror="imgFixer(this)" class="thumb pull-right">
                                                    </a>
                                                </div>
                                                <div class="content col-xs-8 col-sm-9 col-md-10">
                                                    <p class="title">
                                                        <a href="/dane/rady_druki/<?= $debata->getData('rady_druki.id') ?>"><?= $debata->getData('rady_druki.tytul') ?></a>
                                                    </p>

                                                    <div class="description">
                                                        <?
                                                        $opis = $debata->getData('rady_druki.opis');
                                                        if ($opis) {

                                                            $p = stripos($opis, ' /');
                                                            if ($p) {
                                                                $opis = substr($opis, $p + 2);
                                                            }

                                                            echo $opis;

                                                        }
                                                        ?>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <? } ?>

                    <? if ($debata->getData('glosowanie_id') && ($wyniki = $debata->getLayer('wyniki_glosowania'))) { ?>

                        <div class="block">
                            <div class="block-header">
                                <h2 class="label">Indywidualne wyniki głosowania</h2>
                            </div>

                            <div class="content">

                                <ul class="wyniki_glosowania">
                                    <? foreach ($wyniki as $wynik) { ?>

                                        <li class="row">
                                            <div class="col-md-2">
                                                <a href="/dane/radni_gmin/<?= $wynik['radny_id'] ?>" class="thumb_cont">
                                                    <img
                                                        src="<? if ($wynik['avatar_id']) { ?>http://resources.sejmometr.pl/avatars/5/<?= $wynik['avatar_id'] ?>.jpg<? } else { ?>http://resources.sejmometr.pl/avatars/g/m.png<? } ?>"
                                                        class="thumb pull-right">
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <p class="title"><a
                                                        href="/dane/radni_gmin/<?= $wynik['radny_id'] ?>"><?= $wynik['nazwa'] ?></a>
                                                </p>

                                                <p class="desc"><?= $wynik['komitet'] ?></p>
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
                                                <p class="label label-<?= $_classes[$wynik['glos_id']] ?>"><?= $wynik['glos_str'] ?></p>
                                            </div>
                                        </li>

                                    <? } ?>
                                </ul>

                            </div>
                        </div>

                    <? } ?>

                </div>


            </div>

        </div>
    </div>



<?
echo $this->Element('dataobject/pageEnd');
?>