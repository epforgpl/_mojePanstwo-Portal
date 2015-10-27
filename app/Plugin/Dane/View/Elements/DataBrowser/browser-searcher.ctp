<div class="suggesterBlock searchForm">
    <? if (!isset($title) && isset($DataBrowserTitle)) {
        $title = $DataBrowserTitle;
    }
    if (isset($title)) {
        echo '<h2>' . $title . '</h2>';
    }

    $_searcher = isset($dataBrowser['searcher']) ? $dataBrowser['searcher'] : true;
    if (isset($searcher))
        $_searcher = $_searcher && $searcher;

    if ($_searcher) {

        $value = isset($this->request->query['q']) ? addslashes($this->request->query['q']) : '';
        $autocompletion = (@$dataBrowser['autocompletion']) ? $dataBrowser['autocompletion'] : false;
        $placeholder = (isset($dataBrowser['searchTitle']) && ($dataBrowser['searchTitle'])) ? addslashes($dataBrowser['searchTitle']) : 'Szukaj...';
        $url = (@$dataBrowser['cancel_url']) ? $dataBrowser['cancel_url'] : '';
        ?>

        <?= $this->Element('searcher', array(
	        'q' => $value, 
	        'autocompletion' => $autocompletion, 
	        'placeholder' => $placeholder, 
	        'url' => $url, 
	        'searchTag' => isset($dataBrowser['searchTag']) ? $dataBrowser['searchTag'] : false,
	        'dataBrowser' => isset($dataBrowser) ? $dataBrowser : false,
        )) ?>

    <? } ?>
</div>
