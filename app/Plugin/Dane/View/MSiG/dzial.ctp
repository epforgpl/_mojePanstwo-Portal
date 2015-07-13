<?
$this->Combinator->add_libs('css', $this->Less->css('view-msig', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
?>

    <h2><?= $dzial->getShortTitle() ?></h2>

<?= $this->Document->place($dzial->getData('dokument_id')) ?>


<?= $this->Element('dataobject/pageEnd'); ?>