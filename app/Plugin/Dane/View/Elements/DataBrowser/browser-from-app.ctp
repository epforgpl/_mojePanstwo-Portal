<?
$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);

echo $this->element('headers/main');
?>
<div class="objectsPage">
	<div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">

		

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
