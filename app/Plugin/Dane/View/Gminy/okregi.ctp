<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-okregi', array('plugin' => 'Dane')));
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-okregi');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
)); ?>

    <div class="objectsPage">

        <h1 class="subheader">Rada Miasta Kraków</h1>

        <? if (isset($_submenu) && !empty($_submenu)) { ?>
            <div class="menuTabsCont">
                <?
                if (!isset($_submenu['base']))
                    $_submenu['base'] = $object->getUrl();
                echo $this->Element('Dane.dataobject/menuTabs', array(
                    'menu' => $_submenu,
                ));
                ?>
            </div>
        <? } ?>

        <div id="kto_tu_rzadzi" class="object"></div>

    </div>



<?= $this->Element('dataobject/pageEnd');
