<? if ($emptyFilters && $page['showTitle']) { ?>
    <div class="header">
        <<?= $page['titleTag'] ?>><? if (isset($page['back']) && $page['back']) { ?>
<a <? if (isset($page['backTitle'])) { ?>title="<?= $page['backTitle'] ?>"<? } ?> href="<?= $page['back'] ?>"
   class="btn-back glyphicon glyphicon-circle-arrow-left"></a><? } ?><? if (!empty($this->request->query)) { ?><a
    href="<?= $page['href'] ?>"><? } ?><?= $page['title'] ?><? if (!empty($this->request->query)) { ?></a><? } ?>
    </<?= $page['titleTag'] ?>>
</div>
<? } ?>

<form class="nopadding" method="get" action="<?= $page['href'] ?>">

    <div class="input-group">
        <input id="innerSearch" type="text" class="form-control" autocomplete="off" name="q"
               placeholder="<?= __d('dane', __('LC_DANE_SEARCH')) ?>" data-icon-after="&#xe600;"
               value="<?= ((isset($this->params->query['q'])) ? htmlspecialchars($this->params->query['q']) : '') ?>"/>
		<span class="input-group-btn">
			<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
	    </span>
    </div>

    <? if (isset($didyoumean) && $didyoumean) { ?>
        <div class="row dataDidyoumean">
            <div class="col-md-12">
                Czy chodziło Ci o "<a href="#"><?= $didyoumean ?></a>"?
            </div>
        </div>
    <? } ?>

    <div class="row dataSubheader">
        <div class="col-xs-12 col-sm-4 dataStats">
            <div class="row">
                <p>
                    <? if ($pagination['total'] > 1) { ?>
                        <?= _number($pagination['from']) ?> - <?= _number($pagination['to']) ?> z <?= _number($pagination['total']) ?>
                    <? } ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 dataSortings">
            <div class="row">

                <?php // echo $this->Form->submit(__d('dane', 'LC_DANE_SORTUJ'), array('name' => 'search', 'class' => 'sortingButton btn btn-primary input-sm hidden-xs')); ?>

                <?
                $_query = $this->request->query;
                unset($_query['order']);
                unset($_query['search']);

                foreach ($_query as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $_value) {
                            if ($_value != '') {
                                echo '<input type="hidden" name="' . $key . '[]" value="' . htmlspecialchars($_value) . '" />';
                            }
                        }
                    } else {
                        if ($value != '') {
                            echo '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($value) . '" />';
                        }
                    }
                }
                ?>

                <? if (isset($controlls) && !empty($controlls)) { ?>
                    <div class="dataButtons btn-group">
                        <? foreach ($controlls as $controll) { ?>
                            <? if ($controll == 'details') { ?>
                                <button class="dataDetailsToggle btn btn-default btn-sm" data-state="more"><span
                                        class="glyphicon glyphicon-plus"></span> <span
                                        class="text">Więcej szczegółów</span>
                                </button>
                            <? } elseif ($controll == 'sortings') { /*sortowanie*/
                            } ?>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>

</form>
