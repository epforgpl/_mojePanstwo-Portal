<?
	$this->Combinator->add_libs('css', $this->Less->css('app_chapters'));
?>
<ul class="dataAggs app_chapters">
    <li class="agg special">

		<div class="agg agg-List agg-Datasets showCounters">

	        <ul class="nav nav-pills nav-stacked">

	            <? foreach ($app_chapters['items'] as $item) {

	                $active = false;

	                if(
		                (
			                !@$app_chapters['selected'] &&
			                (
				                !isset($item['id']) ||
				                !$item['id']
			                )
		                ) ||
		                (
			                @$app_chapters['selected'] &&
			                @$item['id'] &&
			                ( $app_chapters['selected']==$item['id'] )
		                )
	                )
	                	$active = true;

                ?>

	                <li<? if($active) { ?> class="active"<?}?>>
	                	<a href="<?= $item['href'] ?>">
		                	<? if(isset($item['icon'])) {?>
			                	<i class="object-icon <?= $item['icon'] ?>"></i>
		                	<? } ?>
		                	<div<? if(isset($item['icon'])) {?> class="object-icon-side"<?}?>>
		                	<?= $item['label'] ?><? if (isset($item['count'])) { ?> <span class="counter"><?= number_format_h($item['count']) ?></span><? } ?>
		                	</div>
	                    </a>

	                    <? if( isset($item['element']) ) echo $this->element($item['element']['path']); ?>

                        <? if($active && isset($item['submenu']) && count($item['submenu']['items'])) { ?>

                            <ul class="nav nav-pills nav-stacked appChapterSubMenu">
                                <? foreach($item['submenu']['items'] as $subitem) {


                                    $subactive = false;

                                    if(
                                        (
                                            @$item['submenu']['selected'] &&
                                            @$subitem['id'] &&
                                            ( $item['submenu']['selected']==$subitem['id'] )
                                        )
                                    )
                                        $subactive = true;

                                    ?>
                                    <li<? if($subactive) { ?> class="active"<?}?>>
                                        <a href="<?= $item['href'] . $subitem['href'] ?>">
                                            <?= $subitem['label'] ?>
                                        </a>
                                    </li>
                                <? } ?>
                            </ul>

                        <? } ?>

	                </li>

	            <? } ?>

	        </ul>

		</div>

    </li>
</ul>
