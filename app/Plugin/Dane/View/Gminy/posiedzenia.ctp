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
        ?>
    </div>

    <h1 class="subheader">Rada Miasta Kraków</h1>
<?
if (!isset($_submenu['base']))
    $_submenu['base'] = $object->getUrl();

echo $this->Element('Dane.DataBrowser/browser', array(
    'menu' => $_submenu,
));
echo $this->Element('dataobject/pageEnd');
