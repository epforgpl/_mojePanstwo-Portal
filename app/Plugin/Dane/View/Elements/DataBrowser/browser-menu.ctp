<? if(isset($pills)) { ?>
    <ul class="nav nav-pills nav-stacked margin-top-10">
        <? foreach($pills['items'] as $p => $pill) { ?>
            <li<? if($pills['selected'] == $p) echo ' class="active"'; ?>>
                <a href="?<?= $pills['param'] ?>=<?= $p ?>">
                    <?= $pill['label'] ?>
                </a>
            </li>
        <? } ?>
    </ul>
<? } ?>

<ul class="dataAggs">
    <li class="agg special">
        <div class="agg agg-List agg-Datasets">
            <ul class="nav nav-pills nav-stacked">
                <?php foreach($menu['items'] as $item) { ?>
                    <li<? if($menu['selected'] == $item['id']) echo ' class="active"' ?>>
                        <a href="<?= $menu['base'] . '/' . $item['id'] ?>">
                            <?= $item['label'] ?>
                        </a>
                    </li>
                <? } ?>
            </ul>
        </div>
    </li>
</ul>
