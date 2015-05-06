<?php $this->Combinator->add_libs('css', $this->Less->css('krs', array('plugin' => 'Krs'))) ?>
<?php $this->Combinator->add_libs('js', 'Krs.krs.js') ?>

<div id="krs">
    <?= $this->Element('appheader', array('title' => 'Krajowy Rejestr Sądowy', 'subtitle' => __d('krs', 'LC_KRS_HEADLINE'), 'headerUrl' => 'krs.png')); ?>

    <div class="container">
	    
	    <div style="margin-top: 30px;">
			<form class="form-inline" action="#" method="get">
				<div class="input-group col-sm-8">
					<input class="form-control input-lg" value="" placeholder="Szukaj..." name="q" type="text">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default dropdown-toggle input-lg" data-toggle="dropdown">Organizacje i osoby <span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="#">Organizacje</a></li>
								<li><a href="#">Osoby</a></li>
								<li><a href="#">Organizacje lub osoby</a></li>
							</ul>
					</div><!-- /btn-group -->
				</div>
			</form>
	    </div>
	    
    </div>
    
</div>