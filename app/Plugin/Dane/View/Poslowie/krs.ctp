<?
$this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-poslowie.js');

echo $this->Element('dataobject/pageBegin');
?>


    <div class="krs row">


        <div class="col-lg-10 col-lg-offset-1 objectMain">
            <div class="object">

                <?=
                $this->Element('Dane.objects/krs_osoby/organizacje', array(
                    'organizacje' => $subobject->getLayer('organizacje'),
                )); ?>

            </div>
        </div>

    </div>






<?= $this->Element('dataobject/pageEnd'); ?>