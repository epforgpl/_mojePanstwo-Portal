<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('sejmometr', array('plugin' => 'Sejmometr'))) ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('katalog', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('prace', array('plugin' => 'Sejmometr'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>

<?php $this->Combinator->add_libs('js', 'Dane.dataobjectsslider') ?>
<?php $this->Combinator->add_libs('js', 'Sejmometr.sejmometr.js'); ?>

<div id="sejmometr" class="newLayout">

    <div class="headline strip">
        <div class="container">
            <h1 class="header text-center"><a href="/sejmometr">Sejmometr</a></h1>

            <div class="content-container col-xs-12">

                <h5>Sejm jest organem władzy ustawodawczej w Polsce. Tworzą go posłowie, którzy są reprezentantami
                    Narodu
                    dlatego mogą, a nawet powinni być przez ten Naród oceniani. Szerokie udostępnianie informacji o
                    poselskich działaniach leży w interesie każdego z 460 posłów. Obywatele nie mający dostępu do takich
                    danych swoje poglądy wyrobią w oparciu o inne, niekoniecznie obiektywne źródła informacji.
                    Postanowiliśmy wesprzeć tych, którzy chcieliby wiedzieć jak pracują nasi posłowie i w jakich
                    warunkach
                    wykonują swój mandat poselski. Stworzyliśmy aplikację, która prezentuje rozmaite dane związane z
                    sejmową
                    codziennością!

                </h5>


                <div class="row sejm-menu">
                    <div class="col-lg-4 link">
                        <a class="poslowie" href="/dane/poslowie"><span>Znajdź<br/>i sprawdź swojego posła!</span></a>
                    </div>
                    <div class="col-lg-4 link">
                        <a class="projekty" href="/sejmometr/prace"><span>Projekty aktów prawnych</span></a>
                    </div>
                    <div class="col-lg-4 link">
                        <a class="posiedzenia" href="/sejmometr/posiedzenia"><span>Posiedzenia Sejmu</span></a>
                    </div>
                    <? /*
                <div class="col-lg-3 link">
                    <a class="koszty" href="/sejmometr/info"><span>Ile to kosztuje?</span></a>
                </div>
                */
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="channels">
        <?php
        $q = '';
        $di = 0;
        foreach ($chapters as $chapter) {
            if (!empty($chapter['search']['dataobjects'])) {
                ?>
                <div class="stripe<? if ($di % 2) { ?> odd<? } ?>">
                    <div class="container">
                        <div class="catalog content">
                            <div class="catalogSquares">
                                <div class="col-xs-12">

                                    <div class="datachannel row">

                                        <div class="col-lg-12 header-row">
                                            <h2 class="pull-left">
                                                <a href="<?= $chapter['search']['href'] ?>"><?php echo $chapter['title']; ?>
                                                    <?
                                                    /*
                                                    if (@$datachannel['count']) {
                                                        ?>
                                                        <small><?= pl_dopelniacz($datachannel['count'], 'wynik', 'wyniki', 'wyników') ?> &raquo;</small>
                                                    <? } */
                                                    ?>
                                                </a>
                                            </h2>
                                            <a class="pull-right btn btn-default"
                                               href="<?= $chapter['search']['href'] ?>">Zobacz wszystkie</a>
                                        </div>

                                        <div class="dataobjectsSliderRow">
                                            <div class="col-xs-12">
                                                <?php echo $this->dataobjectsSlider->render($chapter['search']['dataobjects'], array(
                                                    'perGroup' => 3,
                                                    'rowNumber' => 1,
                                                    'dfFields' => array(
                                                        'data'
                                                    ),
                                                )) ?>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            $di++;
        }
        ?>
    </div>