<?
echo //$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzeniapunkty', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmdebaty', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>
    <div class="object debata-wystapienie">

        <div class="container dataBrowser">

            <div class="row">

                <div class="col-xs-12 col-sm-10 col-sm-offset-1 dataObjects">


                    <div class="innerContainer update-objects" style="min-height: 455px;">

                        <ul class="list-group list-dataobjects">

                            <?= $this->Dataobject->render($wystapienie, 'DataBrowser/templates/sejm_debaty-wystapienie'); ?>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>
<?php echo $this->Element('dataobject/pageEnd'); ?>