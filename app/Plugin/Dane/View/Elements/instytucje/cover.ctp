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

    <div class="blocks">

        <? if (@$dataBrowser['aggs']['all']['prawo']['top']['hits']['hits']) { ?>
            <div class="block block-simple col-xs-12">
                <header>Najnowsze akty prawne:</header>

                <section class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits'] as $doc) { ?>
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

                </section>
            </div>
        <? } ?>


        <? if (@$dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits']) { ?>
            <div class="block block-simple col-xs-12">
                <header>Najnowsze pozycje w dzienniku urzędowym:</header>

                <section class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits'] as $doc) { ?>
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

                </section>
            </div>
        <? } ?>


        <? if (@$dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits']) { ?>
            <div class="block block-simple col-xs-12">
                <header>Najnowsze zamówienia publiczne:</header>

                <section class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits'] as $doc) { ?>
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

                </section>
            </div>
        <? } ?>


        <? if (@$dataBrowser['aggs']['all']['dokumenty']['wykonawcy']['id']['buckets']) { ?>
            <div class="block block-simple col-xs-12">
                <header>Najwięcej zamówień publicznych otrzymali:</header>

                <section class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">

                            <ul class="wykonawcy">
                                <?
                                foreach ($dataBrowser['aggs']['all']['dokumenty']['wykonawcy']['id']['buckets'] as $doc) {

                                    $wykonawca = array(
                                        'id' => $doc['key'],
                                        'nazwa' => $doc['nazwa']['buckets'][0]['key'],
                                        'cena' => $doc['cena']['value'],
                                    );
                                    ?>
                                    <li>
                                        <a class="nazwa pull-left"
                                           href="#"><?= $this->Text->truncate($wykonawca['nazwa'], 70) ?></a>
                                            <span class="cena pull-right"><?= number_format_h($wykonawca['cena']) ?>
                                                PLN</span>

                                        <p class="stats"><?= pl_dopelniacz($doc['dokumenty']['doc_count'], 'zamówienie', 'zamówienia', 'zamówień') ?></p>

                                        <div style="display: none;">
                                            <ul class="dataobjects smaller">
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
                                        </div>

                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons">
                                <a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        <? } ?>

    </div>

</div>