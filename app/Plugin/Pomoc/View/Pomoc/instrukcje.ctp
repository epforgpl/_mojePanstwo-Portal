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

                            <p class="appSubtitle">Instrukcje</p>
                        </div>
                        <div class="epfPosts whiteBlocks block col-xs-12">
                            <ul class="item-list">
                                <?
                                foreach ($epfRSSFeed as $post) { ?>
                                    <li class="item list">
                                        <a href="<?= $post['link'] ?>" target="_blank">
                                            <h3 class="title"><?= str_replace(' & ', ' &amp; ', $post['title']); ?></h3>
                                        </a>
                                        <time class="date"><?= date('d M Y', strtotime($post['date'])); ?></time>
                                        <p class="desc"><?= $post['desc']; ?></p>
                                        <a class="btn btn-primary btn-sm" href="<?= $post['link'] ?>" target="_blank">Dowiedz
                                            się więcej</a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                            <div class="col-xs-12 text-center margin-bottom-20">
                                <a class="btn btn-primary"
                                   href="http://epf.org.pl/pl/category/moje-panstwo/"
                                   target="_blank">Zobacz więcej instrukcji</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
