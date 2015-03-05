<div class="tabsBlock">
    <ul class="tabsList col-xs-12 col-sm-10 col-md-9">
        <li data-mode="1"
            class="new<?php if (isset($this->request->query['mode']) == false || $this->request->query['mode'] == '1') {
                echo ' s';
            } ?>"
            title="new">
            <a href="<?php
            echo $this->Html->url(array(
                "controller" => "powiadomienia",
                "action" => "index",
                "?" => array(
                    "mode" => "1",
                    "group_id" => (isset($this->request->query['group_id'])) ? $this->request->query['group_id'] : null
                )
            )) ?>"
               data-icon="&#xe602;"><?php echo __d('powiadomienia', "LC_POWIADOMIENIA_DANE_NEW") ?>
                <?php
                /*
                * @TODO: fix this or remove permamently
                <small<?php $tempNumber = 9;
                    if ($tempNumber > 0) {
                        echo ' nonzero';
                    } ?>>
                    <?php if ($tempNumber > 999) {
                        echo '999+';
                    } else {
                        echo $tempNumber;
                    } ?>
                </small>
                 */
                ?>
            </a>
            <?php /*<input type="submit" name="data[Dataobject][visited]" value="0"/>*/ ?>
        </li>
        <li data-mode="2"
            class="read<?php if (isset($this->request->query['mode']) && $this->request->query['mode'] == '2') {
                echo ' s';
            } ?>"
            title="read">
            <a href="<?php echo $this->Html->url(array(
                "controller" => "powiadomienia",
                "action" => "index",
                "?" => array(
                    "mode" => "2",
                    "group_id" => (isset($this->request->query['group_id'])) ? $this->request->query['group_id'] : null
                )
            )) ?>"
               data-icon="&#xe603;"><?php echo __d('powiadomienia', "LC_POWIADOMIENIA_DANE_READ") ?></a>
            <?php /* <input type="submit" name="data[Dataobject][visited]" value="1"/> */ ?>
        </li>
    </ul>
    <div class="additionalOptions hidden-xs col-sm-2 col-md-3">
        <div class="btn-group options show">
            <button data-toggle="dropdown"
                    class="btn btn-success btn-xs dropdown-toggle pull-right"
                    data-icon="&#xe612;">
            </button>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a class="markReadAfterThreeSecContent" href="#">
                        <label class="markReadAfterThreeSec">
                            <input type="checkbox" autocomplete="off"
                                   id="markReadAfterThreeSec"/><?php echo __d('powiadomienia', 'LC_POWIADOMIENIA_OPTIONS_AUTOCHECK_AS_READER') ?>
                        </label>
                    </a>
                </li>
                <li>
                    <a class="markAllAsRead" href="#"
                       data-groupid="<?php echo(isset($this->request->query['group_id']) ? $this->request->query['group_id'] : null); ?>">
                        <?php echo (isset($this->request->query['group_id'])) ? __d('powiadomienia', 'LC_POWIADOMIENIA_OPTIONS_MARK_ALL_READED_KEYWORD') : __d('powiadomienia', 'LC_POWIADOMIENIA_OPTIONS_MARK_ALL_READED') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>