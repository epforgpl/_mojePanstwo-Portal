<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('pomoc', array('plugin' => 'Pomoc')));
?>

<div class="objectsPage">
    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
        <div class="searcher-app">
            <div class="container">
                <?= $this->element('Dane.DataBrowser/browser-searcher', array(
                    'size' => 'md',
                )); ?>
            </div>
        </div>

        <div class="container">
            <div class="dataBrowserContent">
                <div class="col-xs-12 col-sm-4 col-md-1-5 nopadding dataAggsContainer">
                    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
                        <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
                    <div class="dataWrap">
                        <div class="appBanner bottom-border">
                            <h1 class="appTitle">Pomoc</h1>

                            <p class="appSubtitle">Tutoriale video</p>
                        </div>
                        <div class="epfYTVideo whiteBlocks block col-xs-12">
                            <ul class="item-list">
                                <?
                                foreach ($ytPlaylist as $video) { ?>
                                    <li class="item list">
                                        <a href="https://www.youtube.com/watch?v=<?= $video['snippet']['resourceId']['videoId'] ?>&list=<?= $video['snippet']['playlistId'] ?>"
                                           target="_blank">
                                            <img class="photo"
                                                 src="<?= $video['snippet']['thumbnails']['medium']['url'] ?>"/>
                                            <h3 class="title"><?= $video['snippet']['title'] ?></h3>
                                            <p class="desc"><?= $this->Text->truncate(
                                                    $video['snippet']['description'],
                                                    175,
                                                    array(
                                                        'ellipsis' => ' [...]',
                                                        'exact' => false
                                                    )
                                                ); ?></p>
                                        </a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                            <a class="allvideo" href="https://www.youtube.com/playlist?list=<?= $ytPlaylist[0]['id'] ?>"
                               target="_blank">Zobacz więcej filmów</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
