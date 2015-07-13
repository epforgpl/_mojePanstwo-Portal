<?php

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');

if ($kultura = $object->getLayer('kultura')) {
    ?>
    <div class="mpanel">

        <h2 class="text-center">Działalności</h2>

        <div style="margin-top: 10px; margin-bottom: 25px;" class="col-md-10 col-md-offset-1">
            <table class="table table-striped table-hover ">
                <thead>
                <tr>
                    <th>Symbol</th>
                    <th>Nazwa</th>
                    <th>Indeks</th>
                    <th>Punktacja</th>
                </tr>
                </thead>
                <tbody>
                <?
                foreach ($kultura['dzialalnosci'] as $dzialalnosc) {
                    ?>
                    <tr>
                        <td><?= $dzialalnosc['podklasa'] ?></td>
                        <td><?= $dzialalnosc['nazwa'] ?></td>
                        <td><?= $dzialalnosc['indeks_nazwa'] ?></td>
                        <td><?= $dzialalnosc['score'] ?></td>
                    </tr>
                <?
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?
}

echo $this->Element('dataobject/pageEnd');