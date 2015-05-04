<?
	$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));	$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');	
	$this->Combinator->add_libs('css', $this->Less->css('datafeed', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'Dane.datafeed');
	$this->Combinator->add_libs('css', $this->Less->css('powiadomienia-base', array('plugin' => 'MojeDane')));
	$this->Combinator->add_libs('css', $this->Less->css('powiadomienia-subs', array('plugin' => 'MojeDane')));
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
	if( $subs ) {
?>

<div class="container">
	<div class="row">
		<div class="col-sm-8">
			
			<div class="objectsPage">
			
				<div class="dataBrowser dataFeed">
				
					<h2>Powiadomienia:</h2>
					
					<?
						if( $this->params['paging']['Dataobject']['pageCount'] ) { 
							echo $this->element('Dane.DataFeed/feed');
						} else { 
					?>
					
					<div class="informationBlock missing col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
				        <div class="col-xs-12 information">
				
				            <h2>Nie masz nowych powiadomień</h2>
				
				            <h3>Dane, które obserwujesz nie wygenerowały jeszcze powiadomień.</h3>
				        </div>
				    </div>
					
					<? } ?>
				
				</div>
			
			</div>
			
		</div><div class="col-sm-4">
	
			<div class="subsPage data-subs">
				
				<div class="dataBrowser">
					
					<h2>Obserwujesz:</h2>
					
					<ul class="list-group list-subs">
			            <? foreach ($subs as $sub) { ?>									
			            <li>
			            	
			            	<p class="title"><a href="<?= $sub->getUrl() ?>"><?= $sub->getTitle() ?></a></p>
			            	<ul class="subscriptions_list">
							<? foreach($sub->inner_hits as $hit) {?>
								<li><a href="/dane/subscriptions/<?= $hit['id'] ?>"><span class="glyphicon glyphicon-star"></span> <?= $hit['title'] ?></a></li>
							<? } ?>
						    </ul>
			            	
			            </li>    
			            <? } ?>
			        </ul>
				
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