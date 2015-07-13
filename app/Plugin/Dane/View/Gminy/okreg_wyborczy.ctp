<?php // $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane'))); ?>
<?php // $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>
<?php // $this->Combinator->add_libs('js', 'Dane.view-gminy'); ?>

<?

echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

$objectOptions = array(
    'hlFields' => array(),
    'bigTitle' => true,
);
?>

    <div class="header subobject row">
        <p class="subtitle">
            <a href="/dane/gminy/<?= $okreg->getData('gmina_id') ?>/okregi_wyborcze"><span
                    class="glyphicon glyphicon-align-justify"></span> Okręgi wyborcze w wyborach samorządowych 2010
                r.</a>
        </p>

        <h1>Okręg wyborczy #<?= $okreg->getData('numer') ?></h1>
        <? if ($okreg->getDescription()) { ?>
            <p class="description">
                <?= $okreg->getDescription() ?>
            </p>
        <? } ?>
    </div>

<?
echo $this->Element('Dane.objects/gminy_okregi_wyborcze/page', array(
    'object' => $okreg,
));

echo $this->Element('dataobject/pageEnd');