<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-aktywnosci', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-aktywnosci');

// datepicker
$this->Html->css(array('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Html->script(array('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', '../plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pl.min'), array('inline' => 'false', 'block' => 'scriptBlock'));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
)); ?>

    <div class="dataBrowser margin-top--5">
        <div class="row">
            <div class="dataBrowserContent">
                <div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
                    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

                        <? if (isset($_submenu) && isset($_submenu['items'])) {

                            if (!isset($_submenu['base']))
                                $_submenu['base'] = $object->getUrl();

                            echo $this->Element('Dane.DataBrowser/browser-menu', array(
                                'menu' => $_submenu,
                            ));

                        } ?>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
                    <div class="dataWrap">
                        <h1 class="smaller margin-top-15">Aktywność Radnych</h1>
                        <div class="margin-top-20">
                            <? if (isset($activity_ranking)) { ?>
                                <div class="margin-top-10">

                                    <p>Radni którzy najczęściej wypowiadali się na posiedzeniach, brali udział w
                                        głosowaniach oraz posiadają najwięcej interpelacji. Za każdą aktywność radnego
                                        zostały przydzielone punkty według następującego wzoru:</p>

                                    <ul>
                                        <li class="margin-bottom-5">Wystąpienie na posiedzeniu Rady Miasta - <strong>10
                                                punktów</strong>
                                        <li class="margin-bottom-5">Wystąpienie na posiedzeniu Rady Miasta w roli przewodniczącego - <strong>3
                                                punkty</strong>
                                        <li class="margin-bottom-5">Oddanie głosu na posiedzeniu Rady Miasta - <strong>1
                                                punkt</strong>
                                        <li class="margin-bottom-5">15 minut dyżuru - <strong>2
                                                punkty</strong>
                                        <li class="margin-bottom-5">Złożenie interpelacji - <strong>30 punktów</strong>
                                    </ul>

                                    <div class="datepickerBlock range-selector">
                                        <p>Zestawienie
                                            obejmuje <?
                                            $month = array('ze styczenia', 'z lutego', 'z marzca', 'z kwietnia', 'z maja', 'z czerwca', 'z lipica', 'z sierpnia', 'z września', 'z października', 'z listopada', 'z grudnia');
                                            if (isset($_GET["m"])) {
                                                $d = explode('-', $_GET["m"]);

                                                echo 'okres ' . $month[intval($d[1]) - 1] . ' ' . $d[0];
                                            } else {
                                                echo 'bieżącą kadencję';
                                            } ?>. <span
                                                class="btn-link datepickerAktywnosciDate"
                                                data-url="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/aktywnosci' : '/aktywnosci') ?>">Wybierz <?= isset($_GET["m"]) ? 'inny' : 'konkretny' ?>
                                                miesiąc.</span></p>
                                        <? if (isset($_GET["m"])) { ?>
                                            <p><a href="/aktywnosci">Zobacz zestawienie dla całej kadencji Rady
                                                    Miasta &raquo;</a></p>
                                        <? } ?>
                                    </div>

                                    <div
                                        data-ranking="<?= htmlentities(json_encode($activity_ranking)) ?>"
                                        data-request="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/radni/' : '/radni/') ?>"
                                        class="radniRankingChart"
                                    ></div>

                                </div>
                            <? } ?>

                            <hr/>

                            <h1 class="smaller margin-top-15">Otwartość Radnych</h1>

                            <? if (isset($openness_ranking)) { ?>
                                <div class="margin-top-10">

                                    <p>Radni którzy udostępnili o sobie najwięcej informacji. Punkty zostały
                                        przydzielone według nastepującego wzrou:</p>

                                    <ul>
                                        <li class="margin-bottom-5">Udostępnienie numeru telefonu - <strong>5
                                                punktów</strong>
                                        <li class="margin-bottom-5">Prowadzenie bloga - <strong>2 punkty</strong>
                                        <li class="margin-bottom-5">Prowadzenie strony WWW - <strong>2 punkty</strong>
                                        <li class="margin-bottom-5">Prowadzenie konta Facebook - <strong>2
                                                punkty</strong>
                                        <li class="margin-bottom-5">Prowadzenie konta Twitter - <strong>2
                                                punkty</strong>
                                        <li class="margin-bottom-5">Udostępnienie adresu e-mail - <strong>1
                                                punkt</strong>
                                    </ul>

                                    <div
                                        data-ranking="<?= htmlentities(json_encode($openness_ranking)) ?>"
                                        data-request="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/radni/' : '/radni/') ?>"
                                        class="radniRankingChart"
                                    ></div>

                                </div>
                            <? } ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

<?= $this->Element('dataobject/pageEnd');
