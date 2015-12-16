<? if( isset($items) && !empty($items) ) {?>
<div class="banner datasets block">
    <p><strong>Przeglądaj zbiory danych:</strong></p>
    <ul>
    <? foreach( $items as $item ) {?>
        <li><a class="link-discrete" href="<?= $object->getUrl() ?>/<?= $item['id'] ?>"><span
                    class="object-icon icon-datasets-<?= $item['dataset'] ?>"></span> <?= $item['label'] ?></a></li>
	<? } ?>
    </ul>
</div>
<? } ?>
