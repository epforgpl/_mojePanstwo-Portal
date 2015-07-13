<?php $this->Combinator->add_libs('css', $this->Less->css('view-sejmwystapienia', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="col-md-10 col-md-offset-1">
        <div class="object row">
            <div class="document col-md-10 col-md-offset-1">
                <blockquote>
                    <?php echo $html['SejmWystapienia']['o_txt']; ?>
                </blockquote>
            </div>
            <?php if ($object->getData('video')) { ?>
                <?php $this->Combinator->add_libs('js', 'Dane.view-sejmwystapienia'); ?>

                <div class="ytVideo col-md-10 col-md-offset-1">
                    <div id="pb_player" data-youtube="<?php echo $object->getData('yt_id'); ?>"></div>
                </div>
            <?php } ?>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>