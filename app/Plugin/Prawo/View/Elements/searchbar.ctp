<div class="searchBar row">
    <div class="col-lg-8 col-lg-offset-2">
        <form
            action="<?php echo $this->Html->url(array(
                'plugin' => 'ustawy',
                'controller' => 'ustawy',
                'action' => 'search'
            )); ?>"
            method="get">
            <div class="grid-70 prefix-15 suffix-15" id="searchFor">
                <input type="text" name="q" placeholder="<?php echo __('LC_USTAWY_SZUKAJ_USTAWY'); ?>"
                       class="form-control input-lg">
                <button type="submit" data-icon="&#xe600;" class="grid-10">&nbsp;</button>
            </div>

        </form>
    </div>
</div>
