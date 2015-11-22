<?

echo $this->Element('dataobject/pageBegin');
$params = array();

?>

    <div class="row">
        <div class="col-sm-10">
            <? echo $this->Element('Dane.DataBrowser/browser', $params); ?>
        </div>
        <div class="col-sm-2">

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');