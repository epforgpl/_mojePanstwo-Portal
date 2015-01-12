<?
$object = $this->viewVars['object'];
$objectOptions = $this->viewVars['objectOptions'];
$objectOptions['microdata'] = $microdata;

if (isset($titleTag)) {
    $objectOptions['titleTag'] = $titleTag;
}

$menu = $this->viewVars['menu'];

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


    <?
    $krakow = ($object->getDataset() == 'krs_podmioty') && ($object->getData('gmina_id') == '903');
    if ($krakow) {
        $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-outside', array('plugin' => 'Dane')));
    }
    ?>

    <div class="objectPageHeaderBg">
        <div
            class="objectPageHeaderContainer topheader <? if (($object->getDataset() == 'gminy') && ($object->getId() == '903')) { ?> krakow<? } ?>">
            <div class="container">
                <? if ($krakow) { ?>
                    <div class="krakow col-md-2">

                        <a title="Program Przejrzysty Kraków, prowadzony przez Fundację Stańczyka, ma na celu wieloaspektowy monitoring życia publicznego w Krakowie. W ramach programu prowadzony jest obecnie monitoring Rady Miasta i Dzielnic Krakowa."
                           href="http://przejrzystykrakow.pl" class="thumb_cont">
                            <img alt="Przejrzysty Kraków" src="/dane/img/customObject/krakow/logo_pkrk.jpg"
                                 onerror="imgFixer(this)" class="thumb">
                        </a>

                    </div>
                <? } ?>
                <div class="objectPageHeaderContainer col-md-<? if ($krakow) {
                    echo '7';
                } else {
                    echo '9';
                } ?>">
                    <div class="objectPageHeader">
                        <?php
                        echo $this->Dataobject->render($object, 'page', $objectOptions);
                        ?>
                    </div>
                </div>
                <div class="objectButtonsContainer col-md-3">
                    <div class="row">
                        <ul class="objectButtons">
                            <? foreach ($buttons as $button) { ?>
                                <li><?=
                                    $this->Element('dataobject/buttons/' . $button, array(
                                        'base_url' => '/dane/' . $object->getDataset() . '/' . $object->getId(),
                                    )); ?></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>





        <?
        if (isset($_menu) && !empty($_menu)) {
            ?>
            <div class="menuTabsCont">
                <div class="container">
                    <?
                    echo $this->Element('Dane.dataobject/menuTabs', array(
                        'menu' => $_menu,
                    ));
                    ?>
                </div>
            </div>

        <? } ?>

    </div>

    <div class="objectsPageWindow">
        <div class="container">
            <div class="row">
                <div class="objectsPageContent main">