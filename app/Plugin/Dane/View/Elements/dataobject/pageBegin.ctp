<?
/** @var Object $object */
$object = $this->viewVars['object'];
$objectOptions = $this->viewVars['objectOptions'];
/** @var Object $microdata */
$objectOptions['microdata'] = $microdata;

if (isset($titleTag)) {
    $objectOptions['titleTag'] = $titleTag;
}

if (!isset($renderFile) || !$renderFile)
    $renderFile = 'page';

$menu = isset($this->viewVars['menu']) ? $this->viewVars['menu'] : false;
$buttons = isset($objectOptions['buttons']) ? $objectOptions['buttons'] : array('shoutIt');
?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('naglosnij', array('plugin' => 'Dane'))) ?>

<?php $this->Combinator->add_libs('js', array('Dane.naglosnij', 'Dane.related-tabs')); ?>

<div<? if ($objectOptions['microdata']['itemtype']) { ?> itemscope itemtype="<?= $objectOptions['microdata']['itemtype'] ?>"<? } ?>
    class="objectsPage">
    <?php if (isset($_ALERT_QUERIES)) {
        $alertArray = array();
        foreach ($_ALERT_QUERIES as $alert) {
            preg_match_all("'<em>(.*?)</em>'si", $alert['hl'], $match);
            foreach ($match[1] as $word) {
                $alertArray[] = $word;
            }
            $alertArray = array_unique($alertArray);
        }

        echo $this->Element('dataobject/searchInPage', array(
            'alerts' => $alertArray
        ));
    } ?>

    <?php if ($domainMode == "PK" || (isset($object) && (($object->getDataset() == 'gminy') && ($object->getId() == '903')))) {
        echo $this->Element('appheader');
    } else { ?>
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
                        <? if ($_breadcrumbs) { ?>
                            <div class="col-md-12">
                                <ol class="breadcrumb">
                                    <? foreach ($_breadcrumbs as $b) { ?>
                                        <li>
                                            <a href="<?= $b['href'] ?>"><? if (isset($b['icon']) && $b['icon']) echo $b['icon'] . ' '; ?><?= $b['label'] ?></a>
                                        </li>
                                    <? } ?>
                                </ol>
                            </div>
                        <? } ?>

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
					

                </div>
            </div>
						
			<? if (isset($object_menu) && !empty($object_menu)) { ?>
	            <div class="menuTabsCont">
	                <div class="container">
	                    <?
	                    echo $this->Element('Dane.dataobject/menuTabs', array(
	                        'menu' => $object_menu,
	                    ));
	                    ?>
	                </div>
	            </div>
	        <? } ?>
            
        </div>
    <?php } ?>
    <div class="objectsPageWindow">
        <div class="container">
            <div class="row">
                <div class="objectsPageContent main">