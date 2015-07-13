<?php if ($item['data']['izby_str'] !== '') { ?>
    <p class="line signature"><?php echo __d('dane', 'LC_DANE_SN_ORZECZENIA_CHAMBER', true) . ': <strong>' . $item['data']['izby_str'] . '</strong>'; ?></p>
<?php } ?>

<?php if ($item['data']['przewodniczacy'] !== '') { ?>
    <p class="line signature"><?php echo __d('dane', 'LC_DANE_SN_ORZECZENIA_CHAIRMAN', true) . ': <strong>' . $item['data']['przewodniczacy'] . '</strong>'; ?></p>
<?php } ?>

<?php if (($item['data']['przewodniczacy'] !== $item['data']['sprawozdawcy_str']) && ($item['data']['sprawozdawcy_str'] !== '')) { ?>
    <p class="line signature"><?php echo __d('dane', 'LC_DANE_SN_ORZECZENIA_RAPPORTEURS', true) . ': <strong>' . $item['data']['sprawozdawcy_str'] . '</strong>'; ?></p>
<?php } ?>

<?php if ($item['data']['wspolsprawozdawcy_str'] !== '') { ?>
    <p class="line signature"><?php echo __d('dane', 'LC_DANE_SN_ORZECZENIA_CORAPPORTEURS', true) . ': <strong>' . $item['data']['wspolsprawozdawcy_str'] . '</strong>'; ?></p>
<?php } ?>
