<p class="line signature"><?php echo __d('dane', 'LC_DANE_SA_ORZECZENIA_ACCUSED_BODY', true) . ': <strong>' . $item['data']['skarzony_organ_str'] . '</strong>'; ?></p>
<p class="line signature"><?php echo __d('dane', 'LC_DANE_SP_ORZECZENIA_RESULT', true) . ': <strong>' . $item['data']['wynik_str'] . '</strong>'; ?></p>
<?php
$days = null;
$daysOutput = null;
switch ($days = $item['data']['dlugosc_rozpatrywania']) {
    case(($days == 0) || ($days > 1)):
        $daysOutput = $days . ' dni';
        break;
    case($days == 1):
        $daysOutput = $days . ' dzień';
        break;
}
?>
<p class="line signature"><?php echo __d('dane', 'LC_DANE_SP_ORZECZENIA_LENGTH', true) . ': <strong>' . $daysOutput . '</strong>'; ?></p>