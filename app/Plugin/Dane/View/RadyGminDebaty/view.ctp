<?php $this->Combinator->add_libs('css', $this->Less->css('view-radygmindebaty', array('plugin' => 'Dane'))); ?>

<?php $this->Combinator->add_libs('js', 'Dane.view-radygmindebaty'); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="col-md-12 row">
        <div class="object mpanel">
            <div class="col-md-7">
                <div class="ytVideo">
                    <div id="pb_player" data-youtube="<?php echo $object->getData('yt_video_id'); ?>"></div>
                </div>
            </div>
            <div class="col-md-5 wystapienia">
                <h2><?php echo $object->getData('opis'); ?></h2>

                <h3><?php echo __d('dane', 'LC_RADYGMINDEBATY_WYSTAPIENIA'); ?></h3>
                <ul class="nav nav-pills nav-stacked">
                    <?php foreach ($wystapienia as $id => $wystapienie) { ?>
                        <li>
                            <a data-video-position="<?php echo $wystapienie['video_start']; ?>"
                               href="#<?php echo $id; ?>">
                                <span><?php echo (date('H', $wystapienie['video_start']) - 1) . date(':i:s', $wystapienie['video_start']); ?></span> <?php echo $wystapienie['mowca_str']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>