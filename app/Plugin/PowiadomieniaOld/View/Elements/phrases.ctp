<div class="keywords">
    <label><?php echo __d('powiadomienia', "LC_POWIADOMIENIA_FRAZY_USER") ?>:</label>
    <button class="btn btn-success btn-sm addphrase pull-right" data-toggle="modal" data-target="#addPhraseModal">+
    </button>
    <div class="modal fade" id="addPhraseModal" role="dialog"
         aria-labelledby="<?php echo __d('powiadomienia', 'LC_POWIADOMIENIA_FRAZY_DODAJ_FRAZE') ?>"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"
                        id="myModalLabel"><?php echo __d('powiadomienia', 'LC_POWIADOMIENIA_FRAZY_DODAJ_FRAZE') ?></h4>
                </div>
                <div class="modal-body">
                    <div class="input-group addNewPhrase">
                        <input type="text" class="form-control" value=""
                               placeholder="<?php echo __d('powiadomienia', 'LC_POWIADOMIENIA_FRAZY_DODAJ_FRAZE_PLACEHOLDER') ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">+</button>
                        </span>
                    </div>
                    <div class="error alert alert-warning hide"></div>
                </div>
                <?php /* <div class="modal-footer"></div> */ ?>
            </div>
        </div>
    </div>
    <ul>
        <?php if ($groups) {
            foreach ($groups as $index => $group) {
                ?>
                <li class="<?php if (isset($this->request->query['keyword']) == false || $this->request->query['keyword'] == $phrase['Phrase']['id']) {
                    echo 's';
                } ?><?php if ($phrase['UserPhrase']['alerts_unread_count']) {
                    ?> nonzero<?php } ?>"
                    data-id="<?php echo $phrase['Phrase']['id']; ?>"
                    title="<?php echo str_replace('"', '', $phrase['Phrase']['q']); ?>">
                    <div class="inner radio-inline">
                        <input type="radio" name="data[Dataobject][ids]"
                               id="PowiadomieniaFrazaId<?php echo $index ?>"
                               value="<?php echo $phrase['Phrase']['id']; ?>"
                            <?php echo (isset($this->data['Dataobject']['ids']) && $this->data['Dataobject']['ids'] == $phrase['Phrase']['id']) ? 'checked' : null; ?>/>
                        <label for="PowiadomieniaFrazaId<?php echo $index ?>">
                            <a class="wrap"
                                <?php if (isset($this->request->query['keyword']) && ($this->request->query['keyword'] == $phrase['Phrase']['id'])) { ?>
                                    href="<?php echo $this->Html->url(array(
                                        "controller" => "powiadomienia",
                                        "action" => "index",
                                        "?" => array("mode" => (isset($this->request->query['mode'])) ? $this->request->query['mode'] : null)
                                    )) ?>"
                                <?php } else { ?>
                                    href="<?php echo $this->Html->url(array(
                                        "controller" => "powiadomienia",
                                        "action" => "index",
                                        "?" => array(
                                            "keyword" => $phrase['Phrase']['id'],
                                            "mode" => (isset($this->request->query['mode'])) ? $this->request->query['mode'] : null
                                        )
                                    )) ?>"
                                <?php } ?>
                               target="_self">
                                <?php echo $phrase['Phrase']['q']; ?>
                            </a>

                            <div class="count">
                                <span
                                    class="badge<?php if ($phrase['UserPhrase']['alerts_unread_count'] > 0) { ?> nonzero<?php } ?>">
                                    <?= $phrase['UserPhrase']['alerts_unread_count']; ?>
                                </span>
                            </div>
                            <a href="#options" class="options" data-icon="&#xe612;"></a>
                        </label>
                    </div>
                </li>
            <?
            }
        } ?>

        <span class="nokeywords<?php if ($phrases != null) {
            echo ' hidden';
        } ?>"><?php echo __d('powiadomienia', "LC_POWIADOMIENIA_FRAZY_NOKEYWORDS") ?><span>

    </ul>

    <? // <button class="btn btn-primary">Filtruj</button> ?>

</div>