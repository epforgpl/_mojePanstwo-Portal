<?

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));

?>
<div class="objectsPage">
    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">

        <div class="searcher-app">
            <div class="container">
                <?= $this->element('Dane.DataBrowser/browser-searcher'); ?>
            </div>
        </div>

        <? if( @isset($app_menu) ) {?>
            <div class="apps-menu">
                <div class="container">
                    <ul>
                        <? foreach($app_menu[0] as $a) { ?>
                            <li>
                                <a<? if( isset($a['active']) && $a['active'] ){?> class="active"<? } ?> href="<?= $a['href'] ?>"><?= $a['title'] ?></a>
                            </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
        <? } ?>

        <div class="container">
            <div class="row dataBrowserContent">

                <div class="col-md-1-5 dataAggsContainer">
                    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
                </div>

                <div class="col-md-4-5">
                    <div class="dataWrap margin-top-10">
