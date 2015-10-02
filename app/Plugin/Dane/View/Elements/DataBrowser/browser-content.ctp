<?

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Html->css(array('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Html->script(array('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', '../plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pl.min'), array('inline' => 'false', 'block' => 'scriptBlock'));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
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
if ($dataBrowser['mode'] == 'cover') {

    echo $this->element($dataBrowser['cover']['view']['plugin'] . '.' . $dataBrowser['cover']['view']['element']);

} else {

    $params = $this->Paginator->params();

	$displayAggs = $displayAggs &&
	(
		!empty($sideElement) ||
		!empty($app_chapters) ||
		!empty($menu)
	);

	$dataWrap = false;

    ?>

    <?
	if (($displayAggs && !empty($dataBrowser['aggs'])) || (isset($app_chapters) && $app_chapters) ) {
	    $dataWrap = true;
    ?>


        <div class="col-md-<?= $columns[1] ?> col-xs-12 dataAggsContainer">

            <? if( isset($sideElement) ) echo $this->Element($sideElement) ?>

            <?  if( isset($app_chapters) ) {

	            echo $this->Element('Dane.DataBrowser/app_chapters');

	        } elseif(isset($menu) && isset($menu['items'])) {

                echo $this->Element('Dane.DataBrowser/browser-menu', array(
                    'menu' => $menu,
                    'pills' => isset($pills) ? $pills : null
                ));

            } ?>

        </div>
    <? } ?>

    <div class="col-xs-12 col-sm-<?= isset($forceHideAggs) ? 12 : ($displayAggs ? $columns[0] : 9) ?>">

        <div class="<? if($dataWrap) {?>dataWrap <? } ?>margin-top-10">

			<?
	            if( isset($dataBrowser['beforeBrowserElement']) )
		            echo $this->element($dataBrowser['beforeBrowserElement']);
		    ?>

            <?= $this->element('Dane.DataBrowser/browser-content-filters', array(
            	'paging' => $params,
            	'paginatorPhrases' => isset($paginatorPhrases) ? $paginatorPhrases : false,
            )) ?>

            <div class="dataObjects">

                <div class="innerContainer update-objects">

                    <?
                    if (isset($dataBrowser['hits'])) {
                        if (empty($dataBrowser['hits'])) {
                            echo '<p class="noResults">' . __d('dane', isset($noResultsPhrase) ? $noResultsPhrase : 'LC_DANE_BRAK_WYNIKOW') . '</p>';
                        } else {
                            ?>
                            <ul class="list-group list-dataobjects">
                                <?

                                $params = array();
                                if( isset($truncate) )
                                    $params['truncate'] = $truncate;

                                foreach ($dataBrowser['hits'] as $object) {

									if( isset($beforeItemElement) )
										echo $this->element($beforeItemElement, array(
                                            'object' => $object
                                        ));

                                    echo $this->Dataobject->render($object, $dataBrowser['renderFile'], $params);

                                    if( isset($afterItemElement) )
										echo $this->element($afterItemElement);
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

                    $this->MPaginator->options['url'] = array('alias' => 'prawo');
                    $this->MPaginator->options['paramType'] = 'querystring';

                    echo $this->MPaginator->first('&larr;', array('tag' => 'li', 'escape' => false), '<a href="#">&larr;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));


                     echo $this->MPaginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                    echo $this->MPaginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
                     echo $this->MPaginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                    echo $this->MPaginator->last('&rarr;', array('tag' => 'li', 'escape' => false), '<a href="#">&rarr;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                    ?>
                </ul>
            </div>

            <?
	            if( isset($dataBrowser['afterBrowserElement']) )
		            echo $this->element($dataBrowser['afterBrowserElement']);
		    ?>

        </div>

    </div>


<? } ?>
