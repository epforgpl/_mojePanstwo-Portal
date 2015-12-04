<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-dzielnica', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Dane.view-gminy-dzielnica.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="col-sm-2 col-xs-12 dataAggsContainer">

    <? if(isset($_submenu) && isset($_submenu['items'])) {

        if (!isset($_submenu['base']))
            $_submenu['base'] = $dzielnica->getUrl();

        echo $this->Element('Dane.DataBrowser/browser-menu', array(
            'menu' => $_submenu
        ));

    } ?>

</div>
<div class="col-sm-10">
	
</div>
