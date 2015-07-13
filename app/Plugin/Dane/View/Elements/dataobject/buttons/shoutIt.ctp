<div class="shoutIt hide">
    <button class="btn btn-default btn-sm shoutItButton"
            type="button"><span
            class="glyphicon glyphicon-share"></span> <?php echo __d('dane', 'LC_DANE_NAGLOSNIJ'); ?></button>

    <div class="shoutItContent">
        <div class="facebookBox">
            <div id="fb-root"></div>
            <div class="fb-like" data-href="<?php echo Router::url($this->here, true); ?>"
                 data-send="false"
                 data-layout="button_count"
                 data-action="<?php if (Configure::read('Config.language') == 'pol') {
                     echo('recommend');
                 } else {
                     echo('like');
                 } ?>"
                 data-width="85"
                 data-show-faces="false">
            </div>
        </div>
        <div class="twitterBox">
            <div class="tweet">
                <a href="https://twitter.com/share" class="twitter-share-button"
                   data-url="<?php echo Router::url($this->here, true); ?>"
                   data-lang="<?php if (Configure::read('Config.language') == 'pol') {
                       echo('pl');
                   } else {
                       echo('en');
                   } ?>">Tweet</a>
            </div>
        </div>
        <div class="wykopBox">
            <div class="wykop-button"
                 data-href="<?php echo Router::url($this->here, true); ?>"></div>
        </div>
    </div>
</div>