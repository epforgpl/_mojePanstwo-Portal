<?

/* page script */
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-odpisy');

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$odpisy = $object->getLayer('odpisy');

$status_dict = array(
    '0' => array('W kolejce', 'primary'),
    '1' => array('Pobieranie', 'warning'),
    '2' => array('Pobrany', 'success'),
);

?>

<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="observeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="observeModalLabel">Pobierz odpis aktualny</h4>
            </div>
            <form action="<?= $object->getUrl() ?>/odpisy" method="get">
                <div class="modal-body">
                    <p class="header">Pobieranie odpisu dla dla: <span><a
                                href="<?= $object->getUrl() ?>"><?= $object->getTitle(); ?></a></span>
                    </p>
                    
                    <p class="header">Data odpisu: <span class="data_odpisu"></span>
                    </p>

                    <div class="optionsBlock text-center subscribeDiv">
                        <div class="checkbox first">
                            <input id="subscribeCheckbox" type="checkbox" name="subscribe" value="1">
                            <label for="subscribeCheckbox">Powiadomiaj mnie o nowych danych dla tej organizacji</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer<?php if (!$this->Session->read('Auth.User.id')) {
                    echo ' backgroundBlue';
                } ?>">
                    <?php if ($this->Session->read('Auth.User.id')) { ?>
                        <button class="btn btn-success btn-icon submit width-auto">
                            <span class="icon" data-icon="&#xe604;"></span>Pobierz</button>
                    <?php } else { ?>
                        <a href="/login" class="_specialCaseLoginButton" data-dismiss="modal">Zaloguj się, aby
                            korzystać z funkcji obserwowania
                        </a>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container">
    <div class="krsPodmioty">

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">

                <p class="row margin-top-30">Część danych na profilu organizacji pochodzi z odpisów, pobieranych
                    z <a href="https://ems.ms.gov.pl/krs/wyszukiwaniepodmiotu?t:lb=t" target="_blank"> Centralnej
                        Informacji Krajowego Rejestru Sądowego</a>. Te dane są stale aktualizowane, jednak jeśli są one
                    nieaktualne, możesz poprosić o pobranie nowego odpisu i zaktualizowanie informacji.</p>

                <div class="row">

                    <div class="block nobg block-simple col-md-12">
                        <header>
                            <div class="sm">Pobrane odpisy</div>
                        </header>
                        <section class="content odpisy">
                            <div class="row">

                                <div class="col-md-8">
                                    <? if (@count($odpisy)) { ?>
                                    <div class="list-group">
                                        <? foreach ($odpisy as $odpis) {
	                                        
	                                        $href = $_user ? $object->getUrl() . '/odpisy/' . $odpis['id'] : "#";
	                                        
                                        ?>
                                            <div class="list-group-item">

                                                <? if ($odpis['complete']) { ?>
                                                    <a class="pull-right label label-success"
                                                       href="<?= $href ?>">Pobrany</a>
                                                <?
                                                } else {
                                                    $status = $status_dict[$odpis['status']];
                                                    ?>
                                                    <span class="pull-right label label-<?= $status[1] ?>">
						                                <?= $status[0] ?>
					                                </span>
                                                <? } ?>


                                                <?
                                                if (
                                                    !$odpis['complete_ts'] ||
                                                    ($odpis['complete_ts'] == '0000-00-00 00:00:00')
                                                ) {
                                                    ?><span
                                                        class="text-muted">Oczekiwanie na pobranie odpisu...</span><?
                                                } else {
                                                    ?>

                                                    <? if ($odpis['complete']) { ?><a href="<?= $href ?>"><? } ?>


                                                    <span class="glyphicon glyphicon-cloud-download
"></span> <?= $this->Czas->dataSlownie($odpis['complete_ts']) ?>

                                                    <? if ($odpis['complete']) { ?></a><? } ?>

                                                <? } ?>

                                            </div>
                                        <? } ?>
                                        <? } ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="sticky">
                                        <form action="<?= $object->getUrl(); ?>" method="post">
                                            <input type="hidden" name="_action" value="pobierz_nowy_odpis"/>
                                            <button type="submit" class="btn btnUpdate btn-primary btn-icon width-auto<? if(!$_user) {?> _specialCaseLoginButton<? } ?>">
                                                <span class="icon glyphicon glyphicon-refresh"></span> Poproś o nowy
                                                odpis
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </section>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
