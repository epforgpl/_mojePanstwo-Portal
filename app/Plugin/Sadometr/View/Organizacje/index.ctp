<?php $this->Combinator->add_libs('css', $this->Less->css('krs', array('plugin' => 'Krs'))) ?>
<?php $this->Combinator->add_libs('js', 'Krs.krs.js') ?>

<div id="krs">
    <div class="search container">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <form class="searchInput" class="searchKRSForm" action="/krs">
                <div class="searchKRS input-group main_input">
                    <input name="q" value="" autocomplete="off" type="text"
                           placeholder="<?php echo __d('krs', 'LC_KRS_SEARCH_PLACEHOLDER'); ?>"
                           class="form-control input-lg">
		                <span class="input-group-btn">
		                      <button class="btn btn-success btn-lg" type="submit" data-icon="&#xe600;"></button>
		                </span>
                </div>
            </form>
        </div>
    </div>

    <div class="resultsList">
        <div class="container">
            <div id="groupsAndResults" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($groups as $index => $group) { ?>
                        <div class="item<?php if ($index == 0) {
                            echo ' active';
                        } ?>">
                            <h2 class="carousel-title"><?= $group['label'] ?></h2>
                            <ul>
                                <?php foreach ($group['content'] as $result) {
                                    echo $this->element('item', array(
                                        'result' => $result,
                                    ));
                                } ?>
                            </ul>
                        </div>
                    <? } ?>
                </div>

                <ol class="carousel-indicators<?php if (count($groups) < 2) {
                    echo ' hidden';
                } ?>">
                    <?php for ($i = 0; $i < count($groups); $i++) { ?>
                        <li data-target="#groupsAndResults"
                            data-slide-to="<?= $i ?>"<? if ($i == 0) { ?> class="active"<? } ?>>
                        </li>
                    <?php } ?>
                </ol>

                <a class="left carousel-control<?php if (count($groups) < 2) {
                    echo ' hidden';
                } ?>" href="#groupsAndResults"
                   data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control<?php if (count($groups) < 2) {
                    echo ' hidden';
                } ?>"
                   href="#groupsAndResults" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>

    <? /*
    <div class="poslowie">
        <div class="container">
            <h3><?= __d('krs', 'LC_KRS_POSLOWIE_HEADLINE') ?></h3>

            <div class="row">
                <div class="blockInfo col-xs-6 col-md-3">
                    <div class="logo">
                        <img class="main" src="http://resources.sejmometr.pl/s_kluby/1_t.png"
                             alt="Platforma Obywatelska"/>
                    </div>
                    <div class="name">Platforma Obywatelska</div>
                    <div class="info">122 NGO / 314 biznes</div>
                    <div class="link">
                        <a href="#"><?= __d('krs', 'LC_KRS_POSLOWIE_BLOCK_LINK') ?></a>
                    </div>
                </div>
                <div class="blockInfo col-xs-6 col-md-3">
                    <div class="logo">
                        <img class="main" src="http://resources.sejmometr.pl/s_kluby/1_t.png"
                             alt="Platforma Obywatelska"/>
                    </div>
                    <div class="name">Platforma Obywatelska</div>
                    <div class="info">122 NGO / 314 biznes</div>
                    <div class="link">
                        <a href="#"><?= __d('krs', 'LC_KRS_POSLOWIE_BLOCK_LINK') ?></a>
                    </div>
                </div>
                <div class="blockInfo col-xs-6 col-md-3">
                    <div class="logo">
                        <img class="main" src="http://resources.sejmometr.pl/s_kluby/1_t.png"
                             alt="Platforma Obywatelska"/>
                    </div>
                    <div class="name">Platforma Obywatelska</div>
                    <div class="info">122 NGO / 314 biznes</div>
                    <div class="link">
                        <a href="#"><?= __d('krs', 'LC_KRS_POSLOWIE_BLOCK_LINK') ?></a>
                    </div>
                </div>
                <div class="blockInfo col-xs-6 col-md-3">
                    <div class="logo">
                        <img class="main" src="http://resources.sejmometr.pl/s_kluby/1_t.png"
                             alt="Platforma Obywatelska"/>
                    </div>
                    <div class="name">Platforma Obywatelska</div>
                    <div class="info">122 NGO / 314 biznes</div>
                    <div class="link">
                        <a href="#"><?= __d('krs', 'LC_KRS_POSLOWIE_BLOCK_LINK') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="poslowieDetails">
        <div class="container">
            <div class="row">
                <div class="blockInfo col-xs-6 col-md-3">
                    <div class="logo">
                        <div class="circle">
                            <img class="main" src="http://resources.sejmometr.pl/s_kluby/1_t.png"
                                 alt="Platforma Obywatelska"/>
                        </div>
                        <img class="addon" src="http://resources.sejmometr.pl/s_kluby/1_a.png"
                             alt="Platforma Obywatelska"/>
                    </div>
                    <div class="name">Platforma Obywatelska</div>
                    <div class="info">122 NGO / 314 biznes</div>
                    <div class="link">
                        <a href="#" target="_self"><?= __d('krs', 'LC_KRS_POSLOWIE_BLOCK_LINK') ?></a>
                    </div>
                </div>
                <div class="blockInfo col-xs-6 col-md-3">
                    <div class="logo">
                        <div class="circle">
                            <img class="main" src="http://resources.sejmometr.pl/s_kluby/1_t.png"
                                 alt="Platforma Obywatelska"/>
                        </div>
                        <img class="addon" src="http://resources.sejmometr.pl/s_kluby/1_a.png"
                             alt="Platforma Obywatelska"/>
                    </div>
                    <div class="name">Platforma Obywatelska</div>
                    <div class="info">122 NGO / 314 biznes</div>
                    <div class="link">
                        <a href="#" target="_self"><?= __d('krs', 'LC_KRS_POSLOWIE_BLOCK_LINK') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    */
    ?>
</div>