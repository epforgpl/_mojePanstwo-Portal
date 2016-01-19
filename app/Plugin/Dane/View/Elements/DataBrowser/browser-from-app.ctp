<?
echo $this->Html->css($this->Less->css('app'));

$displayAggs = isset($displayAggs) ? (boolean)$displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);

echo $this->element('headers/main');
?>

<div class="app-sidebar">
	
	<?
		
		// w zmiennej $_app są dane potrzebne do wyświetlenia aktualnej aplikacji (jej id, nazwa, ikona itd)	
		// debug($_app);
	
		
		// w zmiennej $app_chapters['items'] są dane do menu aplikacji
		// Tutaj usuwam na chama pierwszy element menu (array_shift)
		// docelowo jutro zmienie kod kontrolera, żeby tej pozycji w ogóle nie wrzucało
		
		// array_shift( $app_chapters['items'] );
		// debug($app_chapters['items']);
			
	?>
	
    <div class="app-logo">
        <? if (!empty($appSettings) && $appSettings['shortTitle'] !== 'mojePaństwo') { ?>
            <a href="#" target="_self">
                <img class="icon"
                     src="/<?= strtolower($appSettings['shortTitle']) ?>/icon/icon_<?= strtolower($appSettings['shortTitle']) ?>.svg">
                <strong><?= $appSettings['title'] ?></strong>
            </a>

        <? } ?>
    </div>
    <ul class="app-list">
        <? foreach ($_applications as $a) {
            if ($a['tag'] == 1) {
                $icon = ($a['icon']) ? 'data-icon-applications="' . $a['icon'] . '"' : 'data-icon="&#xe612;"';
                ?>
                <li>
                    <a href="<?= $a['href'] ?>" target="_self">
                        <span class="icon" <?= $icon; ?>></span>
                        <strong><?= $a['name'] ?></strong>
                    </a>
                </li>
            <? }
        } ?>
        <li class="active"><span class="icon" data-icon="&#xe612;"></span><strong>Menu aplikacji</strong>
        <li><span class="icon" data-icon="&#xe612;"></span><strong>Menu aplikacji</strong>
            <ul>
                <li>submenu aplikacji</li>
                <li>submenu aplikacji</li>
                <li>submenu aplikacji</li>
            </ul>
        </li>
        <li><span class="icon" data-icon="&#xe612;"></span><strong>Menu aplikacji</strong></li>
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
