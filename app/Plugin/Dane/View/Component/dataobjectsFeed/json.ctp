<div id="objectstatus">
    <strong><?= $this->Number->currency($total, '', array('places' => 0,)); ?></strong>
</div>
<div class="innerContainer">
    <ul class="list-group list-dataobjects">
        <?
        $bg = false;
        foreach ($objects as $object) {
            echo $this->Dataobject->render($object['Dataobject'], 'default', array(
                'bg' => $bg,
                'hlFields' => $dataBrowser->hlFields,
                'routes' => $dataBrowser->routes,
            ));
            $bg = !$bg;
        }
        ?>
    </ul>
</div>

<div class="paginationList col-xs-12">
    <ul class="pagination pagination-sm">
        <?
        echo $this->Paginator->numbers(array(
            'tag' => 'li',
            'currentTag' => 'a',
            'currentClass' => 'active',
            'separator' => false,
            'escape' => false,
        ));
        ?>
    </ul>
</div>

<div id="hiddenFilters">
    <div class="header">
        <h1>
            <a href="<?= $page['href'] ?>">
                <?= $page['title'] ?>
            </a>
        </h1>
    </div>

    <?php echo $this->Filter->generateFilters($filters, $switchers, $facets, $page); ?>

</div>