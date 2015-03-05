<div
    class="container dataBrowser _dataset_<? echo $page['tag'];
    if ($emptyFilters) {
        echo 'emptyFilters';
    }
    if (isset($class)) {
        echo " " . $class;
    } ?>">

    <? echo $this->element('Dane.DataobjectsBrowser/filters', array(
        'filters' => $filters,
        'switchers' => $switchers,
        'facets' => $facets,
        'page' => $page,
        'conditions' => $conditions,
        'emptyFilters' => $emptyFilters,
    )); ?>

    <div class="col-xs-12 col-sm-8 col-md-9 dataObjects">
        <? $config = $dataBrowser->config; ?>

        <div class="dataInfo update-header">
            <? echo $this->element('Dane.DataobjectsBrowser/header', array(
                'pagination' => $pagination,
                'orders' => $orders,
                'page' => $page,
                'controlls' => $config['controlls'],
                'didyoumean' => $didyoumean,
                'emptyFilters' => $emptyFilters,
            )); ?>
        </div>

        <div class="innerContainer update-objects">
            <? echo $this->element('Dane.DataobjectsBrowser/objects', array(
                'objects' => $objects,
                'page' => $page,
                'defaults' => $config['defaults'],
                'renderFile' => $renderFile,
            )); ?>
        </div>

        <div class="paginationList col-xs-12 update-pagination text-center">
            <? echo $this->element('Dane.DataobjectsBrowser/pagination'); ?>
        </div>
    </div>
</div>