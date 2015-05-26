<?php
$object = $this->viewVars['object'];
if (!isset($renderFile) || !$renderFile)
    $renderFile = 'page';
$objectOptions = $this->viewVars['objectOptions'];
$objectOptions['microdata'] = $microdata;
?>

<div class="appHeader">
    <div class="container">
        <div class="holder row">
            <div class="col-md-8">
                <ul class="breadcrumb">
                    <?php foreach ($_breadcrumbs as $bread) { ?>
                        <li><a href="<?= $bread['href'] ?>" target="_self"><?= $bread['label'] ?></a></li>
                    <? } ?>
                </ul>
                <div class="title"><h2><?= $object->getTitle(); ?></h2></div>
            </div>
        </div>
    </div>
</div>