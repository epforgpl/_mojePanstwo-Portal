<?
echo $this->Html->css($this->Less->css('app'));

$displayAggs = isset($displayAggs) ? (boolean)$displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);

echo $this->element('headers/main');

array_shift($app_chapters['items']);
?>

<div class="app-sidebar">
    <div class="app-logo">
        <? if (!empty($_app)) { ?>
            <a href="#" target="_self">
                <img class="icon"
                     src="<?= $_app['href'] ?>/icon/icon_<?= $_app['id'] ?>.svg">
                <p><?= $_app['name'] ?></p>
            </a>
        <? } ?>
        <? if (!empty($app_chapters['items'])) { ?>
            <div class="_mobile btn btn-default btn-sm"></div>
        <? } ?>
    </div>
    <ul class="app-list">
        <? foreach ($app_chapters['items'] as $a) { ?>
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
        <? } ?>
    </ul>
</div>

<div class="app-content-wrap">
    <div class="objectsPage">
        <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
            <div class="container">
                <div class="dataBrowserContent">
                    <?
                    $options = array(
                        'displayAggs' => false,
                        'columns' => $columns,
                        'searcher' => true,
                    );

                    /*
                    if(isset($menu)) {
                        $options['menu'] = $menu;
                    }
                    */

                    echo $this->element('Dane.DataBrowser/browser-content', $options);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
