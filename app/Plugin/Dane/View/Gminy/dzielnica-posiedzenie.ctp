<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));


echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $dzielnica,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    ),
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => false,
    'object' => $posiedzenie,
    'objectOptions' => array(
        'bigTitle' => true,
        'hlFields' => array(),
    ),
));

?>

    <style>
        #_main .objectsPage .objectsPageContent .htmlexDoc #docsToolbar {
            display: none;
        }
    </style>

<?
if ($posiedzenie->getData('yt_video_id')) {

    $this->Combinator->add_libs('css', $this->Less->css('view-dzielnica_posiedzenie', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('js', 'Dane.view-dzielnica_posiedzenie');
    ?>

    <div id="ytVideoCont" class="row">
        <div class="<? if ($punkty) { ?>col-md-7 text-right<? } else { ?>col-md-9 col-md-offset-3<? } ?>">
            <div id="ytVideo" class="row">
                <div id="player" data-youtube="<?php echo $posiedzenie->getData('yt_video_id'); ?>"></div>
            </div>
        </div>

        <? if ($punkty) { ?>
            <div class="col-md-5 wystapienia">

                <div class="block">

                    <div class="block-header">
                        <h2 class="label">Punkty</h2>
                    </div>

                    <div class="content nopadding">
                        <ul class="nav nav-pills nav-stacked">
                            <?php foreach ($punkty as $id => $punkt) { ?>
                                <li>
                                    <a data-video-position="<?php echo $punkt['video_start']; ?>"
                                       href="#<?php echo $punkt['id']; ?>">
                                        <!--<span><?php echo (date('H', $punkt['video_start']) - 1) . date(':i:s', $punkt['video_start']); ?></span>--><?php echo $punkt['mowca_str']; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <? } ?>

    </div>

    <!--<div id="ytVideo" class="row">
                    <div id="player" data-youtube="<?php echo $posiedzenie->getData('yt_video_id'); ?>"></div>
                </div>-->

<? } ?>

    <div class="row">
        <div class="col-md-10 col-md-offset-1 objectMain">
            <?
            if ($posiedzenie->getData('protokol_dokument_id')) {
                ?>
                <h2 class="light">Protokół z obrad</h2>
                <?= $this->Document->place($posiedzenie->getData('protokol_dokument_id')) ?>
            <? } ?>


            <?
            if ($posiedzenie->getData('przedmiot_dokument_id')) {
                ?>
                <h2 class="light">Przedmiot obrad</h2>
                <?= $this->Document->place($posiedzenie->getData('przedmiot_dokument_id')) ?>
            <? } ?>


        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');