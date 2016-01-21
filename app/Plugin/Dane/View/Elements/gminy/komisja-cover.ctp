<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>

<div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
	<div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

    <? if(isset($_submenu) && isset($_submenu['items'])) {

        if (!isset($_submenu['base']))
            $_submenu['base'] = $komisja->getUrl();

        echo $this->Element('Dane.DataBrowser/browser-menu', array(
            'menu' => $_submenu,
        ));

    } ?>
    
	</div>
</div>
<div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
	<div class="dataWrap">
		
		<? if ($object->getId() == 903) { ?>

            <div class="databrowser-panel margin-top-20">
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
                                    <a href="<?= $komisja->getUrl() ?>/posiedzenia" class="btn btn-primary btn-xs">Zobacz
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
