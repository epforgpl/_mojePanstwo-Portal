<?= $this->element('Admin.header'); ?>
<? $this->Combinator->add_libs('js', 'Admin.krscandidate'); ?>

<ul class="nav nav-tabs margin-top-10">
    <li role="presentation" <? if ($type == 'sejm'){ ?>class="active"<? } ?>><a href="/admin/krs_candidates/index/sejm">Sejm</a>
    </li>
    <li role="presentation" <? if ($type == 'senat'){ ?>class="active"<? } ?>><a
            href="/admin/krs_candidates/index/senat">Senat</a></li>
</ul>
<ul class="nav nav-tabs margin-top-10">
    <li role="presentation" <? if ($stan == 0){ ?>class="active"<? } ?>><a
            href="/admin/krs_candidates/index/<?= $type ?>/0">Do decyzji</a></li>
    <li role="presentation" <? if ($stan == 3){ ?>class="active"<? } ?>><a
            href="/admin/krs_candidates/index/<?= $type ?>/3">Zaakceptowane</a></li>
    <li role="presentation" <? if ($stan == 4){ ?>class="active"<? } ?>><a
            href="/admin/krs_candidates/index/<?= $type ?>/4">Odrzucone</a></li>
</ul>

<?
if (!$page_count == 0) {
    ?>
    <ul class="list-group margin-top-10"><?
        foreach ($lista as $list) { ?>

            <li class="list-group-item kandydat" data-kandydat-id="<?= $list['id'] ?>">
                <div class="row">
                    <div class="col-sm-4"><h3><?= $list['imiona'] ?> <?= $list['nazwisko'] ?></h3></div>
                    <div class="col-sm-3"><h3><?= $list['data_urodzenia'] ?></h3></div>
                </div>
                <div class="row">
                    <div class="col-sm-6"><?= $list['miejsce_zamieszkania'] ?></div>
                    <div class="col-sm-6"><?= $list['zawod'] ?></div>
                </div>
                <ul class="list-group">
                    <? foreach ($list['krs'] as $osoba) { ?>
                        <li class="list-group-item krs_osoba" data-krs-kandydat-id="<?= $osoba['kandydowanie_id'] ?>">
                            <div class="row">
                                <div class="col-sm-4"><h4><?= $osoba['imiona'] ?> <?= $osoba['nazwisko'] ?></h4></div>
                                <div class="col-sm-4"><h4><?= $osoba['data_urodzenia'] ?></h4></div>
                                <div class="col-sm-4">
                                    <div class="pull-right">
                                        <? if ($stan != 3) { ?>
                                            <button class="btn btn-success btn-accept"><span
                                                    class="glyphicon glyphicon-ok"></span>
                                            </button>
                                        <? } ?>
                                        <? if ($stan != 4) { ?>
                                            <button class="btn btn-danger btn-remove"><span
                                                    class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        <? } ?>
                                        <? if ($stan != 0) { ?>
                                            <button class="btn btn-primary btn-consider"><span
                                                    class="glyphicon glyphicon-refresh"></span>
                                            </button>
                                        <? } ?>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12"><?= $osoba['str'] ?></a></div>
                            </div>
                        </li>
                    <?
                    } ?>
                </ul>
            </li>

        <? }
        ?>
    </ul>

    <div class="btn-group" role="group" aria-label="First group">
        <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>" class="btn btn-default" <? if ($page == 1){
        ?>disabled="disabled"<? } ?>><span class="glyphicon glyphicon-fast-backward"></span></a>
        <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page - 1 ?>" class="btn btn-default"
           <? if ($page == 1){
           ?>disabled="disabled"<? } ?>><span class="glyphicon glyphicon-step-backward"></span></a>
        <? if ($page < 2) { ?>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/1" class="btn btn-default"
               <? if ($page == 1){ ?>disabled="disabled"<? } ?>>1</a>
            <? if ($page_count > 1) { ?>
                <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/2" class="btn btn-default"
                   <? if ($page == 2){ ?>disabled="disabled"<? } ?>>2</a>
            <? }
            if ($page_count > 2) {
                ?>
                <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/3" class="btn btn-default"
                   <? if ($page == 3){ ?>disabled="disabled"<? } ?>>3</a>
            <? }
            if ($page_count > 3) {
                ?>
                <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/4" class="btn btn-default"
                   <? if ($page == 4){ ?>disabled="disabled"<? } ?>>4</a>
            <? }
            if ($page_count > 4) {
                ?>
                <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/5" class="btn btn-default"
                   <? if ($page == 5){ ?>disabled="disabled"<? } ?>>5</a>
            <? } ?>
        <? } elseif ($page > $page_count - 2) { ?>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page_count - 4 ?>"
               class="btn btn-default"
               <? if ($page == $page_count - 4){ ?>disabled="disabled"<? } ?>><?= $page_count - 4 ?></a>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page_count - 3 ?>"
               class="btn btn-default"
               <? if ($page == $page_count - 3){ ?>disabled="disabled"<? } ?>><?= $page_count - 3 ?></a>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page_count - 2 ?>"
               class="btn btn-default"
               <? if ($page == $page_count - 2){ ?>disabled="disabled"<? } ?>><?= $page_count - 2 ?></a>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page_count - 1 ?>"
               class="btn btn-default"
               <? if ($page == $page_count - 1){ ?>disabled="disabled"<? } ?>><?= $page_count - 1 ?></a>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page_count ?>" class="btn btn-default"
               <? if ($page == $page_count){ ?>disabled="disabled"<? } ?>><?= $page_count ?></a>
        <? } else { ?>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page - 2 ?>"
               class="btn btn-default"><?= $page - 2 ?></a>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page - 1 ?>"
               class="btn btn-default"><?= $page - 1 ?></a>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page ?>" class="btn btn-default"
               disabled="disabled"><?= $page ?></a>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page + 1 ?>"
               class="btn btn-default"><?= $page + 1 ?></a>
            <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page + 2 ?>"
               class="btn btn-default"><?= $page + 2 ?></a>
        <? } ?>
        <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page + 1 ?>" class="btn btn-default"
           <? if ($page == $page_count){
           ?>disabled="disabled"<? } ?>><span class="glyphicon glyphicon-step-forward"></span></a>
        <a href="/admin/krs_candidates/index/<?= $type ?>/<?= $stan ?>/<?= $page_count ?>" class="btn btn-default"
           <? if ($page == $page_count){
           ?>disabled="disabled"<? } ?>><span class="glyphicon glyphicon-fast-forward"></span></a>
    </div>
    <span class="margin-left-5">z <?= $page_count ?> stron.</span>
<? } else {
    ?>
    <h4>Nie ma kandydatów spełniających podane warunki.</h4>
<? } ?>
<?= $this->element('Admin.footer'); ?>
