<?
echo $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzeniapunkty', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmdebaty', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>
    <div class="object">

        <div class="container dataBrowser debata-wystapienie">


            <div class="row">

                <div class="col-xs-12 col-sm-2 dataFilters update-filters">

                    <div class="header text-right">
                        <h2><a href="<?= $debata->getUrl() ?>">Część #<?= $debata->getData('punkt_i') ?></a></h2>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-10 dataObjects">


                    <div class="innerContainer update-objects" style="min-height: 455px;">

                        <ul class="list-group list-dataobjects">

                            <?= $this->Dataobject->render($wystapienie, 'sejm_debaty-wystapienie'); ?>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>
<?php echo $this->Element('dataobject/pageEnd'); ?>