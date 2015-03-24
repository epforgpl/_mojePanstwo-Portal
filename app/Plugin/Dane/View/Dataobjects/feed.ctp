<?
// $this->Combinator->add_libs('css', $this->Less->css('view-prawo', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>

    <div class="prawo row">
        <div class="col-md-3 objectSide">
			
			<? echo $this->Element('Dane.sides/' . $this->request->params['controller']); ?>

        </div>
        <div class="col-md-7 nopadding">
            <div class="object">
                
                <? echo $this->Element('Dane.DataFeed/feed'); ?>
                
            </div>
        </div>
        <div class="col-md-2">

        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>