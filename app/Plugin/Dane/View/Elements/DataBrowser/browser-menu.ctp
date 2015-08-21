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
