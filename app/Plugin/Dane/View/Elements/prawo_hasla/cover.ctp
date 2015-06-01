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

	<? if( @$dataBrowser['aggs']['ustawy']['top']['hits']['hits'] ) {?>
    <div class="block block-simple">
        <header>Ustawy</header>
        <section class="aggs-init">

            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['ustawy']['top']['hits']['hits']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['ustawy']['top']['hits']['hits'] as $doc) { ?>
                                <li>
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>

                </div>
            </div>
        </section>
        <footer>
            <div class="buttons text-center">
                <a href="<?= $object->getUrl() ?>/posiedzenia" class="btn btn-primary btn-sm">Więcej
                    posiedzeń</a>
            </div>
        </footer>
    </div>
    <? } ?>
    
    <? if( @$dataBrowser['aggs']['rozporzadzenia']['top']['hits']['hits'] ) {?>
    <div class="block block-simple">
        <header>Rozporządzenia</header>
        <section class="aggs-init">

            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['rozporzadzenia']['top']['hits']['hits']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['rozporzadzenia']['top']['hits']['hits'] as $doc) { ?>
                                <li>
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>

                </div>
            </div>
        </section>
        <footer>
            <div class="buttons text-center">
                <a href="<?= $object->getUrl() ?>/posiedzenia" class="btn btn-primary btn-sm">Więcej
                    posiedzeń</a>
            </div>
        </footer>
    </div>
    <? } ?>
    
    <? if( @$dataBrowser['aggs']['inne']['top']['hits']['hits'] ) {?>
    <div class="block block-simple">
        <header>Pozostałe akty prawne</header>
        <section class="aggs-init">

            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['inne']['top']['hits']['hits']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['inne']['top']['hits']['hits'] as $doc) { ?>
                                <li>
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>

                </div>
            </div>
        </section>
        <footer>
            <div class="buttons text-center">
                <a href="<?= $object->getUrl() ?>/posiedzenia" class="btn btn-primary btn-sm">Więcej
                    posiedzeń</a>
            </div>
        </footer>
    </div>
    <? } ?>


</div>