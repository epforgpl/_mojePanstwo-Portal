<?

$path = APP . 'Plugin' . DS . 'Dane' . DS . 'View' . DS . 'Elements' . DS . 'sides' . DS . $dataFeed['side'] . '-left.ctp';
$side_left = file_exists($path);

$path = APP . 'Plugin' . DS . 'Dane' . DS . 'View' . DS . 'Elements' . DS . 'sides' . DS . $dataFeed['side'] . '-right.ctp';
$side_right = file_exists($path);

$mainPage = !isset($this->request->query['channel']) || !$this->request->query['channel'];

?>
<div class="row row-feed dataBrowser dataFeed">
    <? if ($side_left) { ?>
        <div class="col-xs-12 col-sm-4 objectSide col-feed-side col-feed-side-left">
            <? echo $this->Element('Dane.sides/' . $dataFeed['side'] . '-left'); ?>
        </div>
    <? } ?>
    <div class="col-xs-12 col-sm-8 col-feed-main">
        <div class="object">
            <? echo $this->Element('Dane.DataFeed/feed'); ?>
        </div>
    </div>
    <? if ($side_right) { ?>
        <div class="col-xs-12 col-sm-4">
            <? echo $this->Element('Dane.sides/' . $dataFeed['side'] . '-right'); ?>
        </div>
    <? } ?>
</div>
