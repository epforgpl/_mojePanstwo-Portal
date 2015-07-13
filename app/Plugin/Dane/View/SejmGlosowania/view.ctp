<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-sejmglosowania'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('view-sejmglosowania', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin') ?>

<?
$wynikiKlubowe = $object->loadLayer('wynikiKlubowe');
$chartData = array(
    array(
        'id' => 'z',
        'count' => $object->getData('z'),
        'label' => 'Za',
    ),
    array(
        'id' => 'p',
        'count' => $object->getData('p'),
        'label' => 'Przeciw',
    ),
    array(
        'id' => 'w',
        'count' => $object->getData('w'),
        'label' => 'Wstrzymania',
    ),
    array(
        'id' => 'n',
        'count' => $object->getData('n'),
        'label' => 'Nieobecności',
    ),
);
$dictionary = array(
    '1' => array('Za', 'z'),
    '2' => array('Przeciw', 'p'),
    '3' => array('Wstrzymanie', 'w'),
    '4' => array('Brak kworum', 'n'),
);
?>

    <div class="object glosowanie_stats">

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 sejm_glosowania">
                <p class="wynikGlosowania <?= $dictionary[$object->getData('wynik_id')][1]; ?> label"><?= $dictionary[$object->getData('wynik_id')][0]; ?></p>

                <div class="highchart" data-wynikiKlubowe='<?= json_encode($chartData) ?>'></div>

            </div>
        </div>
        <div class="col-xs-12">
            <div class="block">
                <h2><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_HEADER') ?></h2>

                <table class="clubTable table">
                    <colgroup>
                        <col span="3">
                        <col class="colSearch-4">
                        <col class="colSearch-1">
                        <col class="colSearch-2">
                        <col class="colSearch-3">
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_NAZWAKLUBU') ?></th>
                        <th><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_LICZEBNOSCKLUBU') ?></th>
                        <th><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_LICZBAGLOSUJACYCH') ?></th>
                        <th class="searchableVote"
                            data-search="4"><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_NIEOBECNI') ?></th>
                        <th class="searchableVote"
                            data-search="1"><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_ZA') ?></th>
                        <th class="searchableVote"
                            data-search="2"><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_PRZECIW') ?></th>
                        <th class="searchableVote"
                            data-search="3"><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_WSTRZYMALISIE') ?></th>
                        <th><?= __d('dane', 'LC_SEJMGLOSOWANIA_KLUBY_LICZBABUNTOW') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($object->getLayer('wynikiKlubowe') as $row) { ?>
                        <tr>
                            <td class="club" data-club-id="<?= $row['klub_id'] ?>">
                                <? if ($row['klub_id'] != '7') { ?>
                                    <img src="http://resources.sejmometr.pl/s_kluby/<?= $row['klub_id'] ?>_a.png"
                                         alt="<?= $row['klub_nazwa'] ?>" onerror="imgFixer(this)"/>
                                <? } ?>
                                <strong><?= $row['klub_nazwa'] ?></strong>
                            </td>
                            <td><?= $row['l'] ?></td>
                            <td><?= $row['g'] ?></td>
                            <td><?= $row['n'] ?></td>
                            <td><?= $row['z'] ?></td>
                            <td><?= $row['p'] ?></td>
                            <td><?= $row['w'] ?></td>
                            <td><?= $row['b'] ?></td>
                        </tr>
                    <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="block indywidualneTable">
                <h2><?= __d('dane', 'LC_SEJMGLOSOWANIA_INDYWIDUALNE_HEADER') ?></h2>

                <div class="input-group searchName col-xs-12 col-md-6">
                    <input type="text" class="form-control" autocomplete="off"
                           placeholder="<?= __d('dane', 'LC_SEJMGLOSOWANIA_INDYWIDUALNE_HEADER_SEARCH_PLACEHOLDER') ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" data-icon="&#xe601;"></button>
                    </span>
                </div>
                <div class="results col-xs-12">
                    <? foreach ($object->getLayer('wynikiIndywidualne') as $person) { ?>
                        <div class="slide col-xs-6 col-md-4">
                            <div class="person">
                                <div class="avatar">
                                    <img onerror="imgFixer(this)"
                                         src="http://resources.sejmometr.pl/mowcy/a/0/<?= $person['mowcy']['mowca_id'] ?>.jpg"
                                         alt="<?= $person['poslowie']['nazwa'] ?>"/>
                                </div>
                                <div class="info">
                                    <a class="poselName" href="<?= $person['poslowie']['id'] ?>"
                                       target="_self"><?= $person['poslowie']['nazwa'] ?></a>
                                    <a class="clubName" href="<?= $person['kluby']['id'] ?>" target="_self"
                                       title="<?= $person['kluby']['nazwa'] ?>"
                                       data-club-id="<?= $person['kluby']['id'] ?>">
                                        <img onerror="imgFixer(this)"
                                             src="http://resources.sejmometr.pl/s_kluby/<?= $person['kluby']['id'] ?>_a.png"
                                             alt="<?= $person['kluby']['nazwa'] ?>"/>
                                    </a>
                                </div>
                            </div>
                            <div class="voted btn btn-default btn-glos-<?= $person['glosy']['glos_id'] ?>"
                                 data-glos="<?= $person['glosy']['glos_id'] ?>"><?= $person['glosy']['glos_str'] ?></div>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>

    </div>

<?= $this->Element('dataobject/pageEnd') ?>