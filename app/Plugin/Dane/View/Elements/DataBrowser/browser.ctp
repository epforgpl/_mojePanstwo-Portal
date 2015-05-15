<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
?>
<div class="container dataBrowser">

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
                       href="<?= $dataBrowser['api_call'] ?>"><?= htmlspecialchars($dataBrowser['api_call']) ?></a>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <? if ($dataBrowser['mode'] == 'cover') { ?>
        <form action="" data-url="<?= $dataBrowser['cancel_url']; ?>" method="get"
              class="form-horizontal searchForm col-md-8">
            <? } else { ?>
            <form action="" data-url="<?= $dataBrowser['cancel_url']; ?>" method="get"
                  class="form-horizontal searchForm col-md-8">
                <? } ?>

                <? if (
                    !isset($title) &&
                    isset($DataBrowserTitle)
                ) {
                    $title = $DataBrowserTitle;
                } ?>

                <? if (isset($title)) { ?>
                    <h2><?= $title ?></h2>
                <? } ?>

                <? if (!isset($searcher) || $searcher) { ?>
                    <div class="form-group has-feedback">
                        <div class="col-md-12">
                            <?
                            $value = isset($this->request->query['q']) ? addslashes($this->request->query['q']) : '';
                            ?>

                            <div class="input-group">
                                <input <? if ($dataBrowser['autocompletion']) { ?>data-autocompletion="true"
                                       data-autocompletion-dataset="<?= $dataBrowser['autocompletion']['dataset'] ?>"
                                       <? } ?>class="form-control hasclear input-lg dataBrowserSearchInput"
                                       placeholder='<? if (isset($dataBrowser['searchTitle']) && ($dataBrowser['searchTitle'])) {
                                           echo addslashes($dataBrowser['searchTitle']);
                                       } else {
                                           echo "Szukaj...";
                                       } ?>' type="text" value="<?= $value ?>" name="q" required>
                                <? if (isset($dataBrowser['cancel_url'])) { ?><a
                                    href="<?= $dataBrowser['cancel_url']; ?>"><span
                                            class="clearer form-control-feedback" aria-hidden="true">&times;</span>
                                    </a><? } ?>
                                <span class="input-group-btn">
							<button class="btn btn-primary input-lg" type="submit"><span
                                    class="glyphicon glyphicon-search"></span></button>
						</span>
                            </div>


                        </div>
                    </div>
                <? } ?>

            </form>

    </div>

    <? if (
        ($params = $this->Paginator->params()) &&
        isset($params['count'])
    ) {
        $took = round($dataBrowser['took'], 2);
        ?>
        <div class="row">
            <div
                class="dataCounter col-md-8">
                <p class="pull-left"><?= pl_dopelniacz($params['count'], 'wynik', 'wyniki', 'wyników') ?><? if ($took) { ?> (<?= $took ?> s)<? } ?></p>

                <p class="pull-right"><a href="#" class="link-discrete link-api-call" data-toggle="modal"
                                         data-target=".modal-api-call"><span class="glyphicon glyphicon-cog"></span> API</a>
                </p></div>
        </div>
    <? } ?>

    <div class="row">

        <? if ($dataBrowser['mode'] == 'cover') { ?>

            <?= $this->element($dataBrowser['cover']['view']['plugin'] . '.' . $dataBrowser['cover']['view']['element']); ?>


        <? } else { ?>

            <div class="col-md-8">


                <div class="dataObjects">

                    <div class="innerContainer update-objects">

                        <?
                        if (isset($dataBrowser['hits'])) {
                            if (empty($dataBrowser['hits'])) {
                                echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
                            } else {
                                ?>
                                <ul class="list-group list-dataobjects">
                                    <?
                                    foreach ($dataBrowser['hits'] as $object) {

                                        echo $this->Dataobject->render($object, $dataBrowser['renderFile'], array(
                                            // 'hlFields' => $dataBrowser->hlFields,
                                            // 'hlFieldsPush' => $dataBrowser->hlFieldsPush,
                                            // 'routes' => $dataBrowser->routes,
                                            // 'forceLabel' => in_array($page['mode'], array('*', 'datachannel')),
                                            // 'defaults' => $defaults,
                                        ));
                                    }
                                    ?>
                                </ul>
                            <?
                            }
                        }
                        ?>

                    </div>

                </div>

                <div class="dataPagination">
                    <ul class="pagination">
                        <?php

                        //$this->MPaginator->options['url'] = array('alias' => 'prawo');
                        //$this->MPaginator->options['paramType'] = 'querystring';

                        //echo $this->MPaginator->first('&larr;', array('tag' => 'li', 'escape' => false), '<a href="#">&larr;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));


                        // echo $this->MPaginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                        echo $this->MPaginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
                        // echo $this->MPaginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                        //echo $this->MPaginator->last('&rarr;', array('tag' => 'li', 'escape' => false), '<a href="#">&rarr;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                        ?>
                    </ul>
                </div>

            </div>
            <? if (!empty($dataBrowser['aggs'])) { ?>
                <div class="col-md-4">
                    <? echo $this->Element('Dane.DataBrowser/aggs', array('data' => $dataBrowser)); ?>
                </div>
            <? } ?>

        <? } ?>

    </div>

</div>