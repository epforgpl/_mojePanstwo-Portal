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
<div class="container">
    <div class="krsPodmioty">

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">

                <p class="row margin-top-30">Część danych na profilu Twojej organizacji pochodzi z odpisów, pobieranych
                    z <a href="https://ems.ms.gov.pl/krs/wyszukiwaniepodmiotu?t:lb=t" target="_blank"> Centralnej
                        Informacji Krajowego Rejestru Sądowego</a>. Te dane są stale aktualizowane, jednak jeśli są one
                    nieaktualne, możesz poprosić o pobranie nowego odpisu i zaktualizowanie informacji.</p>

                <div class="row">

                    <div class="block nobg block-simple col-md-12">
                        <header>
                            <div class="sm">Pobrane odpisy</div>
                        </header>
                        <section class="content">
                            <div class="row">

                                <div class="col-md-8">
                                    <? if (@count($odpisy)) { ?>
                                    <div class="list-group">
                                        <? foreach ($odpisy as $odpis) { ?>
                                            <div class="list-group-item">

                                                <? if ($odpis['complete']) { ?>
                                                    <a class="pull-right label label-success"
                                                       href="<?= $object->getUrl() ?>/odpisy/<?= $odpis['id'] ?>">Pobrany</a>
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

                                                    <? if ($odpis['complete']) { ?><a href="<?= $object->getUrl() ?>/odpisy/<?= $odpis['id'] ?>"><? } ?>


                                                    <?= $this->Czas->dataSlownie($odpis['complete_ts']) ?>

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
                                            <button type="submit" class="btn btnUpdate btn-primary btn-icon width-auto">
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
