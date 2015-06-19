<?= $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
)) ?>

    <div class="object-nav">
        <h1 class="title">Wydatki biura poselskiego w <?= $rocznik['rok'] ?> roku</h1>
    </div>

<?
echo $this->Document->place($rocznik['dokument_id']);
?>

<?= $this->Element('dataobject/pageEnd') ?>