<?
$this->Combinator->add_libs('css', $this->Less->css('datafeed', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.datafeed');

$hits = $dataFeed['hits'];
$preset = $dataFeed['preset'];

?>

<div class="dataBrowser dataFeed<? if ($dataFeed['timeline']) echo ' feed-timeline'; ?>">
    <div class="modal modal-api-call">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-cog"></span> REST API</h4>
                </div>
                <div class="modal-body">
                    <p>Aby pobrać dane widoczne na tym ekranie, wyślij żądanie HTTP GET pod adres:</p>

                    <a class="modal-api-call-link" target="_blank"
                       href="<?= $dataFeed['api_call'] ?>"><?= htmlspecialchars($dataFeed['api_call']); ?></a>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>
    <div class="dataActions">
        <form action="" method="GET">
            <div class="form-group has-feedback searchBar">
                <? if (isset($this->request->query['channel'])) { ?>
                    <input type="hidden" name="channel" value="<?= $this->request->query['channel'] ?>"/>
                <? } ?>
                <input
                    placeholder="Szukaj<? if ($dataFeed['searchTitle']) echo ' w ' . htmlspecialchars($dataFeed['searchTitle']); ?>..."
                    type="text" aria-describedby="dataFeedSearch" id="dataFeedSearch" class="form-control"
                    name="q"<? if (isset($this->request->query['q'])) { ?> value="<?= $this->request->query['q'] ?>"<? } ?>>
                <span aria-hidden="true" class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
        </form>

        <?php if (isset($object_channels)) { ?>
            <div class="actionBar">
                <? foreach ($object_channels as $channel) {

                    $query = array();
                    if (isset($this->request->query['q']))
                        $query['q'] = $this->request->query['q'];

                    if (isset($channel['DatasetChannel']['channel']))
                        $query['channel'] = $channel['DatasetChannel']['channel'];

                    if (!isset($channel['DatasetChannel']['icon']))
                        $channel['DatasetChannel']['icon'] = 'all';

                    $href = $this->request->here;
                    if (!empty($query))
                        $href .= '?' . http_build_query($query);

                    $channel['active'] = isset($channel['active']) ? (boolean)$channel['active'] : false;

                    ?>
                    <div class="action col-md-2<? if ($channel['active']) { ?> active<? } ?>">
                        <a class="icon<?= ' ' . $channel['DatasetChannel']['icon'] ?>"
                           href="<?= $href ?>"><span></span>

                            <p><?= $channel['DatasetChannel']['title'] ?></p></a>
                    </div>
                <? } ?>
                <div class="action showMore col-md-2">
                    <a class="icon more"
                       href="#more"><span></span>

                        <p>Więcej</p></a>
                </div>
            </div>
        <? } ?>
        <div class="optionsBar">
            <div class="pull-left">
                <?
                if (
                    ($params = $this->Paginator->params()) &&
                    isset($params['count'])
                ) {

                    // $took = round($dataFeed['took'], 2);
                    $took = false;
                    ?>
                    <p class="total"><?= pl_dopelniacz($this->params['paging']['Dataobject']['count'], 'wynik', 'wyniki', 'wyników') ?><? if ($took) { ?> (<?= $took ?> s)<? } ?></p>
                <? } ?>
            </div>
            <div class="pull-right">
                <? /*
                <form class="actionIcons" action="<?= $dataFeed['subscribeAction'] ?>" method="post">
                    <button class="icon observe" type="submit"><span class="glyphicon glyphicon-star"></span> Obserwuj
                        te dane
                    </button>
                </form>

                <a class="actionIcons icon api" target="_blank" href="#" data-toggle="modal"
                   data-target=".modal-api-call"><span
                        class="glyphicon glyphicon-cog"></span>API
                </a>
                */ ?>
            </div>
        </div>
    </div>
    <div class="dataObjects">
        <div class="innerContainer update-objects">
            <?
            if (isset($hits)) {
                if (empty($hits)) {
                    // echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
                } else { ?>
                    <div class="dataFeed-ul list-group list-dataobjects">
                        <?
                        foreach ($hits as $object) {
                            echo $this->Element('Dane.feed_item', array('preset' => $preset, 'object' => $object));
                        } ?>
                    </div>
                <?
                }
            }
            ?>
        </div>
        <? if ($this->params['paging']['Dataobject']['nextPage']) { ?>
            <span class="next">
                <a rel="next"
                   href="<?= $this->request->here ?>.html?page=<?php echo $this->Paginator->param('page') + 1 ?>"></a>
            </span>
        <? } ?>
    </div>
</div>