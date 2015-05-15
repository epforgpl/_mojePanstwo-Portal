<?
	
	$objectRenderOptions = array(
		'forceLabel' => ( isset($dataBrowserObjectRender) && isset($dataBrowserObjectRender['forceLabel']) ) ? (boolean) $dataBrowserObjectRender['forceLabel'] : false,
	);
	
	
$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);

$shortTitle = $object->getData('nazwa');
$metaDesc = array(
	dataSlownie( $object->getDate() ),
);

if( isset($object->options['czesc']) )
	$metaDesc[] = number_format_h($object->options['czesc']['cena']) . ' ' . $object->options['czesc']['waluta'];

$object_content_sizes = array(2, 10);

// debug( $object->getData() ); 

$this->Dataobject->setObject($object);
?>
<div class="objectRender<? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?><? if( $classes = $object->getClasses() ) { echo " " . implode(' ', $classes); } ?>"
     oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <div class="row">

        <div class="data col-xs-12">

            <? if ($sentence = $object->getSentence()) { ?>
                <p class="sentence"><?= $sentence ?></p>
            <? } ?>

            <div>

                
                    <div class="content<? if ($object->getPosition()) { ?> col-md-11<? } ?>">

                        <? if ($alertsButtons) { ?>
                            <div class="alertsButtons pull-right">
                                <input class="btn btn-xs read" type="button"
                                       value="<?php echo __d('powiadomienia', 'LC_POWIADOMIENIA_OPTIONS_ALERT_BUTTON_READ'); ?>"/>
                                <input class="btn btn-xs unread" type="button"
                                       value="<?php echo __d('powiadomienia', 'LC_POWIADOMIENIA_OPTIONS_ALERT_BUTTON_UNREAD'); ?>"/>
                            </div>
                        <? } ?>
						
						<? if($object->getIcon()) { echo $object->getIcon(); } ?>
						
						<div class="<? if($object->getIcon()) {?>object-icon-side <?}?>">
					
					

                        <p class="title">
                            <?php if ($object->getUrl() != false){ ?>
                            <a href="<?= $object->getUrl() ?>" title="<?= strip_tags($object->getTitle()) ?>">
                                <?php } ?>
                                <?= $this->Text->truncate($shortTitle, 150) ?>
                                <?php if ($object->getUrl() != false){ ?>
                            </a> <?
                        }
                        if ($object->getTitleAddon()) {
                            echo '<small>' . $object->getTitleAddon() . '</small>';
                        } ?>
                        </p>
                        
                        <p class="meta meta-desc"><?= implode(' - ', $metaDesc) ?></p>
                        
                        <?
	                    	                    
	                    // debug( $object->getData() );
                        if ($file_exists) {
                            echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
                                'object' => $object,
                                'hlFields' => $hlFields,
                                'hlFieldsPush' => $hlFieldsPush,
                                'defaults' => $defaults,
                            ));
                        } else {
                            // echo $this->Dataobject->highlights($hlFields, $hlFieldsPush, $defaults);
                        }
                        ?>

                        <? if( 
							( $object->hasHighlights() ) && 
							( $highlight = $object->getLayer('highlight') )
						) { ?>				
							<? if( $highlight[0] != '<em>' . $object->getShortTitle() . '</em>' ) {?>
							<div class="description">
                                <?= $highlight[0] ?>
                            </div>
                            <? } ?>
                        <? } elseif ($object->getDescription()) { ?>
                            <div class="description">
                                <?= $this->Text->truncate($object->getDescription(), 250) ?>
                            </div>
                        <? } ?>
                        
						</div>

                    </div>

            </div>
        </div>
    </div>
</div>