<?
echo $this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
echo $this->Combinator->add_libs('js', 'Dane.view-gminy-posiedzenie');
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $posiedzenie,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
        'routes' => array(
            'shortTitle' => 'pageTitle'
        ),
    ),
    'back' => array(
        'href' => '/dane/gminy/903,krakow/posiedzenia',
        'title' => 'Wszystkie posiedzenia rady miasta',
    ),
));
?>

<div class="krsPodmiotZmiana row">

    <div class="col-lg-3 objectSide">
        <div class="objectSideInner rrs">

			<? if ( 
				$posiedzenie->getData('zwolanie_dokument_id') || 
				$posiedzenie->getData('porzadek_dokument_id') || 
				$posiedzenie->getData('podsumowanie_dokument_id') || 
				$posiedzenie->getData('wyniki_dokument_id') || 
				$posiedzenie->getData('stenogram_dokument_id') || 
				$posiedzenie->getData('protokol_dokument_id') 
			) { ?>
            <div class="block">

                <ul class="dataHighlights side">

					<? /*
					<li class="dataHighlight">
                        <p class="_label pull-left">Dział</p>
                        <p class="_value pull-right"><?= $posiedzenie->getData('numer_dzialu') ?></p>                                
                    </li>
                    
                    <li class="dataHighlight">
                        <p class="_label pull-left">Rubryka</p>
                        <p class="_value pull-right"><?= $posiedzenie->getData('numer_rubryki') ?></p>                                
                    </li>
                    
                    <li class="dataHighlight">
                        <p class="_label pull-left">Rejestr</p>
                        <p class="_value pull-right"><?= $posiedzenie->getData('rejestr_nr') ?></p>                                
                    </li>
					*/ ?>
					
					
					<?
					if ($posiedzenie->getData('zwolanie_dokument_id')) {
				        ?>
				        <li class="dataHighlight">
	                        <a href="<?= $posiedzenie->getUrl() ?>/informacja"><span
	                                class="icon icon-moon">&#xe614;</span>Zwołanie posiedzenia <span
	                                class="glyphicon glyphicon-chevron-right"></a>
	                    </li>
				    <?
				    }
				    if ($posiedzenie->getData('porzadek_dokument_id')) {
				        ?>
				        <li class="dataHighlight">
	                        <a href="<?= $posiedzenie->getUrl() ?>/porzadek"><span
	                                class="icon icon-moon">&#xe614;</span>Porządek obrad<span
	                                class="glyphicon glyphicon-chevron-right"></a>
	                    </li>
				    <?
				    }
				    if ($posiedzenie->getData('podsumowanie_dokument_id')) {
				        ?>
				        <li class="dataHighlight">
	                        <a href="<?= $posiedzenie->getUrl() ?>/podsumowanie"><span
	                                class="icon icon-moon">&#xe614;</span>Podsumowanie posiedzenia<span
	                                class="glyphicon glyphicon-chevron-right"></a>
	                    </li>
				    <?
				    }
				    if ($posiedzenie->getData('wyniki_dokument_id')) {
				        ?>
				        <li class="dataHighlight">
	                        <a href="<?= $posiedzenie->getUrl() ?>/glosowania"><span
	                                class="icon icon-moon">&#xe614;</span>Wyniki głosowań<span
	                                class="glyphicon glyphicon-chevron-right"></a>
	                    </li>
				    <?
				    }
				    if ($posiedzenie->getData('stenogram_dokument_id')) {
				        ?>
				        <li class="dataHighlight">
	                        <a href="<?= $posiedzenie->getUrl() ?>/stenogram"><span
	                                class="icon icon-moon">&#xe614;</span>Stenogram<span
	                                class="glyphicon glyphicon-chevron-right"></a>
	                    </li>
				    <?
				    }
				    if ($posiedzenie->getData('protokol_dokument_id')) {
				        ?>
				        <li class="dataHighlight">
	                        <a href="<?= $posiedzenie->getUrl() ?>/protokol"><span
	                                class="icon icon-moon">&#xe614;</span>Protokół<span
	                                class="glyphicon glyphicon-chevron-right"></a>
	                    </li>
				    <?
				    }
                    ?>
				
				</ul>
                
            </div>
            <? } ?>
			
			<? /*
            <div class="block">

                <ul class="dataHighlights side">

                    <li class="dataHighlight">
                        <a target="_blank" href="/dane/msig_dzialy/<?= $zmiana->getData('dzial_id') ?>"><span
                                class="glyphicon glyphicon-link"></span>MSiG<span
                                class="glyphicon glyphicon-chevron-right"></a>
                    </li>

                </ul>

            </div>
			*/ ?>

        </div>
    </div>

    <div class="col-lg-9 nopadding">
        <div class="object">
			
			<? if( isset($objects) && !empty($objects)) {?>
			<div class="block">
				<div class="block-header">
					<h2 class="label">Punkty porządku dziennego</h2>
				</div>
				<div class="content">
										
					<table class="table table-striped table-hover ">
						<thead>
							<tr>
								<th>Numer</th>
								<th>Tytuł</th>
								<th>Wynik rozpatrywania</th>
							</tr>
						</thead>
						<tbody>
							<? foreach( $objects as $object ) { $object = $object['Dataobject']; ?>
							<tr>
								<td class="text-center"><span class="punkt-nr"><?= $object->getData('numer') ?></span></td>
								<td><? if($object->getUrl()) {?><a href="<?= $object->getUrl() ?>"><? } ?><?= $object->getData('tytul') ?><? if($object->getUrl()) {?></a><? } ?></td>
								<td><?= $object->getData('krakow_glosowania.wynik_str') ?></td>
							</tr>
							<? } ?>
						</tbody>
					</table>
					
				</div>
			</div>
			<? } ?>

        </div>
    </div>

</div>

<?
/*
if (!@$this->request->query['q'] && ($terms = $posiedzenie->getLayer('terms')) && !empty($terms)) {
    ?>
    <div class="block">
        <div class="block-header">
            <h2 class="label">Tematy posiedzenia</h2>
        </div>

        <ul class="objectTagsCloud row">
            <?

            $font = array(
                'min' => 15,
                'max' => 100,
            );
            $font['diff'] = $font['max'] - $font['min'];


            foreach ($terms as &$term) {
                $term['size'] = $font['min'] + $font['diff'] * $term['norm_score'];
            }


            shuffle($terms);


            foreach ($terms as $term) {
                $href = '/dane/gminy/903/posiedzenia/' . $posiedzenie->getId() . '/punkty?q=' . addslashes($term['key']);
                ?>
                <li style="font-size: <?= $term['size'] ?>px;"><a href="<?= $href ?>"><?= $term['key'] ?></a></li>
            <? } ?>
        </ul>

    </div>
<?
}
*/



/*

    if ($pagination['total']) {
        echo $this->Element('Dane.DataobjectsBrowser/view', array(
            'page' => $page,
            'pagination' => $pagination,
            'filters' => $filters,
            'switchers' => $switchers,
            'facets' => $facets,
        ));
    }

} else {

    if ($pagination['total']) {
        echo $this->Element('Dane.DataobjectsBrowser/view', array(
            'page' => $page,
            'pagination' => $pagination,
            'filters' => $filters,
            'switchers' => $switchers,
            'facets' => $facets,
        ));
    }

}
*/

echo $this->Element('dataobject/pageEnd');