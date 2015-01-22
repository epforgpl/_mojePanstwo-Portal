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
	    
	    <div class="letters">
	    
		    <div class="toolbar">
			    <div class="form-group">
					<input class="form-control" placeholder="Szukaj w moim pismach..." type="text">
				</div>
		    </div>
		    
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
		                
		                </div>
		                
		            </li>
		        <? } ?>
		    </ul>
	    
	    </div>
	</div>
</div>