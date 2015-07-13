<?php $this->Combinator->add_libs('css', $this->Less->css('view-miejscowosci', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="object">
        <div class="document col-md-10 col-md-offset-1">
            <table class="table table stripped">
                <tr>
                    <th><?php echo __d('dane', 'LC_DANE_MIEJSCOWOSC_GMINA'); ?></th>
                    <td>
                        <a href="<?php echo $this->Html->url(array(
                            'plugin' => 'Dane',
                            'controller' => 'gminy',
                            'action' => 'view',
                            'id' => $object->getData('gminy.id')
                        )); ?>"><?php echo $object->getData('gminy.nazwa'); ?></a>
                    </td>
                </tr>
                <tr>
                    <th><?php echo __d('dane', 'LC_DANE_MIEJSCOWOSC_POWIAT'); ?></th>
                    <td><?php echo ucfirst($obszary[0]['Powiat']['nazwa']); ?></td>
                </tr>
                <tr>
                    <th><?php echo __d('dane', 'LC_DANE_MIEJSCOWOSC_WOJEWODZTWO'); ?></th>
                    <td><?php echo $obszary[0]['Wojewodztwo']['nazwa']; ?></td>
                </tr>
            </table>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>