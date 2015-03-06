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
    'object' => $miejscowosc,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    ),
));
?>

    <div class="posiedzenie row">
        <div class="col-md-3 objectSide">
            <div class="objectSideInner">
                <ul class="dataHighlights side">

                    <? /*
	            <li class="dataHighlight big">
	                <p class="_label">Liczba punktów porządku dziennego</p>
	
	                <div>
	                    <p class="_value pull-left"><?= $posiedzenie->getData('liczba_punktow'); ?></p>
	
	                    <p class="pull-right nopadding"><a class="btn btn-sm btn-default"
	                                                       href="/dane/gminy/903/posiedzenia/<?= $posiedzenie->getId() ?>/punkty">Zobacz &raquo;</a>
	                    </p>
	                </div>
	            </li>
	            */
                    ?>

                </ul>

            </div>
        </div>


        <div class="col-md-9 objectMain">


            <div class="object">

                <div class="block-group">


                </div>


            </div>

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');