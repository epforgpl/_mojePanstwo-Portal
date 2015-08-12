<div class="row">
    <form id="filters_form" data-expand="<?= $expand_dimension ?>" class="bdl-select col-xs-12">
        <ul>
            <? foreach ($dims as $key => $d) {
                if ($key != $expand_dimension) {
                    ?>
                    <li class="filter col-xs-11 col-sm-6 col-md-3">
                        <p class="label"><? if( !isset($dimension) ) {?><a class="link-discrete" href="<?= $object->getUrl() ?>?i=<?= $key ?>"><? } ?> <?= $d['label'] ?><? if( !isset($dimension) ) {?></a><? } ?>:</p>

                        <p class="value">
                            <select name="d<?= $d['order'] ?>">
                                <? foreach ($d['options'] as $o) { ?>
                                    <option<? if (@$o['selected'] == true) { ?> selected="selected"<?php } ?>
                                        value="<?= $o['id'] ?>"><?= $o['value'] ?></option>
                                <? } ?>
                            </select>
                        </p>
                    </li>
                <? } elseif (isset($redirect) && $redirect) { ?>
                    <li class="filter" style="display: none;">
                        <p class="label"><?= $d['label'] ?>:</p>

                        <p class="value">
                            <select name="d<?= $d['order'] ?>">
                                <? foreach ($d['options'] as $o) { ?>
                                    <option<? if (@$o['selected'] == true) { ?> selected="selected"<?php } ?>
                                        value="<?= $o['id'] ?>"><?= $o['value'] ?></option>
                                <? } ?>
                            </select>
                            <input name="d" value="1"/>
                        </p>
                    </li>
                <? } ?>
            <? } ?>
        </ul>
    </form>
</div>
