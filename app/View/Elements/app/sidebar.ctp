<div class="app-sidebar<? if (empty($app_chapters['items'])) {
    echo ' app-sidebar-oneline';
} ?>">
    <? if (!empty($_app)) { ?>
    <div class="app-logo">

        <a href="/<?= $_app['id'] ?>" target="_self">
            <img class="icon"
                 src="<?= $_app['href'] ?>/icon/icon_<?= $_app['id'] ?>.svg">
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
                <li>
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
                    <? /* <ul class="sub-list"><li><li></ul> */ ?>
                </li>
                <?
            }
        }
        ?>
    </ul>
</div>