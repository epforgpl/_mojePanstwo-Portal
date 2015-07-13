<?
// $this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));
// $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
// $this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
// $this->Combinator->add_libs('js', 'Dane.view-poslowie.js');

echo $this->Element('dataobject/pageBegin');
?>

    <div class="poslowie row">
        <div class="col-md-3 objectSide">
        </div>
        <div class="col-md-7 nopadding">
            <div class="object">
                <?= $this->dataobject->feed($feed); ?>
            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>