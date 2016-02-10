<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('pomoc', array('plugin' => 'Pomoc')));

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
	<div class="objectsPage">
	    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
	
	        <div class="container">
	            <div class="dataBrowserContent">
	
	                <div class="col-xs-12 col-sm-8 col-md-4-5">
                        <div class="appBanner">
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
                            <div class="col-xs-12 text-center margin-bottom-20">
                                <a class="btn btn-primary"
                                   href="https://www.youtube.com/playlist?list=<?= $ytPlaylist[0]['id'] ?>"
                                   target="_blank">Zobacz więcej filmów</a>
                            </div>
                        </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
