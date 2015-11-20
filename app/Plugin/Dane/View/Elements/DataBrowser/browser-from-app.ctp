<?
$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);
?>
<div class="objectsPage">
	<div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">

		<div class="searcher-app">
			<div class="container">
			    <?= $this->element('Dane.DataBrowser/browser-searcher', array(
			    	'size' => 'md',
			    )); ?>
			</div>
		</div>

		<? if( @isset($app_menu) ) {?>
		<div class="apps-menu">
			<div class="container">
			    <ul>
				    <? foreach($app_menu[0] as $a) { ?>
				    <li>
				    	<a<? if( isset($a['active']) && $a['active'] ){?> class="active"<? } ?> href="<?= $a['href'] ?>"><?= $a['title'] ?></a>
				    </li>
				    <? } ?>
			    </ul>
			</div>
		</div>
		<? } ?>

		<div class="container">
            <div class="dataBrowserContent">

                <?

                    $options = array(
                        'displayAggs' => $displayAggs,
                        'columns' => $columns,
                        'searcher' => false,
                    );

                    if(isset($menu)) {
                        $options['menu'] = $menu;
                    }

                ?>

			    <?= $this->element('Dane.DataBrowser/browser-content', $options); ?>

		    </div>
		</div>

	</div>
</div>
