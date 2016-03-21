<?

$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('sejm-wyjatki', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $posiedzenie,
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $posiedzenie->getUrl();
?>


<div class="row">
	<div class="col-md-2">
		<div class="dataBrowser">
		<?
			echo $this->Element('Dane.DataBrowser/browser-menu', array(
                'menu' => $_submenu,
                'pills' => isset($pills) ? $pills : null
            ));
        ?>
		</div>
	</div>
	<div class="col-md-10 nocontainer">
<?
	echo $this->Element('Dane.DataBrowser/browser', array(
	    'menu' => $_submenu,
	    'class' => 'margin-top-0',
	));	
?>
	</div>
</div>





<?
echo $this->Element('dataobject/pageEnd');