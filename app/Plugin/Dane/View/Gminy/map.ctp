<?php
$this->Combinator->add_libs('css', $this->Less->css('view-gminy_mapa', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-gminy_mapa');
?>

<?php echo $this->Element('dataobject/pageBegin'); ?>
    <div class="object col-md-12">
        <div class="controlButtons">
            <button class="btn btn-default centerMap"><?php echo __d('dane', 'LC_GMINY_MAPA_CENTER'); ?></button>
            <button class="btn btn-default fullScrMap"
                    data-mode="box"><?php echo __d('dane', 'LC_GMINY_MAPA_FULL_SCREEN'); ?></button>
        </div>

        <div id="mapa">
            <script type="text/javascript">
                var _SPAT = <?php echo json_encode($object->getLayers('enspat')); ?>;
            </script>
        </div>
    </div>
<?php echo $this->Element('dataobject/pageEnd'); ?>