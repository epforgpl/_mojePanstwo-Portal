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

                    <h1 class="smaller margin-top-15">Ranking aktywności radnych</h1>

                    <div class="margin-top-20">
		                <? if(
                        !empty($aggs['ranking_aktywnosci']['top']['hits']['hits']) &&
                        $data = $aggs['ranking_aktywnosci']['top']['hits']['hits']
                    ) { ?>
                        <div class="margin-top-10">

                            <p>Radni którzy najczęściej wypowiadali się na posiedzeniach, brali udział w głosowaniach oraz posiadają najwięcej interpelacji. Za każdą aktywność radnego zostały przydzielone punkty według następującego wzoru:</p>

                            <ul>
								<li class="margin-bottom-5">Wystąpienie na posiedzeniu Rady Miasta - <strong>10 punktów</strong>
								<li class="margin-bottom-5">Oddanie głosu na posiedzeniu Rady Miasta - <strong>1 punkt</strong>
								<li class="margin-bottom-5">Złożenie interpelacji - <strong>30 punktów</strong>
							</ul>

                            <div
                                data-aggs="<?= htmlentities(json_encode($data)) ?>"
                                data-field="radni_gmin.punkty_aktywnosc"
                                data-request="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/radni/' : '/radni/') ?>"
                                class="radniRankingChart"
                            ></div>

                        </div>
                    <? } ?>

                        <hr/>

                        <h1 class="smaller margin-top-15">Ranking otwartości radnych</h1>


                        <? if(
                        !empty($aggs['ranking_otwartosci']['top']['hits']['hits']) &&
                        $data = $aggs['ranking_otwartosci']['top']['hits']['hits']
                    ) { ?>
                        <div class="margin-top-10">

                            <p>Radni którzy udostępnili o sobie najwięcej informacji. Punkty zostały przydzielone według nastepującego wzrou:</p>

                            <ul>
								<li class="margin-bottom-5">Udostępnienie numeru telefonu - <strong>5 punktów</strong>
								<li class="margin-bottom-5">Prowadzenie bloga - <strong>2 punkty</strong>
								<li class="margin-bottom-5">Prowadzenie strony WWW - <strong>2 punkty</strong>
								<li class="margin-bottom-5">Prowadzenie konta Facebook - <strong>2 punkty</strong>
								<li class="margin-bottom-5">Prowadzenie konta Twitter - <strong>2 punkty</strong>
								<li class="margin-bottom-5">Udostępnienie adresu e-mail - <strong>1 punkt</strong>
							</ul>

                            <div
                                data-aggs="<?= htmlentities(json_encode($data)) ?>"
                                data-field="radni_gmin.punkty_dostepnosc"
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
