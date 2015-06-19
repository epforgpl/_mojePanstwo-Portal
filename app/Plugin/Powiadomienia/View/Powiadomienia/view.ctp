<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('css', $this->Less->css('datafeed', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.datafeed');
$this->Combinator->add_libs('css', $this->Less->css('powiadomienia-base', array('plugin' => 'Powiadomienia')));
$this->Combinator->add_libs('css', $this->Less->css('powiadomienia-subs', array('plugin' => 'Powiadomienia')));
?>

<div class="container">
    <? if ($subs) { ?>
        <div class="row">
            <div class="col-sm-8">
                <div class="objectsPage">
                    <div class="dataBrowser dataFeed">
                        <h2>Twoje powiadomienia:</h2>
                        <? if ($this->params['paging']['Dataobject']['pageCount']) {
                            echo $this->element('Dane.DataFeed/feed');
                        } else { ?>
                            <div
                                class="informationBlock missing col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
                                <div class="col-xs-12 information">

                                    <h2>Nie masz nowych powiadomień</h2>

                                    <h3>Dane, które obserwujesz nie wygenerowały jeszcze powiadomień.</h3>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="subsPage data-subs">
                    <? echo $this->element('Powiadomienia.powiadomienia-dataobject-observe'); ?>
                    <div class="dataBrowser">
                        <h2>Obserwujesz:</h2>
                        <ul class="list-group list-subs">
                            <? foreach ($subs as $sub) {
                                $dataset = $sub->getDataset();
                                ?>
                                <li data-id="<?= $sub->getId() ?>" data-dataset="<?= $dataset; ?>">
                                    <i class="icon icon-datasets-<?= $dataset ?>"></i>

                                    <p class="title">
                                        <a href="<?= $sub->getUrl() ?>"><?= $sub->getTitle() ?></a>
                                    </p>
                                    <i class="options glyphicon glyphicon-option-vertical"></i>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <? } else { ?>
        <div class="informationBlock missing col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
            <div class="col-xs-12 information">
                <h2>Nie obserwujesz jeszcze żadnych danych</h2>
            </div>
        </div>
    <? } ?>
</div>