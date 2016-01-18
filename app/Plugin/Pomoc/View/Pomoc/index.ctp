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

                            <p class="appSubtitle">Centrum pomocy portalu mojePaństwo</p>
                        </div>
                        <div class="content">
                            <div class="epfPosts whiteBlocks block col-xs-12">
                                <header>Instrukcje</header>
                                <section class="noleftpadding norightpadding">
                                    <ul class="item-list">
                                        <?
                                        $i = 1;
                                        foreach ($epfRSSFeed as $post) { ?>
                                            <li class="item list">
                                                <a href="<?= $post['link'] ?>" target="_blank">
                                                    <h3 class="title"><?= str_replace(' & ', ' &amp; ', $post['title']); ?></h3>
                                                </a>
                                                <time
                                                    class="date"><?= date('d M Y', strtotime($post['date'])); ?></time>
                                                <p class="desc"><?= $post['desc']; ?></p>
                                                <a class="btn btn-primary btn-link btn-sm" href="<?= $post['link'] ?>"
                                                   target="_blank">Dowiedz się więcej</a>
                                            </li>
                                            <?
                                            if ($i++ == 4) break;
                                        }
                                        ?>
                                    </ul>
                                </section>
                            </div>
                            <div class="epfYTVideo whiteBlocks block col-xs-12">
                                <header>Tutoriale video</header>
                                <section class="noleftpadding norightpadding">
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
                                </section>
                            </div>
                            <div id="blad" class="block col-xs-12 reportBug">
                                <header>Zgłoś błąd bądź sugestię</header>
                                <section>
                                    <p>Jeśli wystąpił jakiś błąd w naszym serwisie, posiadamy błędne lub nieaktualne
                                        dane, bądź chcą Państwo
                                        zgłosić nową funkcjonalność - poinformujcie
                                        Nas o tym.</p>

                                    <p> Jeśli zgłaszacie Państwo błąd prosimy o uwzględnienie jak największej ilości
                                        informacji: dokładny
                                        opis błędu, miejscem w którym występuje - najlepiej poparty adresem www,
                                        przeglądarką (rodzaj i jej
                                        wersją) oraz system operacyjnym, na którym błąd występuje. Dzięki czemu będziemy
                                        w stanie łatwiej
                                        odtworzyć błąd w celu diagnozy i naprawienia go.</p>

                                    <p class="text-center">
                                        <?php echo $this->Html->link('<span class="fa fa-github"></span>Powiadom bezpośrednio w serwisie GitHub', 'https://github.com/epforgpl/_mojePanstwo-Portal/issues/new', array(
                                            'class' => 'btn btn-social btn-github sliceBtn',
                                            'target' => '_blank',
                                            'escape' => false
                                        )); ?>
                                    </p>
                                </section>
                                <section>
                                    <p>Jeśli znajdują się u nas jakies błędy krytyczne bądź błędy bezpieczeństwa -
                                        prosimy wtedy o
                                        zgłoszenia drogą mailową, aby nie upubliczniać informacji o wykrytej
                                        dziurze/błędzie.</p>
                                    <div
                                        class="input-group emailBtn sliceBtn col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                            <span class="input-group-btn">
                                                <a class="btn btn-default glyphicon glyphicon-envelope" type="button"
                                                   href="mailto:security@mojepanstwo.pl"></a>
                                            </span>
                                        <input type="text" class="form-control" value="security@mojepanstwo.pl"
                                               readonly>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
