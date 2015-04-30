<?
	$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	$this->Combinator->add_libs('css', $this->Less->css('powiadomienia-base', array('plugin' => 'Powiadomienia')));
	$this->Combinator->add_libs('css', $this->Less->css('powiadomienia-subs', array('plugin' => 'Powiadomienia')));
?>

<?= $this->Element('appheader'); ?>

<? if( !$this->Session->read('Auth.User.id') ) { ?>
<div class="container">
	<div class="alert alerts-login alert-dismissable alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<h4>Uwaga!</h4>
		<p>Nie jesteś zalogowany. Twoje subskrypcje będą przetwarzane i przechowywane na tym urządzeniu przez 24 godziny. <a class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale zapisać subskrypcje na swoim koncie.</p>
	</div>
</div>
<? } ?>


<? 
	if( $dataBrowser['hits'] ) {
?>

<div class="container">
	<div class="row">
		<div class="col-sm-8">
			
		</div><div class="col-sm-4">
	
	<div class="objectsPage data-subs">
		
		<div class="dataBrowser">
		
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
		
		</div>
		
	</div>
	<? } else { ?>
	
	<div class="container">
		<div class="informationBlock missing col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
	        <div class="col-xs-12 information">
	
	            <h2>Nie obserwujesz jeszcze żadnych danych</h2>
	
	            <h3>Dowiedz się jak skonfigurować subskrypcje i otrzymywać powiadomienia o interesujących Cię danych.</h3>
	            <a target="_self" href="/powiadomienia/jak_to_dziala" class="btn btn-info">Jak to działa?</a>
	        </div>
	    </div>
	</div>
	
	<? } ?>
	
		</div>
	</div>
</div>