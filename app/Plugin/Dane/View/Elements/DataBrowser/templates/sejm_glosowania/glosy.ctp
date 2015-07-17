<?

$objectRenderOptions = array(
    'forceLabel' => (isset($dataBrowserObjectRender) && isset($dataBrowserObjectRender['forceLabel'])) ? (boolean)$dataBrowserObjectRender['forceLabel'] : false,
);


$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);

$shortTitle = $object->getData('poslowie.nazwa');

$object_content_sizes = array(2, 10);
$this->Dataobject->setObject($object);
?>
<div class="objectRender<? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?><? if ($classes = $object->getClasses()) {
    echo " " . implode(' ', $classes);
} ?>"
     oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <div class="row">

        <div class="data col-xs-12">
		
            <div>

                

                <?
                $size = $object_content_sizes[0];
                if ($object->getPosition()) {
                    $size--;
                }

                ?>
                <div class="attachment col-xs-<?= $size + 2 ?> col-sm-<?= $size + 1 ?> col-sm-<?= $size ?> text-center">
                    <a href="/dane/poslowie/<?= $object->getData('posel_id') ?>"><img class="thumb pull-right" src="<?= $object->getThumbnailUrl($thumbSize) ?>" alt="<?= strip_tags($object->getTitle()) ?>" onerror="imgFixer(this)"/></a>
                </div>
                
                <?
		        $_map = array(
		            '1' => array('Za', 'success'),
		            '2' => array('Przeciw', 'danger'),
		            '3' => array('Wstrzymanie', 'primary'),
		            '4' => array('Nieobecność', 'default'),
		        );
		
		        if (array_key_exists($object->getData('glos_id'), $_map)) {
		            $m = $_map[$object->getData('glos_id')];
	            ?>
		                <h3 class="label-glos"><span class="label label-md label-<?= $m[1] ?>"><?= $m[0] ?></span></h3>
		        <? } ?>
			
					
                
                <div class="content col-md-<?= $object_content_sizes[1] ?> marginRight">
										
                    <p class="title"><a href="/dane/poslowie/<?= $object->getData('posel_id') ?>"><?= $this->Text->truncate($shortTitle, 150) ?></a></p>

                    <? if( $object->getData('poslowie_glosy.klub_id')!='7' ) { ?>
	                <div class="klub">
	                	<a href="/dane/sejm_kluby/<?= $object->getData('poslowie_glosy.klub_id') ?>"><img src="http://resources.sejmometr.pl/s_kluby/<?= $object->getData('poslowie_glosy.klub_id') ?>_t.png" /></a>             	
	                </div>
                    <? } ?>

                </div>
                    
                    

            </div>
        </div>
    </div>
</div>