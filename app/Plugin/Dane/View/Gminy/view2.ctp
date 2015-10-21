<?php
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));

$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-gminy');
?>

<?php if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

    switch (Configure::read('Config.language')) {
        case 'pol':
            $lang = "pl-PL";
            break;
        case 'eng':
            $lang = "en-EN";
            break;
    };
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&language=' . $lang, array('block' => 'scriptBlock'));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow');
} ?>

<? echo $this->Element('dataobject/pageBegin'); ?>

<div class="row">
    <div class="col-md-9 objectMain">
        <div class="object dataBrowser">


            <div class="block">
                <div class="block-header">
                    <h2 class="label">Najwięcej zamówień publicznych otrzymali:</h2>

                    <p class="sublabel">Dane z ostatniego roku.</p>
                </div>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">

                            <ul class="wykonawcy">
                                <?
                                foreach ($object_aggs['all']['dokumenty']['wykonawcy']['id']['buckets'] as $doc) {

                                    $wykonawca = array(
                                        'id' => $doc['key'],
                                        'nazwa' => $doc['nazwa']['buckets'][0]['key'],
                                        'cena' => $doc['cena']['value'],
                                    );
                                    ?>
                                    <li>

                                        <h2 class="smaller">
                                            <a class="nazwa pull-left"
                                               href="#"><?= $this->Text->truncate($wykonawca['nazwa'], 70) ?></a>
                                            <span class="cena pull-right"><?= number_format_h($wykonawca['cena']) ?>
                                                PLN</span>
                                        </h2>

                                        <p class="stats"><?= pl_dopelniacz($doc['dokumenty']['doc_count'], 'zamówienie', 'zamówienia', 'zamówień') ?></p>

                                        <ul class="dataobjects smaller" style="display: none;">
                                            <?
                                            foreach ($doc['dokumenty']['top']['hits']['hits'] as $hit) {

                                                $czesc = false;

                                                if (
                                                    isset($hit['fields']['source'][0]['static']['wykonawcy']) &&
                                                    $hit['fields']['source'][0]['static']['wykonawcy']
                                                ) {
                                                    foreach ($hit['fields']['source'][0]['static']['wykonawcy'] as $w)
                                                        if ($w['id'] == $wykonawca['id'])
                                                            $czesc = $w;
                                                }

                                                echo $this->Dataobject->render($hit, 'zamowienia_publiczne_dokumenty', array(
                                                    'czesc' => $czesc,
                                                ));
                                            }
                                            ?>
                                        </ul>

                                        <? if ($doc['dokumenty']['doc_count'] > 5) { ?>
                                            <div class="buttons">
                                                <a href="#" class="btn btn-primary btn-sm">Więcej</a>
                                            </div>
                                        <? } ?>

                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons">
                                <a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="block">
                <div class="block-header">
                    <h2 class="label">Najnowsze prawo lokalne</h2>
                </div>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($object_aggs['all']['gminy']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($object_aggs['all']['gminy']['top']['hits']['hits'] as $doc) { ?>
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
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
