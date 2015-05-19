<div
    class="objectPageHeaderBg <?
    echo ' ' . $this->request->params['controller'];
    ?>
        
        <?php if ((isset($headerObject) && (!empty($headerObject['url']) || !empty($headerObject['height'])))) {
        echo ' extended';

        echo '" style="';
        if (!empty($headerObject['url'])) echo 'background-image: url(' . $headerObject['url'] . ');';
        if (!empty($headerObject['height'])) echo 'min-height:' . $headerObject['height'] . ';';

    } ?>">
    <div
        class="objectPageHeaderContainer topheader">
        <div class="container">
            <div class="row">
                <? if (isset($_breadcrumbs) && $_breadcrumbs) { ?>
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <? foreach ($_breadcrumbs as $b) { ?>
                                <li>
                                    <a href="<?= $b['href'] ?>"><?= $b['label'] ?></a>
                                </li>
                            <? } ?>
                        </ol>
                    </div>
                <? } ?>
            </div>
			
			<div class="row">
                <div class="col-xs-12">
                    <div
                        class="objectPageHeader<? if (isset($object_menu['items']) && !empty($object_menu['items'])) { ?> with-menu <? } ?>">
                        <?php echo $this->Dataobject->render($object, $renderFile, $objectOptions); ?>
                    </div>
                </div>
                <? /*
            <div class="objectButtonsContainer col-md-3">
                <div class="row">
                    <ul class="objectButtons">
                        <? foreach ($buttons as $button) { ?>
                            <li><?
                                $this->Element('dataobject/buttons/' . $button, array(
                                    'base_url' => '/dane/' . $object->getDataset() . '/' . $object->getId(),
                                )); ?></li>
                        <?  } ?>
                    </ul>
                </div>
            </div>
            */ ?>
            </div>
            
	        <? echo @$this->Element('Dane.sides/' . $this->request->params['controller'] . '-top'); ?>



        </div>
    </div>
				
    <? if (isset($_menu) && !empty($_menu)) { ?>
        <div class="menuTabsCont">
            <div class="container">
                <?
	            if( !isset($_menu['base']) )
	                $_menu['base'] = $object->getUrl();
                echo $this->Element('Dane.dataobject/menuTabs', array(
                    'menu' => $_menu,
                ));
                ?>
            </div>
        </div>
    <? } ?>

</div>