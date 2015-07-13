<?php $this->Combinator->add_libs('css', $this->Less->css('searchInPage', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('js', array('Dane.searchInPage')); ?>

<?php if (isset($alerts) && !empty($alerts)) { ?>
    <div id="searchInPage">
        <a class="slider" href="#slide"></a>

        <div class="searchInPageContent">
            <a href="#" class="brand">Odnalezione słowa</a>
            <ul class="nav">
                <?php foreach ($alerts as $alert) { ?>
                    <li>
                        <a href="#<?php echo $alert ?>"><?php echo $alert ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>