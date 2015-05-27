<?

$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzenia', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzenia-databrowser-fix', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');

?>


    <div id="punkty_cont" class="col-lg-10 col-lg-offset-1 punkty margintop">

        <? if ($punkty) { ?>
            <div class="block">

                <div class="content">

                    <ul id="punkty">
                        <? foreach ($punkty as $punkt) { ?>
                            <li class="row">
                                <div class="col-md-1 counter text-center">

                                    <p class="">#<?= $punkt->getData('numer') ?></p>

                                </div>
                                <div class="col-md-9 display">


                                    <h3>
                                        <a href="/dane/sejm_posiedzenia_punkty/<?= $punkt->getId() ?>"><?= $punkt->getData('tytul') ?></a>
                                    </h3>

                                    <p class="stats">
                                        <? if ($punkt->getData('liczba_wystapien')) { ?>
                                            <object data="/error/brak.gif" type="image/png">
                                                <img
                                                    src="http://resources.sejmometr.pl/stenogramy/punkty/<?= $punkt->getId() ?>.jpg"/>
                                            </object>
                                        <? } ?>
                                        <?= $punkt->getData('stats_str') ?>
                                    </p>


                                </div>
                                <div class="col-md-2">

                                    <p class="status"><?= $punkt->getData('opis') ?></p>

                                </div>
                            </li>
                        <? } ?>
                    </ul>

                </div>
            </div>
        <? } ?>

    </div>


<?= $this->Element('dataobject/pageEnd'); ?>