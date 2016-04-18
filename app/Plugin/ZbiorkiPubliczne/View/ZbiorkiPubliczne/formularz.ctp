<?
$this->Combinator->add_libs('css', $this->Less->css('zbiorki_publiczne', array('plugin' => 'ZbiorkiPubliczne')));
echo $this->Html->css($this->Less->css('app'));

$this->Combinator->add_libs('js', 'ZbiorkiPubliczne.zbiorki_publiczne.js');

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">
        <div id="zbiorkiPubliczne" class="container">
            <div class="appBanner margin-top-20">
                <h1 class="appTitle">Rozlicz zbiorkę publiczną</h1>
                <p class="appSubtitle">Wypełnij formularz, aby wygenerować dokument rozliczenia zbiórki</p>
            </div>
            <form method="post" action="/zbiorki_publiczne">
                <input type="hidden" name="sprawozdanie" value="<?= $data['sprawozdanie'] ?>"/>
                <input type="hidden" name="skladajacy" value="<?= $data['skladajacy'] ?>"/>
                <input type="hidden" name="zbiorka" value="<?= $data['zbiorka'] ?>"/>
                <?
                foreach ($data as $n => $d) {
                    if (is_array($d)) {
                        foreach ($d as $sub_d) {
                            echo '<input type="hidden" name="' . $n . '[]" value="' . $sub_d . '"/>';
                        }
                    } else {
                        echo '<input type="hidden" name="' . $n . '" value="' . $d . '"/>';
                    }
                }
                ?>
                <div class="sections col-xs-12">
                    <? if ($data['sprawozdanie'] == 'zakonczeniu') {
                        echo $this->Element('ZbiorkiPubliczne.form1');
                    } else {
                        echo $this->Element('ZbiorkiPubliczne.form2');
                    } ?>
                </div>
                <div class="sectionsBtn col-xs-12 text-center">
                    <a href="/zbiorki_publiczne" class="btn btn-link" onclick="confirm('Czy na pewno?')">Anuluj</a>
                    <button class="btn btn-default">Popraw dane</button>
                    <button class="btn btn-primary">Wydrukuj formularz</button>
                </div>
            </form>
        </div>
    </div>
</div>
