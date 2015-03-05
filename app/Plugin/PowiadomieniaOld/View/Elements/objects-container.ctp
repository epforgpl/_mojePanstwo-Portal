<div class="dataContent">
    <div class="results">
        <div class="showResults">
            <div class="objects">
                <?php if (true) { //@ TODO : przywrocic?>
                    <div
                        class="powiadomienia">
                        <? echo $this->element('objects', array(
                            'objects' => $objects,
                        )); ?>
                    </div>
                    <div class="loadMoreContent" data-currentpage="1"
                         data-mode="<?php echo(isset($this->request->query['mode']) ? $this->request->query['mode'] : 1); ?>"
                         data-groupid="<?php echo(isset($this->request->query['group_id']) ? $this->request->query['group_id'] : null); ?>"></div>
                    <div class="loading"></div>
                <?php } else { ?>
                    <div class="msg">
                        <p><?php echo __d('powiadomienia', "LC_POWIADOMIENIA_DANE_NO_KEYWORDS") ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>