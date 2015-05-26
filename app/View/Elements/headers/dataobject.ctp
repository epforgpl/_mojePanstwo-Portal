<?php
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

echo $this->element('headers/' . $_layout['header']['element'], array(
    'object' => $object,
    'objectOptions' => $objectOptions,
    'menu' => $menu,
    'buttons' => $buttons,
    'renderFile' => $renderFile,
)) ?>