<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-aktywnosci');
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

function getPoselTemplate($pos, $vote) {
    return implode("", array('<div class="objectRender readed objclass radni_gmin">',
    '<div class="row">',
    '<div class="data col-xs-12">',
    '<div>',
    '<div class="attachment col-md-4 nopadding text-center">',
    '<a href="/dane/gminy/903/radni/'. $pos->getId() .'" class="thumb_cont">',
    '<img onerror="imgFixer(this)" alt="Bogusław Kośmider" src="'. $pos->getThumbnailUrl() .'" class="thumb pull-right">',
    '</a>',
    '</div>',
    '<div class="content col-md-8">',
    '<p class="title">',
    '<a title="'.$pos->getTitle().'" href="/dane/gminy/903/radni/'. $pos->getId() .'">'.$pos->getTitle().'</a>',
    '</p>',
    '<p class="meta meta-desc">'. $pos->getData('komitet') .'</p>',
    '<p class="meta zgodnosc"><strong>'. round(($pos->data['fit'] * 100) / count($vote), 2) .'%</strong> zgodności</p>',
    '</div>',
    '</div>',
    '</div>',
    '</div>',
    '</div>'));
}

 ?>
    <div class="pkGlosowanie">
        <div class="glosowanieSlice col-xs-12 nopadding">
            <h1 class="subheader"><? if (isset($vote) && isset($completed) && $completed === true) { ?>Dziękujemy za głosowanie<? } else { ?> Głosuj<?
                } ?></h1>
            <? if (isset($vote) && isset($completed) && $completed === true && isset($radni)) { ?>
                <div class="poslowieResults">
                    <h3>Najbliżej Twoim głosom głosowali</h3>
                    <ul>
                        <li class="first col-xs-12 nopadding">
                            <div class="col-xs-12 col-xs-6 col-md-3"><?= getPoselTemplate($radni[0], $vote) ?></div>
                        </li>
                        <li class="col-xs-12 col-xs-6 col-md-3 nopadding">
                            <div class="col-xs-12"><?= getPoselTemplate($radni[1], $vote) ?></div>
                        </li>
                        <li class="col-xs-12 col-xs-6 col-md-3 nopadding">
                            <div class="col-xs-12"><?= getPoselTemplate($radni[2], $vote) ?></div>
                        </li>
                        <li class="col-xs-12 col-xs-6 col-md-3 nopadding">
                            <div class="col-xs-12"><?= getPoselTemplate($radni[3], $vote) ?></div>
                        </li>
                        <li class="col-xs-12 col-xs-6 col-md-3 nopadding">
                            <div class="col-xs-12"><?= getPoselTemplate($radni[4], $vote) ?></div>
                        </li>
                    </ul>
                </div>
                <?
            } ?>
        </div>
        <? if (isset($vote)) { ?>
            </div><? /*CLOSE <div.pkGlosowanie>*/?>
            </div><? /*CLOSE <div.objectsPageContent.main>*/?>
            </div><? /*CLOSE <div.container>*/?>
            <div class="grayBar">
                <div class="container">
                    <div class="glosowanieSlice col-xs-12 nopadding">
                        <? if (isset($completed) && $completed === true) { ?>
                            <p>Chcesz mieć dokładniejsze wyniki?</p>
                            <a class="btn btn-primary btn-lg"
                               href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj/?more' : '/glosuj/?more') ?>">
                               Głosuj dalej</a>
                            <p class="margin-top-10">lub</p>
                            <a class="btn btn-default btn-lg"
                               href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj/?reset' : '/glosuj/?reset') ?>">
                               Rozpocznij od nowa</a>
                        <? } else { ?>
                            <p>Nie zakończyłeś/aś jeszcze głosować.</p>
                            <a class="btn btn-primary btn-lg"
                               href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/rada_uchwaly/' . $next : '/rada_uchwaly/' . $next) ?>">Głosuj
                                dalej</a>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="container"><? /*REOPEN <div.container>*/?>
            <div class="objectsPageContent main"><? /*REOPEN <div.objectsPageContent.main>*/?>
            <div class="pkGlosowanie"><? /*REOPEN <div.pkGlosowanie>*/?>
        <? } else { ?>
            <div class="glosowanieSlice col-xs-12 nopadding">
                <div class="text col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                    <p>Zagłosuj na 10 ostatnich projektów uchwał i&nbsp;zobacz do którego radnego jest Ci najbliżej!</p>

                    <form action="" method="post">
                        <input class="btn btn-primary btn-lg" type="submit" value="Rozpocznij" name="start"/>
                    </form>
                </div>
            </div>
        <? } ?>
        <? if (isset($vote)) { ?>
            <div class="glosowanieSlice col-xs-12 nopadding">
                <h2 class="subheader">Jak głosowałeś/aś?</h2>
                <ul class="glosowanieList">
                    <? foreach ($vote as $v) {
                        if ($v['vote'] !== false) {
                            ?>
                            <li>
                                <div class="objectRender readed objclass">
                                    <div class="data col-xs-8 col-sm-10">
                                        <div>
                                            <div class="content">
                                                <span class="object-icon icon-datasets-zamowienia_publiczne_dokumenty"></span>

                                                <div class="object-icon-side ">
                                                    <p class="title">
                                                        <a title="<?= $v['tytul'] ?>"
                                                           href="/dane/gminy/903,krakow/rada_uchwaly/<?= $v['id'] ?>"><?= $v['tytul'] ?></a>
                                                    </p>

                                                    <p class="meta meta-desc"><?= $v['data'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <? switch ($v['vote']) {
                                        case -1:
                                            $btnClass = 'btn-danger';
                                            $btnIcon = 'glyphicon glyphicon-remove';
                                            $btnText = 'Przeciw';
                                            break;
                                        case 0:
                                            $btnClass = 'btn-primary';
                                            $btnIcon = 'glyphicon glyphicon-minus';
                                            $btnText = 'Wstrzymałeś/aś się';
                                            break;
                                        case 1:
                                            $btnClass = 'btn-success';
                                            $btnIcon = 'glyphicon glyphicon-ok';
                                            $btnText = 'Za';
                                            break;
                                    } ?>
                                    <div class="votedFor pull-right btn btn-icon width-auto <?= $btnClass; ?>"><i
                                            class="icon <?= $btnIcon; ?>"></i><?= $btnText; ?></div>
                                </div>
                            </li>
                            <?
                        }
                    } ?>
                </ul>
            </div>
        <? } ?>
    </div>

<?= $this->Element('dataobject/pageEnd');
