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
?>

<h1 class="subheader">Rada Miasta Kraków</h1>
	
<? if (isset($_submenu) && !empty($_submenu)) { ?>
    <div class="menuTabsCont">
        <div class="container">
            <?
            if( !isset($_submenu['base']) )
                $_submenu['base'] = $object->getUrl();
            echo $this->Element('Dane.dataobject/menuTabs', array(
                'menu' => $_submenu,
            ));
            ?>
        </div>
    </div>
<? } 


echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($__submenu) ? $__submenu : false,
    'object' => $posiedzenie,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
        'routes' => array(
            'shortTitle' => 'pageTitle'
        ),
    ),
));


	
	echo $this->Document->place($posiedzenie->getData('krakow_posiedzenia.zwolanie_dokument_id'));

	echo $this->Element('dataobject/pageEnd');
	