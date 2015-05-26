<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="col-xs-12 col-md-8">
    <div class="block col-xs-12">
        <header>Najwięcej zamówień otrzymali:</header>
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
                                <header>
                                    <a class="nazwa pull-left" href="#"><?= $wykonawca['nazwa'] ?></a>
                                    <span class="cena pull-right"><?= number_format_h($wykonawca['cena']) ?> PLN</span>
                                </header>

                                <p class="stats"><?= pl_dopelniacz($doc['dokumenty']['doc_count'], 'zamówienie', 'zamówienia', 'zamówień') ?></p>

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

                            </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</div>