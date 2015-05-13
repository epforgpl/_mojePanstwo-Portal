<?
$title = trim($result['nazwa']);
$titleLen = strlen($title);

$strs = array(
    'SPÓŁKA Z OGRANICZONĄ ODPOWIEDZIALNOŚCIĄ SPÓŁKA KOMANDYTOWA',
    'SPÓŁKA Z OGRANICZONĄ ODPOWIEDZIALNOŚCIĄ W LIKWIDACJI',
    'SPÓŁKA Z OGRANICZONĄ ODPOWIEDZIALNOŚCIĄ',
    'SPÓŁKA JAWNA',
);

foreach ($strs as $str) {
    if (endsWith($title, $str)) {
        $title = substr($title, 0, $titleLen - strlen($str));
        break;
    }
}


$title = trim($title);
?>
<li>
    <a class="icon <?php if ($result['type'] == 'organization') {
        echo "organization";
    } else {
        echo "person";
    } ?>" href="<?php if ($result['type'] == 'organization') {
        echo('/dane/krs_podmioty/' . $result['id']);
    } elseif ($result['type'] == 'person') {
        echo('/dane/krs_osoby/' . $result['id']);
    } ?>" target="_self">
        <p class="title">
            <?php echo $title ?>
        </p>

        <p class="subtitle">
            <?
            if ($result['type'] == 'organization') {

                $parts = array(
                    $result['miejscowosc']
                );

                if ($result['kapital_zakladowy']) {
                    // setlocale(LC_MONETARY, 'pl_PL');
                    // $parts[] = money_format('%i', $result['kapital_zakladowy']);
                    $parts[] = number_format_h($result['kapital_zakladowy']) . ' PLN';
                }

                $wiek = pl_wiek($result['data_rejestracji']);

                if ($wiek) {
                    $parts[] = pl_dopelniacz($wiek, 'rok', 'lata', 'lat');
                } else {
                    $parts[] = '< 1 rok';
                }

                echo implode(' <span class="separator">|</span> ', $parts);

            } elseif ($result['type'] == 'person') {
                echo pl_dopelniacz($result['wiek'], 'rok', 'lata', 'lat');
            }
            ?>
        </p>
    </a>
</li>