<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))); ?>

<?php $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax') ?>
<?php $this->Combinator->add_libs('js', 'Dane.filters'); ?>

<div class="container dataBrowser innerSearch">
    <? if (isset($searchTitle) && $searchTitle) { ?>
        <div class="col-xs-12 col-md-9 col-md-offset-3 header">
            <h1><?= $searchTitle ?></h1>
        </div>
    <? } ?>

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-3 dataFilters">
            <?php echo $this->Filter->generateFilters($filters, $facets); ?>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-9 dataObjects">
            <div class="dataInfo">
                <div class="col-xs-12 col-sm-4 dataStats">
                    <strong><?= $this->Number->currency($pagination['total'], '', array('places' => 0,)); ?></strong>
                    <?php echo __d('dane', 'LC_DANE_WYNIKOW'); ?>
                </div>
                <div class="col-xs-12 col-sm-8 dataSortings">
                    <?php
                    $options = array();
                    foreach ($sortings as $sorting) {
                        $options[$sorting['sorting']['field']] = $sorting['sorting']['label'];
                    }
                    ?>
                    <?php echo $this->Form->create('Dataset', array('type' => 'get')); ?>
                    <?php foreach ($this->params->query as $field => $param) { ?>
                        <?php
                        if (is_array($param)) {
                            foreach ($param as $sub) {
                                echo $this->Form->hidden($field . '[]', array('value' => $sub));
                            }
                        } else {
                            if ($field != 'sort' && $field != 'direction') {
                                echo $this->Form->hidden($field, array('value' => $param));
                            }
                        }
                        ?>
                    <?php } ?>
                    <div class="row">
                        <?php echo $this->Form->submit(__d('dane', 'LC_DANE_SORTUJ'), array('class' => 'sortingButton btn btn-primary input-sm hidden-xs')); ?>
                        <?php echo $this->Form->select('direction', array(
                            'asc' => __d('dane', 'LC_DANE_ROSNACO', true),
                            'desc' => __d('dane', 'LC_DANE_MALEJACO', true)
                        ), array('empty' => false, 'class' => 'form-control input-sm')); ?>
                        <?php echo $this->Form->select('sort', $options, array('class' => 'form-control input-sm')); ?>
                        <strong
                            class="sortingName hidden-xs"><?php echo __d('dane', 'LC_DANE_SORTOWANIE'); ?></strong>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
            <div class="innerContainer">
                <ul class="list-group list-dataobjects">
                    <? foreach ($dataobjects as $dataobject) {
                        echo $this->Dataobject->render($dataobject['Dataobject']);
                    } ?>
                </ul>
                <div class="paginationList col-xs-12 col-sm-6 col-sm-offset-3">
                    <ul class="pagination pagination-sm">
                        <?php $this->Paginator->options(array(
                            'url' => array(
                                'plugin' => 'Dane',
                                'controller' => $this->params->controller,
                                'id' => $object->object_id,
                                '?' => $this->request->query
                            )
                        )); ?>
                        <?php echo $this->Paginator->numbers(array(
                            'tag' => 'li',
                            'currentTag' => 'a',
                            'currentClass' => 'active',
                            'separator' => false,
                            'escape' => false
                        )); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>