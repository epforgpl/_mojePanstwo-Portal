<?

$path = APP . 'Plugin' . DS . 'Dane' . DS . 'View' . DS . 'Elements' . DS . 'sides' . DS . $dataFeed['side'] . '-left.ctp';
$side_left = file_exists($path);

$path = APP . 'Plugin' . DS . 'Dane' . DS . 'View' . DS . 'Elements' . DS . 'sides' . DS . $dataFeed['side'] . '-right.ctp';
$side_right = file_exists($path);

$mainPage = !isset($this->request->query['channel']) || !$this->request->query['channel'];

?>
<div class="row row-feed dataBrowser dataFeed">
    <? if ($side_left) { ?>
        <div class="col-xs-12 col-sm-3 objectSide col-feed-side col-feed-side-left">
            <? echo $this->Element('Dane.sides/' . $dataFeed['side'] . '-left'); ?>
        </div>
    <? } ?>
    <div class="col-xs-12 col-sm-7 col-feed-main">
        <div class="object">
            <? echo $this->Element('Dane.DataFeed/feed'); ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-2 col-feed-side col-feed-side-right topmargin">

        <? if (isset($object_subscriptions) && $object_subscriptions) { ?>
            <div class="subscription">
                <h2><span class="glyphicon glyphicon-star"></span> Obserwujesz</h2>
                <ul>
                    <? foreach ($object_subscriptions as $sub) { ?>
                        <li<? if (isset($this->request->query['subscription']) && ($this->request->query['subscription'] == $sub['id'])) {
                            echo ' class="active"';
                        } ?>>
                        <a class="pull-left" href="<?= $sub['url'] ?>"><?= $sub['title'] ?></a>

                        <div class="cancel-subscription pull-right">
                        	<form action="/dane/subscriptions/<?= $sub['id'] ?>/delete.json" method="post">
                            	<button class="glyphicon glyphicon-remove" title="Usuń tę subskrypcję"></button>
                        	</form>
                        </div>
                    </li>
                <? } ?>
                </ul>
                <? if (!$this->Session->read('Auth.User.id')) { ?>
                    <div class="alert alert-dismissable alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <h4>Uwaga!</h4>

                        <p>Nie jesteś zalogowany. Twoje subskrypcje będą przetwarzane i przechowywane na tym urządzeniu
                            przez 24 godziny. <a class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby
                            trwale zapisać subskrypcje na swoim koncie.</p>
                    </div>
                <? } ?>
            </div>


        <? } ?>

        <? // echo $this->Element('Dane.DataBrowser/aggs', array('data' => $dataFeed)); ?>

        <?
        if ($side_right)
            echo $this->Element('Dane.sides/' . $dataFeed['side'] . '-right');
        ?>

    </div>
</div>