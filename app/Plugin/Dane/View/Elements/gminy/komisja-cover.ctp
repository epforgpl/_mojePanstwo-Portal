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
                <h2>Najnowsze posiedzenia komisji:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
                                        <li>
                                            <?
                                            echo $this->Dataobject->render($doc, 'default');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                                <div class="buttons">
                                    <a href="<?= $komisja->getUrl() ?>/posiedzenia" class="btn btn-primary btn-sm">Zobacz
                                        więcej</a>
                                </div>
                            <? } ?>

                        </div>
                    </div>


                </div>
            </div>

            <div class="databrowser-panel">
                <h2>Skład komisji:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['radni']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects row">
                                    <? foreach ($dataBrowser['aggs']['radni']['top']['hits']['hits'] as $doc) {

                                        $stanowisko = false;
                                        foreach ($doc['fields']['komisje'][0] as $s)
                                            if ($s['komisja_id'] == $komisja->getId())
                                                $stanowisko = $s;

                                        ?>
                                        <li class="col-md-6">
                                            <?
                                            echo $this->Dataobject->render($doc, 'krakow_radni_komisje', $stanowisko);
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                            <? } ?>

                        </div>
                    </div>


                </div>
            </div>

        <? } ?>

    </div>

</div>