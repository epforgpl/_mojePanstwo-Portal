<?php

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');

if ($oddzialy = $object->getLayer('oddzialy')) {
    ?>
    <div class="mpanel">
        <div style="margin-top: 25px; margin-bottom: 25px;" class="col-md-10 col-md-offset-1">
            <table class="table table-striped table-hover ">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Adres</th>
                </tr>
                </thead>
                <tbody>
                <?
                foreach ($oddzialy as $oddzial) {
                    ?>
                    <tr>
                        <td><?= $oddzial['nazwa'] ?></td>
                        <td><?= $oddzial['adres'] ?></td>
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