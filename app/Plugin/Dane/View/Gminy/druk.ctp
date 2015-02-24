<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

$this->Combinator->add_libs('css', $this->Less->css('feed-timeline', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.feed-timeline');


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
	<div class="poslowie row feed-content">
        <div class="col-md-2 objectSide">

            <div class="objectSideInner">
				
                <div class="block">


                    <ul class="dataHighlights side">

                        <li class="dataHighlight">
                            <a href="<?= $druk->getUrl() . '/tresc' ?>"><span class="icon icon-moon">&#xe610;</span>Treść druku<span class="glyphicon glyphicon-chevron-right"></span></a>
                        </li>

                    </ul>
                </div>

                

            </div>

        </div>
        <div class="col-md-1 nopadding feed-timeline">
        </div>
        <div class="col-md-7 nopadding feed-content">
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