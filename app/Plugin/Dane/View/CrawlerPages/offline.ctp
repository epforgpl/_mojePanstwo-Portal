<?php $this->Combinator->add_libs('css', $this->Less->css('view-crawlerpages', array('plugin' => 'Dane'))) ?>
<?php echo $this->Element('dataobject/pageBegin'); ?>

    <div class="offline_content mpanel">
        <?php
        $html = $offline['html'];
        $html = str_replace(array("\n", "\r", "\t"), '', $html);

        $tags_to_strip = array('script', 'style', 'link', 'meta', 'head', 'title');

        foreach ($tags_to_strip as $tag) {
            $html = preg_replace('/<' . $tag . '[^>]*>(.*?)<\/' . $tag . '/i', '', $html);
            $html = preg_replace('/<' . $tag . '[^>]*\>/i', '', $html);
        }

        echo $html;
        ?>
    </div>

<?php echo $this->Element('dataobject/pageEnd'); ?>