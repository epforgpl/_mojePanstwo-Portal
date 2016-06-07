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

$_manage = isset( $manage ) ? $manage: false;
?>

<div class="dataBrowser upper margin-top-0<? if (isset($class)) echo " " . $class; ?>">
    <div class="container container-padding">
        <div class="dataBrowserContent">
			
			<?= $this->element('Dane.DataBrowser/browser-content-modal'); ?>
						
			<?
			if ($dataBrowser['mode'] == 'cover') {
				
			    echo $this->element($dataBrowser['cover']['view']['plugin'] . '.' . $dataBrowser['cover']['view']['element']);
			
			} else {
						
			    $displayAggs = $displayAggs &&
			        (
			            !empty($sideElement) ||
			            !empty($app_chapters) ||
			            !empty($menu)
			        );
			
			    $dataWrap = false;
			    			    
			    echo $this->element('Dane.DataBrowser/browser-content-header', array(
				    'dataWrap' => $dataWrap,
				    'params' => $this->Paginator->params(),
				    'datasetsFilter' => isset( $datasetsFilter ) ? $datasetsFilter : false,
			    ));
			
			}
			?>
			    
		</div>
	</div>
	
	<?
	
	if( $dataBrowser['mode'] == 'cover' ) {
		
		echo @$this->element($dataBrowser['cover']['view']['plugin'] . '.' . $dataBrowser['cover']['view']['element'] . '-post', array(
		    'params' => $this->Paginator->params(),
		    'manage' => $_manage,
	    ));
		
	} else {
		
		echo $this->element('Dane.DataBrowser/browser-content-list', array(
		    'dataWrap' => $dataWrap,
		    'params' => $this->Paginator->params(),
		    'manage' => $_manage,
	    ));
		echo $this->element('Dane.DataBrowser/browser-content-pagination', array(
		    'dataWrap' => $dataWrap,
		    'params' => $this->Paginator->params(),
	    ));
	
	}
	?>
	
</div>
