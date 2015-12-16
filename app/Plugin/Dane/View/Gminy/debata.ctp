<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

$this->Combinator->add_libs('css', $this->Less->css('view-radygmindebaty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-radygmindebaty');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
?>

<?
echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $debata,
    'objectOptions' => array(
        'hlFields' => array('rady_gmin_posiedzenia.numer', 'numer_punktu'),
        'bigTitle' => true,
        'truncate' => 1024,
    ),
));
?>

<? if ($debata->getData('yt_video_id')) { ?>
    <div id="ytVideoCont" class="row">
        <div class="<? if ($wystapienia) { ?>col-md-7 text-right<? } else { ?>col-md-9 col-md-offset-3<? } ?>">
            <div id="ytVideo" class="row">
                <div id="player" data-youtube="<?php echo $debata->getData('yt_video_id'); ?>"></div>
            </div>
        </div>

        <? if ($wystapienia) { ?>
            <div class="col-md-5 wystapienia">

                <div class="block">

                    <div class="block-header">
                        <h2 class="label"><?php echo __d('dane', 'LC_RADYGMINDEBATY_WYSTAPIENIA'); ?></h2>
                    </div>

                    <div class="content nopadding">
                        <ul class="nav nav-pills nav-stacked">
                            <?php foreach ($wystapienia as $id => $wystapienie) { ?>
                                <li>
                                    <a data-video-position="<?php echo $wystapienie['video_start']; ?>"
                                       href="#<?php echo $wystapienie['id']; ?>">
                                        <span><?php echo (date('H', $wystapienie['video_start']) - 1) . date(':i:s', $wystapienie['video_start']); ?></span> <?php echo $wystapienie['mowca_str']; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <? } ?>

    </div>
<? } ?>

    <div class="dataBrowser">

        <? if (@$aggs['glosowania']['top']['hits']['hits']) { ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="block block-default col-xs-12">
                        <header>Głosowania</header>

                        <section class="aggs-init">
                            <div class="dataAggs">
                                <div class="agg agg-Dataobjects">
                                    <ul class="dataobjects">
                                        <? foreach ($aggs['glosowania']['top']['hits']['hits'] as $glosowanie) { ?>
                                            <li>
                                                <?
                                                echo $this->Dataobject->render($glosowanie, 'krakow_glosowania');
                                                ?>
                                            </li>
                                        <? } ?>
                                    </ul>

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        <? } ?>

        <? if (@$aggs['druk']['top']['hits']['hits']['0']) { ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="block block-default col-xs-12">
                        <header>Rozpatrywany druk</header>

                        <section class="aggs-init">
                            <div class="dataAggs">
                                <div class="agg agg-Dataobjects">
                                    <ul class="dataobjects">
                                        <li>
                                            <?
                                            echo $this->Dataobject->render($aggs['druk']['top']['hits']['hits']['0'], 'default');
                                            ?>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        <? } ?>

    </div>


<?
echo $this->Element('dataobject/pageEnd');
?>
