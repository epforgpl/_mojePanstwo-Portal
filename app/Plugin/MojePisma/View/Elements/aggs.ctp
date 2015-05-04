<div class="btn-group text-left">
    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <? if($selected) {?><span class="glyphicon glyphicon-ok"></span> <?}?><?= $label ?> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?
            $query = $this->request->query;
            unset( $query[$var] );
        ?>
        <li><a href="/moje-pisma?<?= http_build_query($query) ?>"><?= $allLabel ?></a></li>
        <li class="divider"></li>
        <? foreach( $data['buckets'] as $a ) {
            $query = $this->request->query;
            $query[$var] = $a['key'];
        ?>
        <li><a class="overflow-auto" href="/moje-pisma?<?= http_build_query($query) ?>"><span class="pull-left"><?= $this->Text->truncate($a['label'], 30) ?></span><span class="badge pull-right"><?= $a['count'] ?></span></a></li>
        <? } ?>
    </ul>
</div>