<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin');
?>
<h1 class="subheader">Organizacje w Krakowie</h1>
	
<? if (isset($_submenu) && !empty($_submenu)) { ?>
    <div class="menuTabsCont">
        <div class="container">
            <?
            if( !isset($_submenu['base']) )
                $_submenu['base'] = $object->getUrl();
            echo $this->Element('Dane.dataobject/menuTabs', array(
                'menu' => $_submenu,
            ));
            ?>
        </div>
    </div>
<? } 
		
echo $this->Element('Dane.DataBrowser/browser');
echo $this->Element('dataobject/pageEnd');
