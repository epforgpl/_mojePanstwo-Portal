<div class="agg agg-Dataobjects">
    <? if (@$data['aggregations']['dokumenty']['hits']['hits']) { ?>
        <ul class="dataobjects">
            <? foreach ($data['aggregations']['dokumenty']['hits']['hits'] as $doc) {?>
                <li>
                    <?
                      echo $this->Dataobject->render($doc, 'default');
                    ?>
                </li>
            <? } ?>
        </ul>
        <div class="buttons">
            <a href="#" class="btn btn-primary btn-xs">Zobacz więcej</a>
        </div>
    <? } ?>
</div>