<?
$this->Combinator->add_libs('css', $this->Less->css('prawo', array('plugin' => 'Prawo')));

$news = @$dataBrowser['aggs']['news']['top']['hits']['hits'];
$kodeksy = @$dataBrowser['aggs']['kodeksy']['top']['hits']['hits'];
$konstytucja = @$dataBrowser['aggs']['konstytucja']['top']['hits']['hits'];
?>

<div class="col-xs-12">
    <div id="bdl_div">

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
                                    src="https://www.youtube.com/embed/ipGyNqfOWow?list=PLa_8n5BEWSbnvu-owdDAOCmD2dbI0Zosv"
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <h1 class="appTitle">Prawo</h1>
            <p class="appSubtitle">Przeglądaj teksty aktów prawnych</p>

            <form action="/prawo" method="get">
                <div class="appSearch form-group">
                    <div class="input-group">
                        <input name="q" class="form-control" placeholder="Szukaj w aktach prawnych..." type="text">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary input-md">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
							</span>
                    </div>
                </div>
            </form>
        </div>


        <div class="row">

            <div class="col-xs-8">

                <div class="block">
                    <header>Aktualności:</header>
                    <section class="content">

                        <div class="agg agg-Dataobjects">
                            <ul class="dataobjects" style="margin: 0 20px;">
                                <? foreach ($news as $doc) { ?>
                                    <li class="margin-top-15">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons text-center margin-top-10">
                                <a href="/prawo/aktualnosci" class="btn btn-primary btn-xs">Więcej
                                    aktualności &raquo;</a>
                            </div>
                        </div>

                    </section>
                </div>

            </div>

            <div class="col-xs-4">

                <? if ($konstytucja) { ?>
                    <div class="block nobg konstytucja">
                        <header>Konstytucja:</header>
                        <section class="content">

                            <div class="agg agg-Dataobjects">
                                <ul class="dataobjects" style="margin: 0 20px;">
                                    <? foreach ($konstytucja as $doc) { ?>
                                        <li>
                                            <?
                                            echo $this->Dataobject->render($doc, 'default');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                            </div>

                        </section>
                    </div>
                <? } ?>

                <? if ($kodeksy) { ?>
                    <div class="block nobg kodeksy">
                        <header>Kodeksy:</header>
                        <section class="content">

                            <div class="agg agg-Dataobjects">
                                <ul class="dataobjects" style="margin: 0 20px;">
                                    <? foreach ($kodeksy as $doc) { ?>
                                        <li class="margin-top-10">
                                            <?
                                            echo $this->Dataobject->render($doc, 'default');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                            </div>

                        </section>
                    </div>
                <? } ?>

            </div>

        </div>


    </div>
</div>
