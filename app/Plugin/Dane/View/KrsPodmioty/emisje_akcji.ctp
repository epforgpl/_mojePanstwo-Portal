<?php

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');

if ($emisje = $object->getLayer('emisje_akcji')) {
    ?>
    <div class="mpanel">
        <div style="margin-top: 25px; margin-bottom: 25px;" class="col-md-10 col-md-offset-1">
            <table class="table table-striped table-hover ">
                <thead>
                <tr>
                    <th>Seria</th>
                    <th>Liczba akcji</th>
                    <th>Rodzaj uprzywilejowania</th>
                </tr>
                </thead>
                <tbody>
                <?
                foreach ($emisje as $emisja) {
                    ?>
                    <tr>
                        <td><?= $emisja['seria'] ?></td>
                        <td><?= _number($emisja['liczba']) ?></td>
                        <td><?= $emisja['rodzaj_uprzywilejowania'] ?></td>
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