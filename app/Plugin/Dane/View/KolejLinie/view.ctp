<?php
$this->Combinator->add_libs('css', $this->Less->css('view-kolejelinie', array('plugin' => 'Dane')));

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-kolejelinie');
?>

<?php echo $this->Element('dataobject/pageBegin'); ?>
    <div class="object col-md-6">
        <div class="stacje">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><?php echo __d('dane', 'LC_DANE_STACJA'); ?></th>
                    <th><?php echo __d('dane', 'LC_DANE_PRZYJAZD'); ?></th>
                    <th><?php echo __d('dane', 'LC_DANE_ODJAZD'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($object->layers['rozklad'] as $stacja) { ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->Html->url(array(
                                'plugin' => 'Dane',
                                'controller' => 'kolej_stacje',
                                'action' => 'view',
                                'id' => $stacja['a']['stacja_id']
                            )); ?>"><?php echo $stacja['a']['stacja']; ?></a>
                        </td>
                        <td><?php echo $stacja['a']['przyjazd_str']; ?></td>
                        <td><?php echo $stacja['a']['odjazd_str']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="hint">
            <?php echo $object->getData('informacje'); ?>
        </div>
    </div>
    <div class="googleMaps col-md-6">
        <div id="mapa">
            <script type="text/javascript">
                var stationLineData = '<?= json_encode($object->layers['rozklad']) ?>';
            </script>
        </div>
    </div>
<?php echo $this->Element('dataobject/pageEnd'); ?>