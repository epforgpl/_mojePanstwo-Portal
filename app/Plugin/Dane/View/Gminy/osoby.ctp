<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin');
?>

<div class="objectsPage">

    <h1 class="subheader">Krajowy Rejestr Sądowy w Krakowie</h1>

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

    <? $options = array();
    if (isset($title))
        $options['title'] = $title;

    echo $this->Element('Dane.DataBrowser/browser', $options);
    ?>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
