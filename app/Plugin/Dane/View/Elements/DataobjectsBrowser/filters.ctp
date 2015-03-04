<div class="col-xs-12 col-sm-4 col-md-3 dataFilters update-filters">

    <? if (!$emptyFilters && $page['showTitle']) { ?>
    <div class="header">
        <<?= $page['titleTag'] ?>><? if (isset($page['back']) && $page['back']) { ?><a href="<?= $page['back'] ?>"
                                                                                       class="btn-back glyphicon glyphicon-circle-arrow-left"></a><? } ?><? if (!empty($this->request->query)) { ?>
        <a
            href="<?= $page['href'] ?>"><? } ?><?= $page['title'] ?><? if (!empty($this->request->query)) { ?></a><? } ?>
    </<?= $page['titleTag'] ?>>
</div>
<? } ?>

<?php echo $this->Filter->generateFilters($filters, $switchers, $facets, $page, $conditions, $dataBrowser->hiddenFilters); ?>

</div>