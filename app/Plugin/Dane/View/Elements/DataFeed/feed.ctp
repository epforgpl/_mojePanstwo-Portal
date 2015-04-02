<?
$this->Combinator->add_libs('css', $this->Less->css('datafeed', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.datafeed');

$hits = $dataFeed['hits'];
$preset = $dataFeed['preset'];

?>

<div class="dataBrowser dataFeed<? if ($dataFeed['timeline']) echo ' feed-timeline'; ?>">
    <div class="dataActions">
        <div class="form-group has-feedback">
            <input type="text" aria-describedby="dataFeedSearch" id="dataFeedSearch" class="form-control">
            <span aria-hidden="true" class="glyphicon glyphicon-search form-control-feedback"></span>

        </div>
    </div>
    <div class="dataObjects">
        <div class="innerContainer update-objects">
            <?
            if (isset($hits)) {
                if (empty($hits)) {
                    // echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
                } else { ?>
                    <ul class="dataFeed-ul list-group list-dataobjects">
                        <?
                        foreach ($hits as $object) {
                            echo $this->Element('Dane.feed_item', array('preset' => $preset, 'object' => $object));
                        } ?>
                    </ul>
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