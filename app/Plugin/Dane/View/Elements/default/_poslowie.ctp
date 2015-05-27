<?php if ($item['data']['klub_id'] != '7') { ?>
    <p class="line club">
        <a href="/dane/sejm_kluby/<?php echo $item['data']['klub_id'] ?>"<?php if (isset($item['data']['sejm_kluby.nazwa'])) { ?> title="<?= $item['data']['sejm_kluby.nazwa'] ?>"<?php } ?>>
            <object data="/error/brak.gif" type="image/png">
                <img
                    src="http://resources.sejmometr.pl/s_kluby/<?php echo $item['data']['klub_id'] ?>_a_t.png"<?php if (isset($item['data']['sejm_kluby.nazwa'])) { ?>
                    alt="<?php if (isset($item['data']['sejm_kluby.nazwa'])) {
                        echo $item['data']['sejm_kluby.nazwa'];
                    } else {
                        ' ';
                    }
                    }; ?>"/>
            </object>
        </a>
    </p>
<?php } ?>

<?php if (isset($item['layers']['posiedzenia_poslowie'])) { ?>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_POSLOWIE_ATTENDANCE', true) . ': <strong>' . $item['layers']['posiedzenia_poslowie']['frekwencja'] . ' %</strong>'; ?></p>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_POSLOWIE_ABANDONED_VOTING', true) . ': <strong>' . $item['layers']['posiedzenia_poslowie']['ilosc_opuszczonych_glosow'] . '</strong>'; ?></p>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_POSLOWIE_AMOUNT_MUTINIES', true) . ': <strong>' . $item['layers']['posiedzenia_poslowie']['ilosc_buntow'] . '</strong>'; ?></p>
<?php } else { ?>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_POSLOWIE_PROFESSION', true) . ': <strong>' . $item['data']['zawod'] . '</strong>'; ?></p>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_AGE', true) . ': <strong>' . $this->Czas->wiek($item['data']['data_urodzenia']) . '</strong>'; ?></p>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_POSLOWIE_VOTING_ATTENDENCE', true) . ': <strong>' . $item['data']['frekwencja'] . ' %</strong>'; ?></p>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_POSLOWIE_REBELS', true) . ': <strong>' . $item['data']['zbuntowanie'] . ' %</strong>'; ?></p>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_POSLOWIE_AMOUNT_PERFORMANCES', true) . ': <strong>' . $item['data']['liczba_wypowiedzi'] . '</strong>'; ?></p>
    <p class="col-xs-12 col-sm-6 col-md-4 signature"><?php echo __d('dane', 'LC_DANE_POSLOWIE_AMOUNT_BILLS', true) . ': <strong>' . $item['data']['liczba_projektow_ustaw'] . '</strong>'; ?></p>
<?php } ?>