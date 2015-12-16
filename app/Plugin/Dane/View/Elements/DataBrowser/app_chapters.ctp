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

                    $classes = array();

                    if( isset($item['class']) )
	                	$classes[] = $item['class'];

                    if( isset($item['href']) && $active )
	                	$classes[] = 'active';

                ?>

	                <li class="<?= implode(' ', $classes) ?>">
	                	<? if(isset($item['href'])) {?><a href="<?= $item['href'] ?>"><? } else { ?><span><? } ?>
		                	<? if(isset($item['icon'])) {?>
                                <span
                                    class="object-icon <?= $item['icon'] ?>"<? if (isset($item['appIcon'])) { ?> data-icon-applications="<?= $item['appIcon'] ?>"<? } ?>></span>
		                	<? } ?>
                            <div<? if (isset($item['icon'])) { ?> class="object-icon-side"<? } ?>><? if (isset($item['count'])) { ?>
                                    <span
                                        class="counter pull-right"><?= number_format_h($item['count']) ?></span><? } ?><?= $item['label'] ?>
                            </div>
	                    <? if(isset($item['href'])) {?></a><? } else { ?></span><? } ?>

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
