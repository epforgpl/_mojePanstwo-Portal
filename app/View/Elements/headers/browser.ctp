<?php
echo $this->Html->css($this->Less->css('dataobject', array('plugin' => 'Dane')));
?>

<div class="objectsPage no-min">
    <div class="dataBrowser margin-top-0">

        <div class="searcher-app">
            <div class="container">
                <?= $this->element('Dane.DataBrowser/browser-searcher'); ?>
            </div>
        </div>

        <? if (@isset($app_menu)) { ?>
            <div class="apps-menu">
                <div class="container">
                    <ul>
                        <? foreach ($app_menu[0] as $a) { ?>
                            <li>
                                <a<? if (isset($a['active']) && $a['active']) { ?> class="active"<? } ?>
                                    href="<?= $a['href'] ?>"><?= $a['title'] ?></a>
                            </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
        <? } ?>
    </div>
</div>
