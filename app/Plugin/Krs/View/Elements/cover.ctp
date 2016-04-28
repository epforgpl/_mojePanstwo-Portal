<?
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('css', $this->Less->css('view-krs-graph', array('plugin' => 'Dane')));
// $this->Combinator->add_libs('js', 'Dane.view-krspodmioty');
$this->Combinator->add_libs('js', 'graph-krs');

echo $this->Html->css($this->Less->css('krs-cover', array('plugin' => 'Krs')));

$options = array(
    'mode' => 'init',
);
echo $this->Html->script('Dane.d3/d3', array('block' => 'scriptBlock'));
?>


<div class="col-xs-12">
    <div class="appBanner playerMode">
        <button class="playerModeButton btn btn-link" type="button" data-toggle="modal"
                data-target="#socialMediaPlayerYoutube">
            <img src="/img/socialmedia/social-media-player-youtube.svg" class="img-responsive" width="42"/>
            <p>Obejrzyj film</p>
        </button>

        <div class="modal fade" id="socialMediaPlayerYoutube" tabindex="-1" role="dialog"
             aria-labelledby="socialMediaPlayerYoutubeLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <iframe width="560" height="315"
                                src="https://www.youtube.com/embed/W2pE9G8lVI0?list=PLa_8n5BEWSbnvu-owdDAOCmD2dbI0Zosv"
                                frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="appTitle">Krajowy Rejestr Sądowy</h1>
        <p class="appSubtitle">Przeglądaj powiązania pomiędzy organizacjami i osobami.</p>

        <form action="/krs" method="get">
            <div class="appSearch form-group">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="Szukaj organizacji i osób..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
					</span>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<p class="powiazania-label">Przykładowe powiązania dla <a
        href="<?= $init_object->getUrl() ?>"><?= $init_object->getTitle() ?></a>:</p>
</div>


<div class="powiazania block block-simple">
    <section id="connectionGraph" data-id="<?= $init_data[1] ?>" data-url="<?= $init_data[0] ?>"
             style="min-height: 500px;">
        <div class="spinner grey">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </section>
    <div class="detailInfoWrapper"></div>
</div>


<div class="container">
    <p class="powiazania-label text-center margin-bottom--10"><a
            href="<?= $init_object->getUrl() ?>/graph">Więcej &raquo;</a></p>

    <div class="dataBrowserContent">
        <div class="col-xs-12">
            <div class="row">

                <? /*
		<div class="col-md-7" id="blocks">

            <?
				if( $formy = @$dataBrowser['aggs']['krs_podmioty']['formy']['buckets'] ) {
					$f = 0;
                    foreach ($formy as $forma) {
	                    $f++;
						$data = $forms[ $forma['key'] ];
			?>

                        <div class="block<? if( $f===1 ) {?> active<? } ?>">
				        <header><a href="#"><?= $data['title'] ?></a></header>

                            <section class="content<? if( $f>1 ) {?> hidden<? } ?>">

                                <div class="block-bg-area">
					                <?= $data['desc'] ?>
				                </div>

                                <? if( $organizacje = $forma['organizacje']['hits']['hits'] ) { ?>

                                    <p class="p subtitle"><?= $data['latest'] ?>:</p>

                                    <div class="agg agg-Dataobjects">
					                    <ul class="dataobjects" style="margin: 0 20px;">
					                        <? foreach ($organizacje as $doc) { ?>
					                            <li class="margin-top-10">
					                                <?
					                                echo $this->Dataobject->render($doc, 'default');
					                                ?>
					                            </li>
					                        <? } ?>
					                    </ul>
					                </div>

                                    <div class="buttons">
					                <a class="btn btn-xs btn-primary">Zobacz więcej &raquo;</a>
				                </div>

                                <? } ?>


                            </section>

                        </div>

                        <?
					}
				}
			?>

            <p class="appInnerP margin-bottom-20">
				<a href="/krs/formy_prane">Zobacz wszystkie formy prawne &raquo;</a>
			</p>

        </div>
		*/ ?>

                <? if ($dzialalnosci = $dataBrowser['aggs']['krs_podmioty']['dzialalnosci']['sekcja']['buckets']) { ?>
                    <div class="col-md-12">
                        <div class="block nobg">
                            <header>Przeglądaj według działalności:</header>

                            <section class="aggs-init">
                                <div class="pkd-list row">
                                    <? foreach ($dzialalnosci as $d) { ?>
                                        <div class="pkd-item col-sm-4">
                                            <a href="/krs/pkd/<?= $d['key'] ?>">
                                                <i class="pkd-icon icon-krs-<?= $d['key'] ?>"></i>
                                                <p class="pkd-title normalizeText"><?= $this->Text->truncate($d['nazwa']['buckets'][0]['key'], 60) ?></p>
                                            </a>
                                        </div>
                                    <? } ?>
                                </div>
                            </section>
                        </div>
                    </div>
                <? } ?>

            </div>


            <? /*
    <div class="block col-xs-12">
        <header>Kapitalizacja spółek handlowych</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-ColumnsVertical"
                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.wartosc_kapital_zakladowy]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['kapitalizacja'])) ?>">
                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Rejestracje nowych organizacji w czasie</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-DateHistogram"
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['date'])) ?>">

                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>
    */ ?>

        </div>
