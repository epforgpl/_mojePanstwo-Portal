<?php
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highcharts-more');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('js','Admin.timeago');
$this->Combinator->add_libs('js','Admin.refresher');
$this->Combinator->add_libs('css','Admin.Analyzer/view');


$data = json_decode($analyzer['AnalyzerExecution']['data'], true);

$dict = array(
    'org_status' => array(
        'title' => 'Status Organizacji',
        '0' => 'W kolejce do pobrania',
        '1' => 'Aktualnie pobierane',
        '2' => 'Pobrane - OK',

    ),
    'org_status_anl' => array(
        'title' => 'Status Organizacji - Analiza',
        '0' => 'Nieprzetwarzane',
        '1' => 'W kolejce do przetwarzania',
        '3' => 'Przetworzone - OK',
    ),
    'org_status_anl_intro' => array(
        'title' => 'Status Organizacji - Analiza Intro',
        '0' => 'Nieprzetwarzane',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzane',
        '3' => 'OK',
        '4' => 'Brak danych',
        '5' => 'Błąd numeru KRS',
        '6' => 'Błąd danych z działu 0',
        '7' => 'Błąd danych z działu 1',
    ),
    'org_status_anl_addr' => array(
        'title' => 'Status Organizacji - Analiza Adres',
        '0' => 'Nieprzetwarzane',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzane',
        '3' => 'OK',
        '5' => 'Błąd',
    ),
    'org_status_xml' => array(
        'title' => 'Status Organizacji - XML',
        '0' => 'Nieprzetwarzane',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzane',
        '3' => 'OK',
        '4' => 'Brak PDFa',
        '5' => 'Błąd konwersji do XML',
        '6' => 'Brak daty lub działów',
    ),

    'msig_wydania' => array(
        'title' => 'MSIG - Data ostatniego wydania'
    ),

    'msig_con' => array(
        'title' => 'MSIG - Konwersja do tekstu',
        '0' => 'W kolejce do konwertowania',
        '1' => 'Aktualnie konwertowany',
        '2' => 'OK',
        '3' => 'Problem z typem dokumentu',
        '4' => 'Problem z treścią dokumentu',
    ),
    'msig_con_last_err' => array(
        'title' => 'MSIG - Konwersja do tekstu - Ostatni Błąd',
        '3' => 'Problem z typem dokumentu',
        '4' => 'Problem z treścią dokumentu',
    ),
    'msig_con_last_corr' => array(
        'title' => 'MSIG - Konwersja do tekstu - Ostatni Poprawny',
        '2' => 'OK',
    ),

    'msig_proc' => array(
        'title' => 'MSIG - Przetwarzanie spisu treści',
        '0' => 'Nieprzetwarzany',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzany',
        '3' => 'OK',
        '4' => 'Błąd',
    ),
    'msig_proc_last_err' => array(
        'title' => 'MSIG - Przetwarzanie spisu treści - Ostatni Błąd',
        '4' => 'Błąd',
    ),
    'msig_proc_last_corr' => array(
        'title' => 'MSIG - Przetwarzanie spisu treści - Ostatni Poprawny',
        '3' => 'OK',
    ),

    'msig_proc_d' => array(
        'title' => 'MSIG - Przetwarzanie działów',
        '0' => 'Nieprzetwarzany',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzany',
        '3' => 'OK',
        '4' => 'Błąd numeracji stron',
        '5' => 'Błąd nazwy działu',
        '6' => 'Brak pliku wejściowego',
        '7' => 'Błąd konwersji pliku wyjściowego',
        '8' => 'Błąd przesyłu na chmurę',
    ),
    'msig_proc_d_last_err' => array(
        'title' => 'MSIG - Przetwarzanie działów - Ostatni Błąd',
        '4' => 'Błąd numeracji stron',
        '5' => 'Błąd nazwy działu',
        '6' => 'Brak pliku wejściowego',
        '7' => 'Błąd konwersji pliku wyjściowego',
        '8' => 'Błąd przesyłu na chmurę',
    ),
    'msig_proc_d_last_corr' => array(
        'title' => 'MSIG - Przetwarzanie działów - Ostatni Poprawny',
        '3' => 'OK',
    ),

    'msig_proc_d_krs' => array(
        'title' => 'MSIG - Przetwarzanie działów KRS',
        '0' => 'Nieprzetwarzany',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzany',
        '3' => 'OK',
        '4' => 'Błąd nieobsługiwany typ',
        '5' => 'Błąd brak danych',
    ),
    'msig_proc_d_krs_last_err' => array(
        'title' => 'MSIG - Przetwarzanie działów KRS - Ostatni Błąd',
        '4' => 'Błąd nieobsługiwany typ',
        '5' => 'Błąd brak danych',
    ),
    'msig_proc_d_krs_last_corr' => array(
        'title' => 'MSIG - Przetwarzanie działów KRS - Ostatni Poprawny',
        '3' => 'OK',
    ),

    'msig_next_proc_d_krs' => array(
        'title' => 'MSIG - Przetwarzanie wpisów kolejnych',
        '0' => 'Nieprzetwarzany',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzany',
        '3' => 'OK',
        '4' => 'Błąd brak pliku',
        '5' => 'Błąd niepoprawny format treści',
        '6' => 'Błąd brak treści',
    ),
    'msig_next_proc_d_krs_last_err' => array(
        'title' => 'MSIG - Przetwarzanie wpisów kolejnych - Ostatni Błąd',
        '4' => 'Błąd brak pliku',
        '5' => 'Błąd niepoprawny format treści',
        '6' => 'Błąd brak treści',
    ),
    'msig_next_proc_d_krs_last_corr' => array(
        'title' => 'MSIG - Przetwarzanie wpisów kolejnych - Ostatni Poprawny',
        '3' => 'OK'
    ),

    'krs_pos_chg' => array(
        'title' => 'KRS - Przetwarzanie zmian',
        '3' => 'OK',
        '4' => 'Błąd',
    ),
    'krs_pos_chg_last_err' => array(
        'title' => 'KRS - Przetwarzanie zmian - Ostatni Błąd',
        '4' => 'Błąd',
    ),
    'krs_pos_chg_last_corr' => array(
        'title' => 'KRS - Przetwarzanie zmian - Ostatni Poprawny',
        '3' => 'OK',
    ),

    'krs_new' => array(
        'title' => 'KRS - Pobieranie nowych wpisów',
        '-1' => 'Nieprzetwarzane',
        '0' => 'W kolejce do przetwarzania',
        '1' => 'Aktualnie przetwarzane',
        '2' => 'OK',
        '3' => 'OK, brak wyników',
        '4' => 'Błąd nieznany',
        '5' => 'Błąd inny',
        '6' => 'Błąd przesyłu na chmurę',

    ),
    'krs_new_last_err' => array(
        'title' => 'KRS - Pobieranie nowych wpisów - Ostatni Błąd',
        '4' => 'Błąd nieznany',
        '5' => 'Błąd inny',
        '6' => 'Błąd przesyłu na chmurę',
    ),
    'krs_new_last_corr' => array(
        'title' => 'KRS - Pobieranie nowych wpisów - Ostatni Poprawny',
        '2' => 'OK',
        '3' => 'OK, brak wyników',
    ),

    'krs_downloads' => array(
        'title' => 'KRS - Pobrania ze strony'
    ),
);

$jsdict = json_encode($dict);
?>

<?= $this->element('Admin.header'); ?>

<h2>KRS</h2>

<script>
    var dict =<?php echo $jsdict; ?>;
</script>

<?php

foreach ($data as $key => $val) {

    if (strpos($key, 'err') !== false) {

        echo "<div id='$key' class='col-sm-3 label-danger text-white'></div><BR>";

    } elseif (strpos($key, 'corr') !== false) {

        echo "<div id='$key' class='col-sm-3 label-success text-white'></div><BR>";

    } elseif (strpos($key, 'wydania') !== false) {

        echo "<div id='$key' class='col-sm-3 label-info text-white'></div>";

    } elseif (strpos($key, 'downloads') !== false) {
        echo "<div>
                    <div class='col-sm-4' id='krs_downloads_day'></div>
                    <div class='col-sm-4' id='krs_downloads_hour'></div>
                    <div class='col-sm-4' id='krs_downloads_minute'></div>
                </div>";
    } else {
        echo "<div class='col-sm-12'><hr></div><div class='col-sm-9'><div id='$key'></div></div>";
    }
}
?>
<?= $this->element('Admin.footer'); ?>
