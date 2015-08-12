<?

	$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

?>

<? if (($params = $this->Paginator->params()) && isset($params['count'])) {
    $took = round($dataBrowser['took'], 2);
    ?>
	<div class="row">
		<div class="col-md-12">
		    <div class="dataCounter">
		        <? if($params['count']) {?><p class="pull-left"><?= pl_dopelniacz($params['count'], 'wynik', 'wyniki', 'wyników') ?><? if ($took) { ?> (<?= $took ?> s)<? } ?></p><? } ?>
		
		        <p class="pull-right">
		            <a href="#" class="link-discrete link-api-call" data-toggle="modal" data-target=".modal-api-call"><span
		                    class="glyphicon glyphicon-cog"></span> API</a>
		        </p>
		    </div>
		</div>
	</div>
<? } ?>

<div class="row">

    <? if ($dataBrowser['mode'] == 'cover') { ?>

        <?= $this->element($dataBrowser['cover']['view']['plugin'] . '.' . $dataBrowser['cover']['view']['element']); ?>


    <? } else { ?>

        <div class="col-md-<?= $displayAggs ? $columns[0] : 12 ?>">


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
        <? if ($displayAggs && !empty($dataBrowser['aggs'])) { ?>
            <div class="col-md-<?= $columns[1] ?>">
                <? if( isset($sideElement) ) echo $this->Element($sideElement) ?>
                <? echo $this->Element('Dane.DataBrowser/aggs', array('data' => $dataBrowser)); ?>
            </div>
        <? } ?>

    <? } ?>

</div>