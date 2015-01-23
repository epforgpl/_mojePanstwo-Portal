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

        <p class="login-warning">Nie jesteś zalogowany. Twoje pisma będą przechowywane przez 24 godziny. <a>Zaloguj
                się</a>, aby trwale przechowywać pisma.</p>

        <div class="letters">

            <div class="toolbar">
                <div class="form-group">
                    <form method="GET" action="/pisma/moje">
                        <input name="q" class="form-control" placeholder="Szukaj w moim pismach..." type="text"
                               value="<?= $q ?>">
                        <input type="submit" value="Szukaj" style="display: none;"/>
                    </form>
                </div>
            </div>

            <? if ($search['pagination']['total']) { ?>
                <div class="paginationList">
                    <span
                        class="small">( </span><? echo ($search['pagination']['page'] * $search['pagination']['perPage']) - ($search['pagination']['perPage'] - 1) ?>
                    <span
                        class="small">-</span> <?= $search['pagination']['total'] > ($search['pagination']['page'] * $search['pagination']['perPage']) ? ($search['pagination']['page'] * $search['pagination']['perPage']) : $search['pagination']['total'] ?>
                    <span class="small">)</span> <span class="small">z</span> <?= $search['pagination']['total'] ?>
                </div>
                <ul class="list-main">
                    <? foreach ($search['items'] as $item) { ?>
                        <li>

                            <div class="thumb">

                                <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><img
                                        src="http://docs.sejmometr.pl/thumb/1/1127228.png"/></a>

                            </div>
                            <div class="cont">

                                <p class="title">
                                    <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><?= $item['name'] ?></a>
                                </p>

                                <p class="meta">
                                    Modyfikacja: <?= date('Y-m-d H:i:s', strtotime($item['modified_at'])) ?>
                                </p>

                                <? if (isset($item['to_name'])) { ?>
                                <p>
                                    <small>Do:</small> <?= $item['to_name'] ?>
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