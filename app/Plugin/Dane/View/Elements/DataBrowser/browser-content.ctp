<?

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->replace_lib_or_add('js', '../plugins/highcharts/js/highcharts', '../plugins/highstock/js/highstock');
$this->Combinator->replace_lib_or_add('js', '../plugins/highcharts/locals', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Dane.DataAggsDropdown.js');

?>

<div class="modal modal-api-call">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-cog"></span> REST API</h4>
            </div>
            <div class="modal-body">

                <? if( isset($dataBrowser['api_call']) ) {?>

                    <p>Aby pobrać dane widoczne na tym ekranie, wyślij żądanie HTTP GET pod adres:</p>

                    <a class="modal-api-call-link" target="_blank"
                       href="<?= $dataBrowser['api_call'] ?>"><?= htmlspecialchars($dataBrowser['api_call']) ?></a>

                <? } ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>

<?
if ($dataBrowser['mode'] == 'cover') { ?>

    <?= $this->element($dataBrowser['cover']['view']['plugin'] . '.' . $dataBrowser['cover']['view']['element']); ?>


    <?

} else {

    $params = $this->Paginator->params();

    ?>

    <? if ($displayAggs && !empty($dataBrowser['aggs'])) { ?>

        <div class="col-md-<?= $columns[1] ?> col-xs-12 dataAggsContainer">

            <? if( isset($sideElement) ) echo $this->Element($sideElement) ?>



            <? if(isset($menu) && isset($menu['items'])) {

                echo $this->Element('Dane.DataBrowser/browser-menu', array(
                    'menu' => $menu,
                ));

            } else {

                echo $this->Element('Dane.DataBrowser/aggs', array(
                    'data' => $dataBrowser,
                ));

            } ?>

        </div>
    <? } ?>
    <div class="col-xs-12 col-md-<?= $displayAggs ? $columns[0] : 12 ?>">

        <div class="dataWrap">

            <?= $this->element('Dane.DataBrowser/browser-content-filters') ?>

            <? /*
            <?= $this->element('Dane.DataBrowser/browser-content-paging', array(
            	'params' => $params,
            )) ?>
            */ ?>

            <div class="dataObjects margin-top-10">

                <div class="innerContainer update-objects">

                    <?
                    if (isset($dataBrowser['hits'])) {
                        if (empty($dataBrowser['hits'])) {
                            echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
                        } else {
                            ?>
                            <ul class="list-group list-dataobjects">
                                <?

                                $params = array();
                                if( isset($truncate) )
                                    $params['truncate'] = $truncate;

                                foreach ($dataBrowser['hits'] as $object) {

                                    echo $this->Dataobject->render($object, $dataBrowser['renderFile'], $params);
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

    </div>


<? } ?>
