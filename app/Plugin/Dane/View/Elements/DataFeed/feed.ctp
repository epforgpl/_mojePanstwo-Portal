<?
$this->Combinator->add_libs('css', $this->Less->css('datafeed', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.datafeed');

$hits = $dataFeed['hits'];
$preset = $dataFeed['preset'];

?>

<div class="dataBrowser dataFeed<? if ($dataFeed['timeline']) echo ' feed-timeline'; ?>">
    <div class="dataActions hide">
        <form action="" method="GET">
            <div class="form-group has-feedback searchBar">
                <input type="text" aria-describedby="dataFeedSearch" id="dataFeedSearch" class="form-control" name="q">
                <span aria-hidden="true" class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
        </form>
        <?php if (isset($dataFeedFilters)) { ?>
            <div class="actionBar">
                <? foreach ($dataFeedFilters as $action) { ?>
                    <div class="action col-md-2">
                        <a class="icon<?= ' ' . $action['icon'] ?>"
                           href="<?= $action['link'] ?>"><span></span>

                            <p><?= $action['title'] ?></p></a>
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
                <p class="total"><?= pl_dopelniacz($this->params['paging']['Dataobject']['count'], 'wynik', 'wyniki', 'wyników') ?></p>
            </div>
            <div class="pull-right">
                <a class="actionIcons icon api" target="_blank" href="<?= $dataFeed['api_call'] ?>"><span
                        class="glyphicon glyphicon-cog"></span>API</a>

                <form class="actionIcons" action="<?= $dataFeed['subscribeAction'] ?>" method="post">
                    <button class="icon observe" type="submit">Obserwuj poniższy feed</button>
                </form>
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