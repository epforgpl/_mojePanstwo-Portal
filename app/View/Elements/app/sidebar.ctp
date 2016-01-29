<div class="app-sidebar<? if (empty($app_chapters['items'])) {
    echo ' app-sidebar-oneline';
} ?>">
    <? if (!empty($_app)) { ?>
        <div class="app-logo">

            <a href="/<?= $_app['id'] ?>" target="_self">
                <img class="icon"
                     src="<? $path = (isset($_app['path']) && !empty($_app['path'])) ? $_app['path'] : $_app['id'];
                     echo '/' . $path ?>/icon/icon_<?= $_app['id'] ?>.svg">
                <p><?= $_app['name'] ?></p>
            </a>

            <? if (!empty($app_chapters['items'])) { ?>
                <div class="_mobile btn btn-link btn-sm"></div>
            <? } ?>

        </div>
    <? } ?>

    <ul class="app-list">
        <?
        if (@$app_chapters['items']) {
            foreach ($app_chapters['items'] as $a) {
                ?>
                <li class="<? if (isset($app_chapters['selected']) && ($app_chapters['selected'] == $a['id'])) { ?>active <? } ?><? if (isset($a['submenu']) && $a['submenu']) { ?>sub<? } ?>">
                    <? if (isset($a['href'])) {
                        echo '<a href="' . $a['href'] . '" target="_self">';
                    } else {
                        echo '<div class="blank">';
                    }
                    ?>
                    <span class="icon <?= $a['icon'] ?>"></span>
                    <strong><?= $a['label'] ?></strong>
                    <? if (isset($a['href'])) {
                        echo '</a>';
                    } else {
                        echo '</div>';
                    } ?>
                </li>
                <?
            }
        }
        ?>
    </ul>
</div>
