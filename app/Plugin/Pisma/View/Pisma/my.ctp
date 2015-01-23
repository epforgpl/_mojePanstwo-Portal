<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('pisma-moje', array('plugin' => 'Pisma'))) ?>

<div class="appHeader">
    <div class="container innerContent">
        <div class="col-xs-12">
            <? echo $this->Element('Pisma.menu', array(
                'selected' => 'moje'
            )); ?>
        </div>
    </div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	    
	    <p class="login-warning">Nie jesteś zalogowany. Twoje pisma będą przechowywane przez 24 godziny. <a>Zaloguj się</a>, aby trwale przechowywać pisma.</p>
	    
	    <div class="letters">
	    		    	
		    <div class="toolbar">
			    <div class="form-group">
					<form method="GET" action="/pisma/moje">
						<input name="q" class="form-control" placeholder="Szukaj w moim pismach..." type="text" value="<?= $q ?>">
						<input type="submit" value="Szukaj" style="display: none;" />
					</form>
				</div>
		    </div>
		    
		    <? debug($search['pagination']); ?>
		    
		    <? if( $search['pagination']['total'] ) { ?>
		    
			    <ul class="list-main">
			        <? foreach ($search['items'] as $item) { ?>
			            <li>
			                
			                <div class="thumb">
				                
				                <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><img src="http://docs.sejmometr.pl/thumb/1/1127228.png" /></a>
				                
			                </div><div class="cont">
			                		                
				                <p class="title">
					                <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><?= $item['name'] ?></a>
				                </p>
				                
				                <p class="meta">
					                Modyfikacja: <?= date('Y-m-d H:i:s', strtotime($item['modified_at'])) ?>
				                </p>
								
								<? if( isset($item['to_name']) ) {?>
								<p><small>Do:</small> <?= $item['to_name'] ?>
								<? } ?>
								
			                </div>
			                
			            </li>
			        <? } ?>
			    </ul>
		    
		    <? } else {
			    if( $q ) {
			?>
				<p class="letters-msg">Brak pism</p>
			<?	    
			    } else {
			?>
				<p class="letters-msg">Nie stworzyłeś jeszcze żadnych pism</p>
			<?	    
			    }
		    } ?>
	    
	    </div>
	</div>
</div>