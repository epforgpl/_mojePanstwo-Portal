<?
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('css', $this->Less->css('datafeed', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.datafeed');

$hits = $dataFeed['hits'];
$preset = isset($dataFeed['preset']) ? $dataFeed['preset'] : false;
$timeline = isset($dataFeed['timeline']) ? $dataFeed['timeline'] : false;
$timeline = true;

$show = true;
if (isset($dataFeed['aggs']) && isset($dataFeed['aggs']['_channels']) && !$dataFeed['aggs']['_channels']['feed_data']['feed']['doc_count'])
    $show = false;


if ($show) {
    ?>

    <div class="<? if ($timeline) echo 'feed-timeline'; ?>">
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

        <div class="dataObjects">
            <div class="innerContainer update-objects">
                <?
                if (isset($hits) && !empty($hits)) { ?>
                    <div class="dataFeed-ul list-group list-dataobjects">
                        <?
                        foreach ($hits as $object) {
                            echo $this->Element('Dane.feed_item', array('preset' => $preset, 'object' => $object));
                        } ?>
                    </div>
                <? } ?>
            </div>
            <? if ($this->params['paging']['Dataobject']['nextPage']) { ?>
                <span class="next">
                <a rel="next"
                   href="<? $url = $this->request->here . '.html?page=' . ($this->Paginator->param('page') + 1);
                   $query = $this->request->query;
                   if (isset($query) && !empty($query)) {
                       if (isset($query['conditions']) && isset($query['conditions']['q'])) unset($query['conditions']['q']);
                       $url .= '&' . http_build_query($query);
                   }
                   echo $url; ?>"></a>
            </span>
            <? } ?>
        </div>
    </div>
<? } ?>
