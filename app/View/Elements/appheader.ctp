<?php $this->Combinator->add_libs('css', $this->Less->css('appheader')) ?>

<div class="appHeader">
    <div class="container">
        <div class="holder">
            <? if (isset($title)) { ?>
                <h1><?= $title ?></h1>
            <? } ?>

            <? if (isset($subtitle)) { ?>
                <h2><?= $subtitle ?></h2>
            <? } ?>
        </div>
    </div>
    <? if (isset($appMenu)) { ?>
        <div class="menu">
            <div class="container">
                <ul>
                    <? foreach ($appMenu as $item) { ?>
                        <li<? if (isset($appMenuSelected) && ($item['id'] == $appMenuSelected)) {
                            echo ' class="active"';
                        } ?>>
                            <a href="/<?= strtolower($this->request->params['plugin']) . '/' . $item['id']; ?>"
                               target="_self"><?= $item['label']; ?></a>
                        </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    <? } ?>
</div>