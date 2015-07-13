<?php $this->Combinator->add_libs('css', $this->Less->css('datasets', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('js', 'Dane.datasets') ?>

<?php $this->Html->script(array('list.min'), array('block' => 'scriptBlock')); ?>

<div id="hacker-list">
    <div class="appHeader">
        <div class="container innerContent">
            <h1>Zbiory danych publicznych</h1>

            <div class="col-xs-12 col-sm-8 col-sm-offset-2">

                <form action="/ustawy" class="searchInput">
                    <div class="input-group main_input">
                        <input type="text" class="search form-control input-lg" placeholder="Szukaj zbioru..."
                               autocomplete="off" value="" name="q">
	                <span class="input-group-btn">
	                      <button data-icon="" type="submit" class="btn btn-success btn-lg"></button>
	                </span>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="appBody">
        <div class="container">

            <? if (!empty($datasets['datasets'])) { ?>
                <ul class="list datasets">
                    <?
                    foreach ($datasets['datasets'] as $dataset) {
                        $dataset = $dataset['Dataset'];
                        ?>

                        <li class="hacker-item col-md-4">
                            <a href="/dane/<?= $dataset['base_alias'] ?>">
                                <p class="title"><?= $dataset['name'] ?></p>

                                <p class="desc"><?= $dataset['opis'] ?></p>

                                <p class="hidden"><?= strrev($dataset['opis']) ?></p>
                            </a>
                        </li>
                    <? } ?>
                </ul>
            <? } ?>

        </div>
    </div>
</div>