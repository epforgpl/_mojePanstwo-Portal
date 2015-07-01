<div class="agg agg-List">

    <? if ($data['buckets']) { ?>
        <ul class="nav nav-pills nav-stacked">
            <? foreach ($data['buckets'] as $b) { ?>
                <li>
                    <?
									
                    if (is_array($b['label']['buckets'][0]['key']['label'])) {

                        $href = $b['label']['buckets'][0]['key']['label'][0];
                        $label = $b['label']['buckets'][0]['key']['label'][1];

                        if (isset($object)) {
                            $href = $object->getUrl() . '/' . $href;
                        }

                    } else {

                        $href = '/dane/' . $b['key'];
                        $label = $b['label']['buckets'][0]['key']['label'];

                    }

                    if (isset($this->request->query['q']))
                        $href .= "?q=" . $this->request->query['q'];

                    ?>



                    <a href="<?= $href ?>"><?= $label ?><? if (isset($b['doc_count'])) { ?> <span
                            class="badge"><?= $b['doc_count'] ?></span><? } ?></a>
                </li>
            <? } ?>
        </ul>
    <? } ?>
</div>
