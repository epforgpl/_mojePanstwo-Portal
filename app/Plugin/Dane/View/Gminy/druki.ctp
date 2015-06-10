<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin');
?>
    <div class="suggesterBlock searchForm col-md-12 nopadding">
        <? if (!isset($title) && isset($DataBrowserTitle)) {
            $title = $DataBrowserTitle;
        }
        if (isset($title)) {
            echo '<h2>' . $title . '</h2>';
        }

        if (!isset($searcher) || $searcher) { ?>
            <?
            $value = isset($this->request->query['q']) ? addslashes($this->request->query['q']) : '';
            $dataset = ($dataBrowser['autocompletion']) ? $dataBrowser['autocompletion']['dataset'] : false;
            $placeholder = (isset($dataBrowser['searchTitle']) && ($dataBrowser['searchTitle'])) ? addslashes($dataBrowser['searchTitle']) : 'Szukaj...';
            $url = ($dataBrowser['cancel_url']) ? $dataBrowser['cancel_url'] : '';
            ?>

            <?= $this->Element('searcher', array('q' => $value, 'dataset' => $dataset, 'placeholder' => $placeholder, 'url' => $url)) ?>


        <? } ?>
    </div>

<h1 class="subheader">Rada Miasta Kraków</h1>

<? if (isset($_submenu) && !empty($_submenu)) { ?>
    <div class="menuTabsCont col-md-8">
            <?
            if( !isset($_submenu['base']) )
                $_submenu['base'] = $object->getUrl();
            echo $this->Element('Dane.dataobject/menuTabs', array(
                'menu' => $_submenu,
            ));
            ?>
    </div>
<? }

echo $this->Element('Dane.DataBrowser/browser');
echo $this->Element('dataobject/pageEnd');
