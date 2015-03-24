<?
	// $this->Combinator->add_libs('css', $this->Less->css('feed', array('plugin' => 'Dane')));

	$hits = $dataFeed['hits'];
	$preset = $dataFeed['preset'];
?>

<div class="dataBrowser dataFeed">
    <div class="dataObjects">
        <div class="innerContainer update-objects">

            <?
            if (isset($hits)) {
                if (empty($hits)) {
                    // echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
                } else {
                    ?>
                    <ul class="dataFeed-ul list-group list-dataobjects">
                    <?
                        foreach ($hits as $object) {
														
						    $theme = 'feed/' . $preset . '/' . $object->getDataset();
						
						    echo $this->Dataobject->render($object, 'feed', array(
						        'forceLabel' => false,
						        'file' => 'feed/' . $preset . '/' . $object->getDataset(),
						    ));
						
						}
                    ?>  
                    </ul>

                    <? /* if ($pagination['total'] > $perPage) { ?>

                        <div data-nextPage="2" data-perPage="<?= $perPage ?>" data-direction="<?= $direction ?>"
                             class="loadMoreContent">

                            <div class="button">
                                <button class="btn btn-sm btn-default">
                                    <span class="glyphicon glyphicon-chevron-down"></span> Załaduj więcej
                                </button>
                            </div>

                            <div class="spinner" style="display: none;">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>

                    <? } */ ?>

                <?
                }
            }
            ?>

        </div>
    </div>
</div>