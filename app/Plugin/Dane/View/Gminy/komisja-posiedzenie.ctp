<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

/*
echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => $_submenu,
    'object' => $dzielnica,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    )
));
*/

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => false,
    'object' => $posiedzenie,
    'objectOptions' => array(
        'hlFields' => array('krakow_komisje.nazwa'),
        'bigTitle' => true,
    ),
    'back' => array(
        'href' => $komisja->getUrl(),
        'title' => $komisja->getTitle(),
    ),
));

?>

    <style>
        #_main .objectsPage .objectsPageContent .htmlexDoc #docsToolbar {
            display: none;
        }
    </style>

    <div class="row">
        <div class="col-md-10 col-md-offset-1 objectMain">
						
            <?
            if ($posiedzenie->getData('yt_video_id')) {

                $this->Combinator->add_libs('css', $this->Less->css('view-dzielnica_posiedzenie', array('plugin' => 'Dane')));
                $this->Combinator->add_libs('js', 'Dane.view-dzielnica_posiedzenie');
                ?>

                <div id="ytVideo" class="row">
                    <div id="player" data-youtube="<?php echo $posiedzenie->getData('yt_video_id'); ?>"></div>
                </div>

            <? } ?>

            <?
            if (isset($dokument)) {
                ?>
                <h2 class="light">Protokół z obrad</h2>
                <?= $this->Document->place($dokument) ?>
            <? } ?>


            


        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');