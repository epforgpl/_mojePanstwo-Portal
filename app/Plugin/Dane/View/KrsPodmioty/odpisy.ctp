<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-odpisy');
$odpisy = $object->getLayer('odpisy');

?>
<div class="container">
    <div class="krsPodmioty">
        <div class="col-md-9 objectMain">
            <h4 class="text-muted margin-top-20">
                Ostatnie 10 odpisów z KRS
                <div class="btn btnUpdate btn-primary btn-icon auto-width pull-right">
                    <i class="icon glyphicon glyphicon-refresh"></i>
                    Pobierz nowy odpis
                </div>
            </h4>
            <? if(@count($odpisy)) { ?>
                <div class="list-group margin-top-15">
                    <? foreach($odpisy as $odpis) { ?>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading">
                                <?= $this->Czas->dataSlownie(
                                    date('Y-m-d', strtotime($odpis['complete_ts']))
                                ); ?>
                            </h4>
                            <p class="list-group-item-text">
                                <?= date('H:i:s', strtotime($odpis['complete_ts'])); ?>
                            </p>
                        </li>
                    <? } ?>
                </div>
            <? } ?>
        </div>
        <div class="col-md-3 objectSide"></div>
    </div>
</div>