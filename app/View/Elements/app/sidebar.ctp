<div class="app-sidebar
<? if (empty($app_chapters['items'])) {
    echo ' app-sidebar-oneline';
} ?>
<? if (!empty($_breadcrumbs)) {
    echo ' has-breadcrumbs';
} ?>
">
    <? if (!empty($_app)) {
        $path = (isset($_app['path']) && !empty($_app['path'])) ? $_app['path'] : $_app['id'];
        ?>
        <div class="app-logo">

            <a href="/<?= $_app['id'] ?>" target="_self">
                <img class="icon" src="<?= '/' . $path ?>/icon/icon_<?= $_app['id'] ?>.svg">
                <p><?= isset($_app['name_' . $_lang]) ? $_app['name_' . $_lang] : $_app['name'] ?></p>
            </a>
			
			<? if( !empty($_breadcrumbs) ) {?>
				<div class="breadcrumbs">
				<? foreach($_breadcrumbs as $bc) {?>
					<span class="separator">/</span>
					<a href="<?= $bc['href'] ?>"><?= $bc['label'] ?></a>
				<? } ?>
				</div>
			<? } ?>
			
            <? if (!empty($app_chapters['items'])) { ?>
                <div class="_mobile btn btn-link btn-sm"></div>
            <? } ?>

        </div>
    <? } ?>
    <div class="app-sidebar-scroll">
        <ul class="app-list">
            <?
            if (@$app_chapters['items']) {
                foreach ($app_chapters['items'] as $a) {
                    ?>
                    <li class="<? if (isset($app_chapters['selected']) && !empty($app_chapters['selected']) && (isset($a['id'])) && ($app_chapters['selected'] == $a['id'])) { ?>active <? } ?><? if (isset($a['submenu']) && $a['submenu']) { ?>sub<? } ?>">
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
        <?
        if (!empty($_app) && $this->_getElementFilename($path . '.aftermenu')) {
            echo '<div class="hidden-xs">';
            echo $this->Element($path . '.aftermenu');
            echo '</div>';
        }
        ?>
    </div>
</div>
