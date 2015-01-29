<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $druk,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));
?>
	<div class="poslowie row">
        <div class="col-md-3 objectSide">

            <div class="objectSideInner">
				
				<? /*
                <div class="block">

                    <div class="block-header">
                        <h2 class="label">Radni</h2>
                    </div>

                    <ul class="dataHighlights side">

                        <li class="dataHighlight">
                            <a href="<?= $object->getUrl() . '/radni' ?>"><span class="icon icon-moon">&#xe617;</span>Radni
                                Miasta <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                        <li class="dataHighlight">
                            <a href="<?= $object->getUrl() . '/radni_powiazania' ?>"><span class="icon icon-moon">&#xe611;</span>Powiązania
                                radnych w KRS <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                        <li class="dataHighlight">
                            <a href="<?= $object->getUrl() . '/interpelacje' ?>"><span
                                    class="icon icon-moon">&#xe614;</span>Interpelacje radnych <span
                                    class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                    </ul>
                </div>

                <div class="block">

                    <div class="block-header">
                        <h2 class="label">Prace Rady Miasta</h2>
                    </div>

                    <a title="Posiedzenia Rady Miasta Kraków" href="<?= $object->getUrl() . '/posiedzenia' ?>"><img
                            src="http://img.youtube.com/vi/AR9UYwp7PQA/mqdefault.jpg" style="width: 100%;"></a>

                    <ul class="dataHighlights side">

                        <li class="dataHighlight">
                            <a href="<?= $object->getUrl() . '/posiedzenia' ?>"><span
                                    class="icon icon-moon">&#xe615;</span>Posiedzenia <span
                                    class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                        <li class="dataHighlight">
                            <a href="<?= $object->getUrl() . '/druki' ?>"><span class="icon icon-moon">&#xe614;</span>Materiały
                                na posiedzenia <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                        <li class="dataHighlight">
                            <a href="<?= $object->getUrl() . '/rada_uchwaly' ?>"><span
                                    class="icon icon-moon">&#xe614;</span>Uchwały Rady Miasta <span
                                    class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                    </ul>
                </div>

                <div class="block">

                    <div class="block-header">
                        <h2 class="label">Komisje Rady Miasta</h2>
                    </div>

                    <ul class="dataHighlights side">

                        <li class="dataHighlight">
                            <a href="<?= $object->getUrl() . '/komisje?krakow_komisje:kadencja_id[]=7&search=web' ?>"><span class="icon icon-moon">&#xe613;</span>Lista
                                komisji <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                        <li class="dataHighlight">
                            <a href="<?= $object->getUrl() . '/komisje_posiedzenia' ?>"><span class="icon icon-moon">&#xe615;</span>Posiedzenia
                                komisji <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                    </ul>
                </div>
				<? */?>

            </div>

        </div>
        <div class="col-md-7 nopadding">
            <div class="object">
                <?= $this->dataobject->feed($feed); ?>
            </div>
        </div>
        <div class="col-md-2">

        </div>
    </div>

<?
/*
echo $this->Element('docsBrowser/doc', array(
    'document' => $document,
    'documentPackage' => $documentPackage,
));
*/

echo $this->Element('dataobject/pageEnd');