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

$parts = array();



if( $posiedzenie->getData('kadencja_id')=='7' ) {

?>
<style>
	#_main .objectsPage .objectsPageContent .htmlexDoc #docsToolbar {display: none;}
</style>
<?

	if( $posiedzenie->getData('zwolanie_dokument_id') ) {
?>	
		<h2 class="light">Informacja o zwołaniu posiedzenia</h2>
		<iframe class="idoc" src="/docs/<?= $posiedzenie->getData('zwolanie_dokument_id') ?>.html"></iframe>
<?			
	}
	if( $posiedzenie->getData('porzadek_dokument_id') ) {
?>	
		<h2 class="light">Porządek obrad</h2>
		<iframe class="idoc" src="/docs/<?= $posiedzenie->getData('porzadek_dokument_id') ?>.html"></iframe>
<?
	}
	if( $posiedzenie->getData('podsumowanie_dokument_id') ) {
?>	
		<h2 class="light">Podsumowanie posiedzenia</h2>
		<iframe class="idoc" src="/docs/<?= $posiedzenie->getData('podsumowanie_dokument_id') ?>.html"></iframe>
<?
	}
	if( $posiedzenie->getData('wyniki_dokument_id') ) {
?>	
		<h2 class="light">Wyniki głosowań</h2>
		<iframe class="idoc" src="/docs/<?= $posiedzenie->getData('wyniki_dokument_id') ?>.html"></iframe>
<?
	}
	if( $posiedzenie->getData('stenogram_dokument_id') ) {
?>	
		<h2 class="light">Stenogram</h2>
		<iframe class="idoc" src="/docs/<?= $posiedzenie->getData('stenogram_dokument_id') ?>.html"></iframe>
<?
	}
	if( $posiedzenie->getData('protokol_dokument_id') ) {
?>	
		<h2 class="light">Protokół</h2>
		<iframe class="idoc" src="/docs/<?= $posiedzenie->getData('protokol_dokument_id') ?>.html"></iframe>
<?
	}

	if( $pagination['total'] ) {
		echo $this->Element('Dane.DataobjectsBrowser/view', array(
		    'page' => $page,
		    'pagination' => $pagination,
		    'filters' => $filters,
		    'switchers' => $switchers,
		    'facets' => $facets,
		));
	}

} else {
		
	if( $pagination['total'] ) {
		echo $this->Element('Dane.DataobjectsBrowser/view', array(
		    'page' => $page,
		    'pagination' => $pagination,
		    'filters' => $filters,
		    'switchers' => $switchers,
		    'facets' => $facets,
		));
	}
	
}

echo $this->Element('dataobject/pageEnd');