<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
//$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
//$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>

<div class="col-md-9">
	
	<?= $this->Element('searcher', array(
        'q' => isset($this->request->query['q']) ? $this->request->query['q'] : '',
        'autocompletion' => false,
        'placeholder' => 'Szukaj w danych publicznych gminy ' . $object->getTitle() . '...',
        // 'url' => $url,
        // 'dataBrowser' => isset($dataBrowser) ? $dataBrowser : false,
        'searchTag' => false,
        'size' => 'md',
    )) ?>
	
    <? /* if (isset($_submenu) && !empty($_submenu)) { ?>
        <div class="menuTabsCont col-xs-8">
            <?
            if (!isset($_submenu['base']))
                $_submenu['base'] = $object->getUrl();
            echo $this->Element('Dane.dataobject/menuTabs', array(
                'menu' => $_submenu,
            ));
            ?>
        </div>
    <? } */ ?>
    <? if ($object->getId() == 903) { ?>
		
        <div class="block block-simple block-size-sm col-xs-12">
            <header>Najnowsze projekty legislacyjne pod obrady rady</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['rada_projekty']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['rada_projekty']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons">
                                <a href="<?= $object->getUrl() ?>/druki" class="btn btn-primary btn-xs">Zobacz więcej</a>
                            </div>
                        <? } ?>

                    </div>
                </div>
            </section>
        </div>

        <div class="block block-simple block-size-sm col-xs-12">
            <header>Najnowsze uchwały Rady</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['krakow_rada_uchwaly']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['krakow_rada_uchwaly']['top']['hits']['hits'] as $doc) { ?>
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
            <? if ($dataBrowser['aggs']['krakow_rada_uchwaly']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons text-center">
                        <a href="<?= $object->getUrl() ?>/rada_uchwaly" class="btn btn-primary btn-xs">Zobacz
                            więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>

        <div class="block block-simple block-size-sm col-xs-12">
            <header>Najnowsze interpelacje radnych</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['interpelacje']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['interpelacje']['top']['hits']['hits'] as $doc) { ?>
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
            <? if ($dataBrowser['aggs']['interpelacje']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons text-center">
                        <a href="<?= $object->getUrl() ?>/interpelacje" class="btn btn-primary btn-xs">Zobacz
                            więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>


    <? } else { ?>

		<? if (@$dataBrowser['aggs']['prawo']['top']['hits']['hits']) { ?>
        <div class="block block-simple block-size-sm col-xs-12">
            <header>Najnowsze prawo lokalne</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">

                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['prawo']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons btn-sm text-center">
		                        <a href="<?= $object->getUrl() ?>/prawo" class="btn btn-primary btn-xs">Zobacz więcej</a>
		                    </div>

                    </div>
                </div>
            </section>
        </div>
	    <? } ?>

    <? } ?>

    <? if( @$dataBrowser['aggs']['dzialania']['top']['hits']['hits'] ) {?>
        <div class="block block-simple col-xs-12 dzialania">
            <header>Działania</header>
            <section class="content">
                <? foreach ($dataBrowser['aggs']['dzialania']['top']['hits']['hits'] as $dzialanie) { ?>
                    <div class="col-sm-6">
                        <h4>
                            <a href="/dane/gminy/<?= $object->getId(); ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>">
                                <?= $this->Text->truncate($dzialanie['fields']['source'][0]['data']['dzialania.tytul'], 100); ?>
                            </a>
                        </h4>

                        <? if ($dzialanie['fields']['source'][0]['data']['dzialania.photo'] == '1') { ?>
                            <div class="photo">
                                <a href="/dane/krs_podmioty/<?= $object->getId(); ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>"><img
                                        alt="<?= $dzialanie['fields']['source'][0]['data']['dzialania.tytul']; ?>"
                                        src="http://sds.tiktalik.com/portal/2/pages/dzialania/<?= $dzialanie['fields']['id'][0]; ?>.jpg"/></a>
                            </div>
                        <? } ?>

                        <div class="desc">
                            <?= $this->Text->truncate($dzialanie['fields']['source'][0]['data']['dzialania.podsumowanie'], 200) ?>
                        </div>
                    </div>
                <? } ?>
            </section>
        </div>
    <? } ?>

    <? if (@$dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets']) { ?>
        <div class="block block-simple block-size-sm col-xs-12">
            <header>Rozstrzygnięcia zamówień publicznych:</header>
            <section>
                <?= $this->element('Dane.zamowienia_publiczne', array(
                    'histogram' => $dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets'],
                    'request' => array(
                        'gmina_id' => $object->getId(),
                    ),
                    'more' => $object->getUrl() . '/zamowienia',
                    'aggs' => array(
                        'stats' => array(),
                        'dokumenty' => array(),
                    ),
                )); ?>
            </section>
        </div>
    <? } ?>

    <div class="block block-simple col-xs-12">
        <header>Typy zarejestrowanych organizacji<? if ($object->getId() == 903) { ?> w Krakowie<? } ?></header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                     data-choose-request="<?= $object->getUrl() ?>/organizacje?conditions[krs_podmioty.forma_prawna_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['typ_id'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="block block-simple col-xs-12">
        <header>Kapitalizacja spółek handlowych</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-ColumnsVertical"
                     data-choose-request="<?= $object->getUrl() ?>/organizacje?conditions[krs_podmioty.wartosc_kapital_zakladowy]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['kapitalizacja'])) ?>">
                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>

    <div class="block block-simple col-xs-12">
        <header>Rejestracje nowych organizacji w czasie</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-DateHistogram"
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['date'])) ?>">

                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>

</div>
<div class="col-md-3 sidebar">

<?
    $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
    $this->Combinator->add_libs('js', 'Pisma.pisma-button');
    
    echo $this->element('tools/pismo', array(
	    'label' => '<strong>Wyślij pismo</strong> do urzędu tej gminy',
	    'class' => 'margin-top-0',
    ));

if( $object->getId()!=903 ) {
	    $page = $object->getLayer('page');
	    if (!$page['moderated'])
	        echo $this->element('tools/admin', array(
		        'label' => '<strong>Zarządzaj profilem</strong> tej gminy',
	        ));
    }
    ?>


    <? if ($object->getId() == 903) { ?>

        <div class="block block-default col-md-12">

            <header>Najnowsze posiedzenie Rady Miasta</header>

            <section class="aggs-init nopadding">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['rada_posiedzenia']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['rada_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'krakow_posiedzenia');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['rada_posiedzenia']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons pull-right">
                        <a href="<?= $object->getUrl() ?>/posiedzenia" class="btn-primary btn-sm">Zobacz więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>
        <div class="block block-default col-md-12">

            <header>Najnowsze nagrania posiedzeń komisji</header>

            <section class="aggs-init nopadding">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'krakow_rada_posiedzenia');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons pull-right">
                        <a href="<?= $object->getUrl() ?>/komisje_posiedzenia"
                           class="btn-primary btn-sm">Zobacz więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>
        <div class="block block-default col-md-12">

            <header>Najnowsze nagrania posiedzeń rad dzielnic</header>

            <section class="aggs-init nopadding">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['dzielnice_posiedzenia']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['dzielnice_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'dzielnice_posiedzenia');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons pull-right">
                        <a href="<?= $object->getUrl() ?>/dzielnice"
                           class="btn-primary btn-sm">Zobacz więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>

    <? } ?>

</div>
