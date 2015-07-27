<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $komunikat,
    'objectOptions' => array(
        'truncate' => 1000,
        'mode' => 'subobject',
    ),
));
?>
<div class="container">
    <?
    if(isset($tresc))
        echo $tresc;
    if($komunikat->data['img']){?>
        <img class="pull-right" src="/sejm_komunikaty/img/<?= $komunikat->data['id'] ?>.jpg'">
    <?}
    ?>
</div>

<?
echo $this->Element('dataobject/pageEnd');