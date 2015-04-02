<?
echo $this->Element('dataobject/pageBegin');
?>

    <div class="poslowie row">
        <div class="col-md-3 objectSide">

            

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