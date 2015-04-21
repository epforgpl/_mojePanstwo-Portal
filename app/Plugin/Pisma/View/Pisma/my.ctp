<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('pisma-moje', array('plugin' => 'Pisma'))) ?>

<?= $this->Element('appheader'); ?>

<div class="container">
    <div class="col-md-10 col-md-offset-1">
	
		<? if( !$this->Session->read('Auth.User.id') ) { ?>
		<div class="alert alert-dismissable alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<h4>Uwaga!</h4>
			<p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na swoim koncie.</p>
		</div>
		<? } ?>
		
        <p class="login-warning"></p>

        <div class="letters">

            <div class="toolbar">
                <? if ($search['pagination']['total']) { ?>
                <div class="form-group">
                    <form method="GET" action="/pisma/moje">
                        <input name="q" class="form-control input-lg" placeholder="Szukaj w moim pismach..." type="text"
                               value="<?= $q ?>">
                        <input type="submit" value="Szukaj" style="display: none;"/>
                    </form>
                </div>
                <div class="paginationList">
                    <? echo ($search['pagination']['page'] * $search['pagination']['perPage']) - ($search['pagination']['perPage'] - 1) ?>
                    <span
                        class="small">-</span> <?= $search['pagination']['total'] > ($search['pagination']['page'] * $search['pagination']['perPage']) ? ($search['pagination']['page'] * $search['pagination']['perPage']) : $search['pagination']['total'] ?>
                     <span class="small">z</span> <?= $search['pagination']['total'] ?>
                </div>
                <? } ?>
            </div>

            <? if ($search['pagination']['total']) { ?>
                <ul class="list-main">
                    <? foreach ($search['items'] as $item) { ?>
                        <li>

                            <div class="thumb">

                                <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><img
                                        src="http://pisma.sds.tiktalik.com/thumbs/<?= $item['hash'] ?>.png"/></a>

                            </div>
                            <div class="cont">

                                <p class="title">
                                    <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><?= ( isset($item['name']) && $item['name'] ) ? $item['name'] : 'Pismo' ?></a>
                                </p>
								
								<? if( isset($item['sent']) && $item['sent'] ) {?>
                                <p class="meta">
                                    Wysłano: <?= date('Y-m-d H:i:s', strtotime($item['sent_at'])) ?>
                                </p>
                                <? } ?>

                                <? if (isset($item['to_name'])) { ?>
                                <p class="fields">
                                    <small>Do:</small> <span class="val"><?= $item['to_name'] ?></span>
                                </p>
                                <? } ?>

                            </div>

                        </li>
                    <? } ?>
                </ul>
                <?php if (1 < $search['pagination']['total'] / $search['pagination']['perPage']) { ?>
                    <div class="paginationListNumber">
                        <div class="btn-group" role="group">
                            <?php for ($x = 0; $x < $search['pagination']['total'] / $search['pagination']['perPage']; $x++) { ?>
                                <a href="/pisma/moje?page=<?php echo $x + 1; ?>" type="button"
                                   class="btn btn-default<?php if (($x + 1) == $search['pagination']['page']) echo ' active' ?>"><?php echo $x + 1; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

            <? } else {
                if ($q) {
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