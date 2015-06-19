<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="col-md-8">

    <div class="databrowser-panels">

        <? if ($object->getId() == 903) { ?>

            <div class="databrowser-panel">
                <h2>Radni rady miasta Kraków:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['radni']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects row">
                                    <? foreach ($dataBrowser['aggs']['all']['radni']['top']['hits']['hits'] as $doc) { ?>
                                        <li class="col-md-6">
                                            <?
                                            echo $this->Dataobject->render($doc, 'krakow_radni');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                            <? } ?>

                        </div>
                    </div>


                </div>
            </div>



            <div class="databrowser-panel">
                <h2>Najnowsze projekty legislacyjne pod obrady rady:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['rada_projekty']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['all']['rada_projekty']['top']['hits']['hits'] as $doc) { ?>
                                        <li>
                                            <?
                                            echo $this->Dataobject->render($doc, 'default');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                                <div class="buttons">
                                    <a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
                                </div>
                            <? } ?>

                        </div>
                    </div>


                </div>
            </div>



        <? } ?>


        <div class="databrowser-panel">
            <h2>Najnowsze interpelacje radnych:</h2>

            <div class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['interpelacje']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['interpelacje']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons">
                                <a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
                            </div>
                        <? } ?>

                    </div>
                </div>


            </div>
        </div>

    </div>

</div>
<div class="col-md-4">

    <div class="databrowser-panels">

        <div class="databrowser-panel">
            <h2>Najnowsze posiedzenia Rady Miasta Kraków:</h2>

            <div class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['rada_posiedzenia']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['rada_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'krakow_posiedzenia_icon');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons">
                                <a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
                            </div>
                        <? } ?>

                    </div>
                </div>


            </div>
        </div>

    </div>

</div>